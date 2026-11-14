<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerCatalogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    public function test_product_list_is_a_customer_catalog(): void
    {
        $product = $this->createProduct();

        $this->get(route('products.index'))
            ->assertOk()
            ->assertSee('Belanja Produk')
            ->assertSee($product->name)
            ->assertSee('fa-cart-plus')
            ->assertDontSee('Tambah Produk Baru')
            ->assertDontSee('Hapus');
    }

    public function test_home_replaces_category_links_with_promo_products(): void
    {
        $product = $this->createProduct();
        $product->update([
            'is_promo' => true,
            'promo_price' => 35000,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Promo Pilihan')
            ->assertSee('Kaos Tes')
            ->assertSee(route('promotions.index'), false)
            ->assertDontSee('Belanja Sesuai Duniamu')
            ->assertDontSee('categories.index');
    }

    public function test_promo_page_only_shows_products_with_an_active_promo(): void
    {
        $product = $this->createProduct();
        $product->update([
            'is_promo' => true,
            'promo_price' => 35000,
        ]);
        Product::create([
            'category_id' => $product->category_id,
            'name' => 'Kaos Reguler',
            'slug' => 'kaos-reguler',
            'price' => 40000,
            'stock' => 4,
        ]);

        $this->get('/categories')
            ->assertNotFound();

        $this->get(route('promotions.index'))
            ->assertOk()
            ->assertSee('Produk Promo')
            ->assertSee($product->name)
            ->assertSee('Rp 35.000')
            ->assertSee('Rp 50.000')
            ->assertDontSee('Kaos Reguler');
    }

    public function test_public_product_and_category_creation_routes_are_unavailable(): void
    {
        $this->get('/products/create')->assertNotFound();
        $this->post('/products', [])->assertStatus(405);
        $this->get('/categories')->assertNotFound();
        $this->get('/categories/create')->assertNotFound();
        $this->post('/categories', [])->assertNotFound();
    }

    private function createProduct(): Product
    {
        $category = Category::create([
            'name' => 'Pakaian',
            'slug' => 'pakaian',
        ]);

        return Product::create([
            'category_id' => $category->id,
            'name' => 'Kaos Tes',
            'slug' => 'kaos-tes',
            'price' => 50000,
            'stock' => 5,
        ]);
    }
}
