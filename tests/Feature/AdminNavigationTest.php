<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_navigation_opens_admin_dashboard_categories_and_orders(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $customer = User::factory()->create(['name' => 'Nadia Pelanggan']);
        $this->actingAs($admin);
        $category = Category::create([
            'name' => 'Pakaian',
            'slug' => 'pakaian',
        ]);
        Product::create([
            'category_id' => $category->id,
            'name' => 'Kaos Admin',
            'slug' => 'kaos-admin',
            'price' => 50000,
            'stock' => 3,
        ]);

        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'NM-ADMIN-001',
            'recipient_name' => 'Nadia Pelanggan',
            'phone' => '08123456789',
            'address' => 'Jakarta',
            'shipping_method' => 'regular',
            'shipping_cost' => 10000,
            'payment_method' => 'cod',
            'status' => 'pending',
            'payment_status' => 'pending',
            'subtotal' => 50000,
            'total' => 60000,
        ]);
        $order->items()->create([
            'product_name' => 'Kaos Admin',
            'unit_price' => 50000,
            'quantity' => 1,
            'line_total' => 50000,
        ]);
        Order::create([
            'user_id' => $customer->id,
            'order_number' => 'NM-ADMIN-002',
            'recipient_name' => 'Nadia Pelanggan',
            'phone' => '08123456789',
            'address' => 'Jakarta',
            'shipping_method' => 'regular',
            'shipping_cost' => 10000,
            'payment_method' => 'bank_transfer',
            'status' => 'processing',
            'payment_status' => 'paid',
            'subtotal' => 60000,
            'total' => 70000,
        ]);

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Admin')
            ->assertSee('Total Pelanggan')
            ->assertSee('Nadia Pelanggan')
            ->assertSee('Ringkasan Penjualan')
            ->assertSee('70000', false)
            ->assertSee('Stok Menipis')
            ->assertSee('Kaos Admin')
            ->assertSee(route('admin.orders.index'), false);

        $this->get(route('admin.categories.index'))
            ->assertOk()
            ->assertSee('Admin Kategori')
            ->assertSee('admin-sidebar');

        $this->get(route('admin.orders.index'))
            ->assertOk()
            ->assertSee('Pesanan')
            ->assertSee('NM-ADMIN-001')
            ->assertSee('Nadia Pelanggan')
            ->assertDontSee('Pesanan Saya');

        $this->patch(route('admin.orders.status.update', $order), [
            'status' => 'processing',
        ])->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'processing',
        ]);
    }

    public function test_only_admins_can_open_admin_navigation_pages(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
        $this->get(route('admin.orders.index'))->assertRedirect(route('login'));

        $this->actingAs(User::factory()->create());

        $this->get(route('admin.dashboard'))->assertForbidden();
        $this->get(route('admin.categories.index'))->assertForbidden();
        $this->get(route('admin.orders.index'))->assertForbidden();
    }
}
