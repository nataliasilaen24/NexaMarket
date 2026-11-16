<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_filter_orders_and_view_order_details(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $customer = User::factory()->create(['name' => 'Nadia Pelanggan', 'email' => 'nadia@example.test']);
        $pendingOrder = $this->createOrder($customer, 'NM-PENDING-001', 'pending');
        $cancelledOrder = $this->createOrder($customer, 'NM-CANCELLED-001', 'cancelled');
        $this->actingAs($admin);

        $this->get(route('admin.orders.index', ['status' => 'cancelled']))
            ->assertOk()
            ->assertSee('NM-CANCELLED-001')
            ->assertSee('Dibatalkan')
            ->assertDontSee('NM-PENDING-001');

        $this->get(route('admin.orders.index', ['search' => 'nadia@example.test']))
            ->assertOk()
            ->assertSee('NM-PENDING-001')
            ->assertSee('NM-CANCELLED-001');

        $this->get(route('admin.orders.show', $pendingOrder))
            ->assertOk()
            ->assertSee('Detail pelanggan')
            ->assertSee('Nadia Pelanggan')
            ->assertSee('nadia@example.test')
            ->assertSee('Jakarta Selatan')
            ->assertSee('Kemeja Nexa')
            ->assertSee('Menunggu Pembayaran')
            ->assertSee('Rp 135.000');

        $this->assertNotSame($pendingOrder->id, $cancelledOrder->id);
    }

    public function test_admin_can_update_order_status_to_cancelled_and_invalid_status_is_rejected(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $customer = User::factory()->create();
        $order = $this->createOrder($customer, 'NM-STATUS-001', 'processing');
        $this->actingAs($admin);

        $this->patch(route('admin.orders.status.update', $order), [
            'status' => 'cancelled',
        ])->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'cancelled',
        ]);

        $this->patch(route('admin.orders.status.update', $order), [
            'status' => 'unknown',
        ])->assertSessionHasErrors('status');
    }

    public function test_non_admin_cannot_view_order_details_or_change_order_status(): void
    {
        $customer = User::factory()->create();
        $order = $this->createOrder($customer, 'NM-PRIVATE-001', 'pending');
        $this->actingAs(User::factory()->create());

        $this->get(route('admin.orders.show', $order))->assertForbidden();
        $this->patch(route('admin.orders.status.update', $order), [
            'status' => 'cancelled',
        ])->assertForbidden();
    }

    private function createOrder(User $customer, string $orderNumber, string $status): Order
    {
        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => $orderNumber,
            'recipient_name' => 'Nadia Penerima',
            'phone' => '08123456789',
            'address' => 'Jl. Contoh No. 10, Jakarta Selatan',
            'shipping_method' => 'regular',
            'shipping_cost' => 10000,
            'payment_method' => 'bank_transfer',
            'status' => $status,
            'payment_status' => 'pending',
            'subtotal' => 125000,
            'total' => 135000,
        ]);
        $order->items()->create([
            'product_name' => 'Kemeja Nexa',
            'unit_price' => 125000,
            'quantity' => 1,
            'line_total' => 125000,
        ]);

        return $order;
    }
}
