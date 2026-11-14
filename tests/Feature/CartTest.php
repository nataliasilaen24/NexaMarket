<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    public function test_customer_can_add_a_selected_quantity_to_the_cart(): void
    {
        $product = $this->createProduct(stock: 8);

        $this->post(route('cart.add', $product), ['quantity' => 3])
            ->assertRedirect(route('cart.index'));

        $this->assertSame(3, session('cart')[$product->id]['quantity']);

        $this->post(route('cart.add', $product), ['quantity' => 2])
            ->assertRedirect();

        $this->assertSame(5, session('cart')[$product->id]['quantity']);
    }

    public function test_cart_refreshes_and_displays_the_active_promo_price(): void
    {
        $product = $this->createProduct(stock: 8);
        $product->update([
            'is_promo' => true,
            'promo_price' => 8000,
        ]);
        $this->withSession([
            'cart' => [
                $product->id => [
                    'name' => $product->name,
                    'quantity' => 2,
                    'price' => 10000,
                    'image' => null,
                ],
            ],
        ]);

        $this->get(route('cart.index'))
            ->assertOk()
            ->assertSee('Harga promo: Rp 8.000')
            ->assertSee('Harga normal: Rp 10.000');
    }

    public function test_header_cart_icon_opens_cart_and_shows_item_count(): void
    {
        $this->withSession([
            'cart' => [
                7 => [
                    'name' => 'Produk Tes',
                    'quantity' => 3,
                    'price' => 10000,
                    'image' => null,
                ],
            ],
        ]);

        $this->get(route('cart.index'))
            ->assertOk()
            ->assertSee('href="'.route('cart.index').'"', false)
            ->assertSee('class="cart-count">3</span>', false);
    }

    public function test_customer_can_update_cart_quantity(): void
    {
        $product = $this->createProduct(stock: 8);
        $this->withSession([
            'cart' => [
                $product->id => [
                    'name' => $product->name,
                    'quantity' => 2,
                    'price' => $product->price,
                    'image' => null,
                ],
            ],
        ]);

        $this->patch(route('cart.update', $product), ['quantity' => 6])
            ->assertRedirect(route('cart.index'))
            ->assertSessionHas('cart.'.$product->id.'.quantity', 6);
    }

    public function test_cart_rejects_quantities_above_available_stock(): void
    {
        $product = $this->createProduct(stock: 4);
        $this->withSession([
            'cart' => [
                $product->id => [
                    'name' => $product->name,
                    'quantity' => 2,
                    'price' => $product->price,
                    'image' => null,
                ],
            ],
        ]);

        $this->from(route('products.show', $product))
            ->post(route('cart.add', $product), ['quantity' => 3])
            ->assertRedirect(route('products.show', $product))
            ->assertSessionHasErrors('quantity')
            ->assertSessionHas('cart.'.$product->id.'.quantity', 2);
    }

    private function createProduct(int $stock): Product
    {
        $category = Category::create([
            'name' => 'Kategori',
            'slug' => 'kategori',
        ]);

        return Product::create([
            'category_id' => $category->id,
            'name' => 'Produk Tes',
            'slug' => 'produk-tes',
            'price' => 10000,
            'stock' => $stock,
        ]);
    }
}
