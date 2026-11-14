<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_shows_only_selected_products_and_keeps_other_cart_items(): void
    {
        [$selectedProduct, $otherProduct] = $this->createProducts();
        $cart = [
            $selectedProduct->id => $this->cartItem($selectedProduct, 2),
            $otherProduct->id => $this->cartItem($otherProduct, 1),
        ];
        $this->withSession(['cart' => $cart]);

        $this->post(route('checkout.start'), ['items' => [$selectedProduct->id]])
            ->assertRedirect(route('checkout.index'));

        $this->get(route('checkout.index'))
            ->assertOk()
            ->assertSee($selectedProduct->name)
            ->assertDontSee($otherProduct->name)
            ->assertSee('Rp 60.000')
            ->assertSee('BCA')
            ->assertSee('QRIS')
            ->assertSee('Kartu Kredit');

        $this->assertSame($cart, session('cart'));
    }

    public function test_checkout_requires_at_least_one_selected_product(): void
    {
        $this->withSession(['cart' => [1 => ['name' => 'Produk', 'quantity' => 1, 'price' => 1000]]])
            ->from(route('cart.index'))
            ->post(route('checkout.start'), ['items' => []])
            ->assertRedirect(route('cart.index'))
            ->assertSessionHasErrors('items');
    }

    public function test_place_order_uses_only_selected_items_and_keeps_unselected_items_in_cart(): void
    {
        [$selectedProduct, $otherProduct] = $this->createProducts();
        $cart = [
            $selectedProduct->id => $this->cartItem($selectedProduct, 2),
            $otherProduct->id => $this->cartItem($otherProduct, 1),
        ];
        $this->withSession([
            'cart' => $cart,
            'checkout_items' => [(string) $selectedProduct->id],
        ]);

        $this->post(route('checkout.place'), [
            'recipient_name' => 'Ayu Silaen',
            'phone' => '081234567890',
            'address' => 'Dusun Nadeak, Silaen',
            'shipping_method' => 'reguler',
            'payment_method' => 'cod',
        ])->assertRedirect();

        $order = Order::with('items')->firstOrFail();
        $this->assertSame('cod', $order->payment_method);
        $this->assertSame(8000, $order->shipping_cost);
        $this->assertEquals(68000, $order->total);
        $this->assertCount(1, $order->items);
        $this->assertSame($selectedProduct->name, $order->items->first()->product_name);
        $this->assertSame(3, $selectedProduct->fresh()->stock);
        $this->assertSame(5, $otherProduct->fresh()->stock);
        $this->assertSame([$otherProduct->id], array_keys(session('cart')));
        $this->assertNull(session('checkout_items'));
    }

    public function test_bank_transfer_order_confirmation_explains_manual_payment(): void
    {
        [$product] = $this->createProducts();
        $this->withSession([
            'cart' => [$product->id => $this->cartItem($product, 1)],
            'checkout_items' => [(string) $product->id],
        ]);

        $this->post(route('checkout.place'), [
            'recipient_name' => 'Ayu Silaen',
            'phone' => '081234567890',
            'address' => 'Dusun Nadeak, Silaen',
            'shipping_method' => 'hemat',
            'payment_method' => 'bank_transfer',
            'payment_channel' => 'bca',
        ])->assertRedirect();

        $order = Order::firstOrFail();
        $this->assertSame('bca', $order->payment_channel);

        $this->get(route('checkout.confirmation', $order->order_number))
            ->assertOk()
            ->assertSee($order->order_number)
            ->assertSee('BCA')
            ->assertSee('belum terhubung ke payment gateway');
    }

    public function test_qris_and_credit_card_demo_methods_can_be_saved_without_card_data(): void
    {
        [$product] = $this->createProducts();

        foreach (['qris', 'credit_card'] as $paymentMethod) {
            $this->withSession([
                'cart' => [$product->id => $this->cartItem($product, 1)],
                'checkout_items' => [(string) $product->id],
            ]);

            $this->post(route('checkout.place'), [
                'recipient_name' => 'Ayu Silaen',
                'phone' => '081234567890',
                'address' => 'Dusun Nadeak, Silaen',
                'shipping_method' => 'hemat',
                'payment_method' => $paymentMethod,
            ])->assertRedirect();

            $order = Order::latest('id')->firstOrFail();
            $this->assertSame($paymentMethod, $order->payment_method);
            $this->assertNull($order->payment_channel);
        }

        $this->assertDatabaseCount('orders', 2);
    }

    public function test_bank_transfer_requires_a_supported_bank_selection(): void
    {
        [$product] = $this->createProducts();
        $this->withSession([
            'cart' => [$product->id => $this->cartItem($product, 1)],
            'checkout_items' => [(string) $product->id],
        ]);

        $this->from(route('checkout.index'))
            ->post(route('checkout.place'), [
                'recipient_name' => 'Ayu Silaen',
                'phone' => '081234567890',
                'address' => 'Dusun Nadeak, Silaen',
                'shipping_method' => 'hemat',
                'payment_method' => 'bank_transfer',
                'payment_channel' => 'unknown_bank',
            ])
            ->assertRedirect(route('checkout.index'))
            ->assertSessionHasErrors('payment_channel');

        $this->assertDatabaseCount('orders', 0);
    }

    public function test_order_is_not_created_when_selected_product_stock_is_no_longer_available(): void
    {
        [$product] = $this->createProducts();
        $product->update(['stock' => 1]);
        $this->withSession([
            'cart' => [$product->id => $this->cartItem($product, 2)],
            'checkout_items' => [(string) $product->id],
        ]);

        $this->from(route('checkout.index'))
            ->post(route('checkout.place'), [
                'recipient_name' => 'Ayu Silaen',
                'phone' => '081234567890',
                'address' => 'Dusun Nadeak, Silaen',
                'shipping_method' => 'hemat',
                'payment_method' => 'cod',
            ])
            ->assertRedirect(route('cart.index'))
            ->assertSessionHasErrors('items');

        $this->assertDatabaseCount('orders', 0);
        $this->assertSame(1, $product->fresh()->stock);
    }

    public function test_removing_a_product_immediately_removes_it_from_the_cart(): void
    {
        [$product, $otherProduct] = $this->createProducts();
        $this->withSession([
            'cart' => [
                $product->id => $this->cartItem($product, 1),
                $otherProduct->id => $this->cartItem($otherProduct, 1),
            ],
        ]);

        $this->delete(route('cart.remove'), ['id' => $product->id])
            ->assertRedirect(route('cart.index'))
            ->assertSessionHas('success', 'Produk berhasil dihapus dari keranjang.');

        $this->assertArrayNotHasKey($product->id, session('cart'));
        $this->assertArrayHasKey($otherProduct->id, session('cart'));
    }

    private function createProducts(): array
    {
        $category = Category::create([
            'name' => 'Kategori Checkout',
            'slug' => 'kategori-checkout',
        ]);

        return [
            Product::create([
                'category_id' => $category->id,
                'name' => 'Produk Pilihan',
                'slug' => 'produk-pilihan',
                'price' => 30000,
                'stock' => 5,
            ]),
            Product::create([
                'category_id' => $category->id,
                'name' => 'Produk Tidak Dipilih',
                'slug' => 'produk-tidak-dipilih',
                'price' => 20000,
                'stock' => 5,
            ]),
        ];
    }

    private function cartItem(Product $product, int $quantity): array
    {
        return [
            'name' => $product->name,
            'quantity' => $quantity,
            'price' => $product->price,
            'image' => null,
        ];
    }
}
