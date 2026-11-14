<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPromoTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_product_management_requires_an_administrator_login(): void
    {
        $this->get(route('admin.products.index'))
            ->assertRedirect(route('login'));

        $customer = User::factory()->create();
        $this->post(route('login.store'), [
            'email' => $customer->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.products.index'));

        $this->get(route('admin.products.index'))
            ->assertForbidden();
    }

    public function test_admin_can_mark_a_product_for_promo_with_a_lower_price(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $product = $this->createProduct();

        $this->get(route('admin.products.index'))
            ->assertRedirect(route('login'));
        $this->post(route('login.store'), [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.products.index'));

        $this->get(route('admin.products.index'))
            ->assertOk()
            ->assertSee($product->name);

        $this->put(route('admin.products.promo.update', $product), [
            'is_promo' => '1',
            'promo_price' => '35000',
        ])->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_promo' => 1,
            'promo_price' => 35000,
        ]);
        $this->get(route('promotions.index'))
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee('Rp 35.000');

        $this->put(route('admin.products.promo.update', $product), [
            'is_promo' => '1',
            'promo_price' => '50000',
        ])->assertSessionHasErrors('promo_price');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'promo_price' => 35000,
        ]);
    }

    private function createProduct(): Product
    {
        $category = Category::create([
            'name' => 'Pakaian',
            'slug' => 'pakaian',
        ]);

        return Product::create([
            'category_id' => $category->id,
            'name' => 'Kaos Promo',
            'slug' => 'kaos-promo',
            'price' => 50000,
            'stock' => 5,
        ]);
    }
}
