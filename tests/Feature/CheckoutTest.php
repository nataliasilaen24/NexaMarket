<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

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
            ->assertSee('Kartu Kredit')
            ->assertDontSee('Mode demo: pilihan bank')
            ->assertSee('id="qris-details" role="status" hidden', false)
            ->assertSee('id="credit-card-details" role="status" hidden', false)
            ->assertSee('name="quantities['.$selectedProduct->id.']"', false)
            ->assertSee('id="order-confirmation-dialog"', false)
            ->assertSee('id="confirm-place-order"', false)
            ->assertSee('QRIS belum diaktifkan')
            ->assertSee('border-color: #2563eb', false)
            ->assertDontSee('Kembali ke keranjang');

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
        $this->assertSame([
            'recipient_name' => 'Ayu Silaen',
            'phone' => '081234567890',
            'address' => 'Dusun Nadeak, Silaen',
        ], session('shipping_address'));
        $this->assertSame((int) auth()->id(), (int) $order->user_id);

        $this->post(route('checkout.start'), ['items' => [$otherProduct->id]])
            ->assertRedirect(route('checkout.index'));
        $this->get(route('checkout.index'))
            ->assertOk()
            ->assertSee('value="Ayu Silaen"', false)
            ->assertSee('value="081234567890"', false)
            ->assertSee('Dusun Nadeak, Silaen');
    }

    public function test_orders_page_lists_only_orders_owned_by_the_authenticated_user(): void
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
            'payment_method' => 'cod',
        ]);

        $order = Order::firstOrFail();
        $this->get(route('orders.index'))
            ->assertOk()
            ->assertSee('Pesanan Saya')
            ->assertSee('Lihat Riwayat Pesanan')
            ->assertSee('Belum Bayar')
            ->assertSee('Dikemas')
            ->assertSee('Dikirim')
            ->assertSee('Beri Penilaian')
            ->assertSee('aria-label="Dikemas, 0 pesanan"', false)
            ->assertSee($order->order_number)
            ->assertSee($product->name)
            ->assertSee('Lihat Detail Pesanan');

        $this->get(route('orders.index', ['filter' => 'waiting']))
            ->assertOk()
            ->assertSee('Belum ada pesanan di bagian ini')
            ->assertDontSee($order->order_number);

        $order->update(['status' => 'processing']);
        $this->get(route('orders.index', ['filter' => 'packed']))
            ->assertOk()
            ->assertSee($order->order_number);
        $order->update(['status' => 'shipped']);
        $this->get(route('orders.index', ['filter' => 'shipped']))
            ->assertOk()
            ->assertSee($order->order_number);
        $order->update(['status' => 'delivered']);
        $this->get(route('orders.index', ['filter' => 'rating']))
            ->assertOk()
            ->assertSee($order->order_number);

        $otherUser = User::factory()->create();
        $this->actingAs($otherUser)
            ->get(route('orders.index'))
            ->assertOk()
            ->assertSee('Belum ada pesanan')
            ->assertDontSee($order->order_number);

        $this->get(route('checkout.confirmation', $order->order_number))
            ->assertNotFound();
    }

    public function test_place_order_uses_checkout_quantities_and_checks_stock(): void
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
            'payment_method' => 'cod',
            'quantities' => [$product->id => 3],
        ])->assertRedirect();

        $order = Order::with('items')->firstOrFail();
        $this->assertSame(3, $order->items->first()->quantity);
        $this->assertSame(90000.0, (float) $order->total);
        $this->assertSame(2, $product->fresh()->stock);
    }

    public function test_checkout_records_the_active_promo_price_even_if_cart_has_an_old_price(): void
    {
        [$product] = $this->createProducts();
        $product->update([
            'is_promo' => true,
            'promo_price' => 24000,
        ]);
        $this->withSession([
            'cart' => [$product->id => $this->cartItem($product, 2)],
            'checkout_items' => [(string) $product->id],
        ]);

        $this->get(route('checkout.index'))
            ->assertOk()
            ->assertSee('Rp 24.000 / barang');

        $this->post(route('checkout.place'), [
            'recipient_name' => 'Ayu Silaen',
            'phone' => '081234567890',
            'address' => 'Dusun Nadeak, Silaen',
            'shipping_method' => 'hemat',
            'payment_method' => 'cod',
            'quantities' => [$product->id => 2],
        ])->assertRedirect();

        $order = Order::with('items')->firstOrFail();
        $this->assertSame(48000.0, (float) $order->total);
        $this->assertSame(24000.0, (float) $order->items->first()->unit_price);
    }

    public function test_checkout_quantity_over_stock_returns_to_checkout_without_creating_order(): void
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
                'payment_method' => 'cod',
                'quantities' => [$product->id => 6],
            ])
            ->assertRedirect(route('checkout.index'))
            ->assertSessionHasErrors('quantities');

        $this->assertDatabaseCount('orders', 0);
        $this->assertSame(5, $product->fresh()->stock);
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
            ->assertSee('belum terhubung ke payment gateway')
            ->assertSee('Informasi pengiriman')
            ->assertSee('Rincian pembayaran')
            ->assertSee('Dusun Nadeak, Silaen');
    }

    public function test_qris_and_credit_card_create_midtrans_payment_sessions(): void
    {
        [$product] = $this->createProducts();
        config([
            'services.midtrans.server_key' => 'SB-Mid-server-test-key',
            'services.midtrans.is_production' => false,
        ]);
        Http::fake(fn (Request $request) => str_ends_with($request->url(), '/v2/charge')
            ? Http::response([
                'transaction_id' => 'qris-transaction-test',
                'actions' => [[
                    'name' => 'generate-qr-code',
                    'url' => 'https://api.sandbox.midtrans.com/v2/qris/qris-transaction-test/qr-code',
                ]],
            ], 201)
            : Http::response([
                'token' => 'test-snap-token',
                'redirect_url' => 'https://app.sandbox.midtrans.com/snap/v2/vtweb/test-snap-token',
            ], 201));

        foreach (['qris', 'credit_card'] as $paymentMethod) {
            $this->withSession([
                'cart' => [$product->id => $this->cartItem($product, 1)],
                'checkout_items' => [(string) $product->id],
            ]);

            $response = $this->post(route('checkout.place'), [
                'recipient_name' => 'Ayu Silaen',
                'phone' => '081234567890',
                'address' => 'Dusun Nadeak, Silaen',
                'shipping_method' => 'hemat',
                'payment_method' => $paymentMethod,
            ]);

            $order = Order::latest('id')->firstOrFail();
            if ($paymentMethod === 'qris') {
                $response->assertRedirect(route('checkout.qris-payment', $order->order_number));
                $this->assertSame('qris-transaction-test', $order->qris_transaction_id);
                $this->assertNotNull($order->qris_expires_at);
                $this->assertEqualsWithDelta(86400, now()->diffInSeconds($order->qris_expires_at), 2);
                $this->get(route('checkout.qris-payment', $order->order_number))
                    ->assertOk()
                    ->assertSee('Bayar dengan QRIS')
                    ->assertSee('Batas waktu pembayaran')
                    ->assertSee('Kembali ke detail pesanan')
                    ->assertSee(route('checkout.qris-code', $order->order_number));
            } else {
                $response->assertRedirect('https://app.sandbox.midtrans.com/snap/v2/vtweb/test-snap-token');
                $this->assertSame(
                    'https://app.sandbox.midtrans.com/snap/v2/vtweb/test-snap-token',
                    $order->snap_redirect_url
                );
            }

            $this->assertSame($paymentMethod, $order->payment_method);
            $this->assertNull($order->payment_channel);
        }

        Http::assertSent(fn (Request $request) => ($request['payment_type'] ?? null) === 'qris'
            && $request['custom_expiry']['expiry_duration'] === 1
            && $request['custom_expiry']['unit'] === 'day');
        Http::assertSent(fn (Request $request) => ($request['enabled_payments'] ?? null) === ['credit_card']);
        $this->assertDatabaseCount('orders', 2);
    }

    public function test_midtrans_notification_marks_an_order_paid_only_with_a_valid_signature(): void
    {
        [$product] = $this->createProducts();
        config([
            'services.midtrans.server_key' => 'SB-Mid-server-test-key',
            'services.midtrans.is_production' => false,
        ]);
        Http::fake([
            'api.sandbox.midtrans.com/v2/charge' => Http::response([
                'transaction_id' => 'qris-transaction-test',
                'actions' => [[
                    'name' => 'generate-qr-code',
                    'url' => 'https://api.sandbox.midtrans.com/v2/qris/qris-transaction-test/qr-code',
                ]],
            ], 201),
        ]);
        $this->withSession([
            'cart' => [$product->id => $this->cartItem($product, 1)],
            'checkout_items' => [(string) $product->id],
        ]);

        $this->post(route('checkout.place'), [
            'recipient_name' => 'Ayu Silaen',
            'phone' => '081234567890',
            'address' => 'Dusun Nadeak, Silaen',
            'shipping_method' => 'hemat',
            'payment_method' => 'qris',
            'quantities' => [$product->id => 1],
        ])->assertRedirect(route('checkout.qris-payment', Order::firstOrFail()->order_number));

        $order = Order::firstOrFail();
        $grossAmount = number_format((float) $order->total, 2, '.', '');
        Http::fake([
            'api.sandbox.midtrans.com/v2/*/status' => Http::response([
                'order_id' => $order->order_number,
                'status_code' => '200',
                'gross_amount' => $grossAmount,
                'transaction_status' => 'settlement',
                'fraud_status' => 'accept',
            ], 200),
        ]);
        $notification = [
            'order_id' => $order->order_number,
            'status_code' => '201',
            'gross_amount' => $grossAmount,
            'transaction_status' => 'pending',
        ];
        $notification['signature_key'] = hash(
            'sha512',
            $notification['order_id'].$notification['status_code'].$grossAmount.'SB-Mid-server-test-key'
        );

        $this->postJson(route('payment.midtrans.notification'), $notification)
            ->assertOk()
            ->assertJson(['status' => 'ok']);

        $this->assertSame('paid', $order->fresh()->payment_status);
        $this->assertSame('qris', $order->fresh()->payment_method);
        $this->get(route('checkout.confirmation', $order->order_number))
            ->assertOk()
            ->assertSee('Pembayaran berhasil')
            ->assertSee('Pembayaran terverifikasi');
    }

    public function test_invalid_midtrans_notification_signature_does_not_change_payment_status(): void
    {
        [$product] = $this->createProducts();
        config([
            'services.midtrans.server_key' => 'SB-Mid-server-test-key',
            'services.midtrans.is_production' => false,
        ]);
        Http::fake([
            'api.sandbox.midtrans.com/v2/charge' => Http::response([
                'transaction_id' => 'qris-transaction-test',
                'actions' => [[
                    'name' => 'generate-qr-code',
                    'url' => 'https://api.sandbox.midtrans.com/v2/qris/qris-transaction-test/qr-code',
                ]],
            ], 201),
        ]);
        $this->withSession([
            'cart' => [$product->id => $this->cartItem($product, 1)],
            'checkout_items' => [(string) $product->id],
        ]);
        $this->post(route('checkout.place'), [
            'recipient_name' => 'Ayu Silaen',
            'phone' => '081234567890',
            'address' => 'Dusun Nadeak, Silaen',
            'shipping_method' => 'hemat',
            'payment_method' => 'qris',
            'quantities' => [$product->id => 1],
        ]);

        $order = Order::firstOrFail();
        $this->postJson(route('payment.midtrans.notification'), [
            'order_id' => $order->order_number,
            'status_code' => '200',
            'gross_amount' => number_format((float) $order->total, 2, '.', ''),
            'transaction_status' => 'settlement',
            'fraud_status' => 'accept',
            'signature_key' => 'invalid',
        ])->assertForbidden();

        $this->assertSame('pending', $order->fresh()->payment_status);
    }

    public function test_qris_image_is_served_through_the_application(): void
    {
        [$product] = $this->createProducts();
        config([
            'services.midtrans.server_key' => 'SB-Mid-server-test-key',
            'services.midtrans.is_production' => false,
        ]);
        Http::fake([
            'api.sandbox.midtrans.com/v2/charge' => Http::response([
                'transaction_id' => 'qris-transaction-image',
                'actions' => [[
                    'name' => 'generate-qr-code',
                    'url' => 'https://api.sandbox.midtrans.com/v2/qris/qris-transaction-image/qr-code',
                ]],
            ], 201),
            'api.sandbox.midtrans.com/v2/qris/qris-transaction-image/qr-code' => Http::response(
                'fake-png-content',
                200,
                ['Content-Type' => 'image/png']
            ),
        ]);
        $this->withSession([
            'cart' => [$product->id => $this->cartItem($product, 1)],
            'checkout_items' => [(string) $product->id],
        ]);
        $this->post(route('checkout.place'), [
            'recipient_name' => 'Ayu Silaen',
            'phone' => '081234567890',
            'address' => 'Dusun Nadeak, Silaen',
            'shipping_method' => 'hemat',
            'payment_method' => 'qris',
            'quantities' => [$product->id => 1],
        ]);

        $order = Order::firstOrFail();
        $this->get(route('checkout.qris-code', $order->order_number))
            ->assertOk()
            ->assertHeader('Content-Type', 'image/png')
            ->assertContent('fake-png-content');
    }

    public function test_expired_qris_is_converted_to_cod_without_releasing_reserved_stock(): void
    {
        [$product] = $this->createProducts();
        config([
            'services.midtrans.server_key' => 'SB-Mid-server-test-key',
            'services.midtrans.is_production' => false,
        ]);
        Http::fake([
            'api.sandbox.midtrans.com/v2/charge' => Http::response([
                'transaction_id' => 'qris-transaction-expired',
                'actions' => [[
                    'name' => 'generate-qr-code',
                    'url' => 'https://api.sandbox.midtrans.com/v2/qris/qris-transaction-expired/qr-code',
                ]],
            ], 201),
        ]);
        $this->withSession([
            'cart' => [$product->id => $this->cartItem($product, 1)],
            'checkout_items' => [(string) $product->id],
        ]);
        $this->post(route('checkout.place'), [
            'recipient_name' => 'Ayu Silaen',
            'phone' => '081234567890',
            'address' => 'Dusun Nadeak, Silaen',
            'shipping_method' => 'hemat',
            'payment_method' => 'qris',
            'quantities' => [$product->id => 1],
        ]);

        $order = Order::firstOrFail();
        $grossAmount = number_format((float) $order->total, 2, '.', '');
        Http::fake([
            'api.sandbox.midtrans.com/v2/*/status' => Http::response([
                'order_id' => $order->order_number,
                'status_code' => '202',
                'gross_amount' => $grossAmount,
                'transaction_status' => 'expire',
                'fraud_status' => 'accept',
            ], 200),
        ]);
        $notification = [
            'order_id' => $order->order_number,
            'status_code' => '202',
            'gross_amount' => $grossAmount,
        ];
        $notification['signature_key'] = hash(
            'sha512',
            $notification['order_id'].$notification['status_code'].$grossAmount.'SB-Mid-server-test-key'
        );

        $this->postJson(route('payment.midtrans.notification'), $notification)->assertOk();
        $this->postJson(route('payment.midtrans.notification'), $notification)->assertOk();

        $this->assertSame('cod', $order->fresh()->payment_method);
        $this->assertSame('pending', $order->fresh()->payment_status);
        $this->assertSame(4, $product->fresh()->stock);
        $this->get(route('checkout.confirmation', $order->order_number))
            ->assertOk()
            ->assertSee('Pesanan dialihkan ke COD')
            ->assertSee('dikirim ke alamat tujuan');
    }

    public function test_qris_and_credit_card_orders_are_recorded_without_midtrans_configuration(): void
    {
        [$product] = $this->createProducts();
        config(['services.midtrans.server_key' => null]);
        Http::fake();

        foreach (['qris', 'credit_card'] as $paymentMethod) {
            $this->withSession([
                'cart' => [$product->id => $this->cartItem($product, 1)],
                'checkout_items' => [(string) $product->id],
            ]);

            $response = $this->post(route('checkout.place'), [
                'recipient_name' => 'Ayu Silaen',
                'phone' => '081234567890',
                'address' => 'Dusun Nadeak, Silaen',
                'shipping_method' => 'hemat',
                'payment_method' => $paymentMethod,
                'quantities' => [$product->id => 1],
            ]);

            $order = Order::latest('id')->firstOrFail();
            $response->assertRedirect(route('checkout.confirmation', $order->order_number));
            $this->assertSame($paymentMethod, $order->payment_method);
            $this->assertSame('pending', $order->payment_status);
            $this->assertNull($order->snap_redirect_url);
            $confirmation = $this->get(route('checkout.confirmation', $order->order_number))
                ->assertOk()
                ->assertSee('Pesananmu tercatat.');

            if ($paymentMethod === 'qris') {
                $confirmation
                    ->assertSee('QRIS SIMULASI')
                    ->assertSee('Waktu kedaluwarsa QRIS')
                    ->assertSee('Masa berlaku 24 jam')
                    ->assertSee(
                        'data-qris-demo-expiry="'.$order->created_at->copy()->addDay()->toIso8601String().'"',
                        false
                    )
                    ->assertDontSee('QRIS simulasi untuk melihat contoh tampilan pembayaran')
                    ->assertDontSee('QR ini tidak bisa dipindai');
            } else {
                $confirmation->assertSee('Pembayaran QRIS/kartu belum diaktifkan');
            }
        }

        Http::assertNothingSent();
        $this->assertDatabaseCount('orders', 2);
        $this->assertSame(3, $product->fresh()->stock);
    }

    public function test_midtrans_api_failure_does_not_create_order_or_decrease_stock(): void
    {
        [$product] = $this->createProducts();
        config([
            'services.midtrans.server_key' => 'SB-Mid-server-test-key',
            'services.midtrans.is_production' => false,
        ]);
        Http::fake([
            'api.sandbox.midtrans.com/v2/charge' => Http::response(['message' => 'unavailable'], 500),
        ]);
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
                'payment_method' => 'qris',
                'quantities' => [$product->id => 1],
            ])
            ->assertRedirect(route('checkout.index'))
            ->assertSessionHasErrors('payment_method');

        $this->assertDatabaseCount('orders', 0);
        $this->assertSame(5, $product->fresh()->stock);
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
