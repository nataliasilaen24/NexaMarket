<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerCatalogTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_category_list_links_to_products_in_that_category(): void
    {
        $this->createProduct();

        $this->get(route('categories.index'))
            ->assertOk()
            ->assertSee('Jelajahi Kategori')
            ->assertSee('Pakaian')
            ->assertSee(route('shop', ['category' => 'pakaian']), false)
            ->assertDontSee('Tambah Kategori')
            ->assertDontSee('Hapus');

        $this->get(route('shop', ['category' => 'pakaian']))
            ->assertOk()
            ->assertSee('Kaos Tes');
    }

    public function test_public_product_and_category_creation_routes_are_unavailable(): void
    {
        $this->get('/products/create')->assertNotFound();
        $this->post('/products', [])->assertStatus(405);
        $this->get('/categories/create')->assertNotFound();
        $this->post('/categories', [])->assertStatus(405);
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
