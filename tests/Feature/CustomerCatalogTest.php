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

    public function test_product_detail_uses_real_product_information_instead_of_fake_reviews(): void
    {
        $product = $this->createProduct();

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee($product->name)
            ->assertSee('Pakaian')
            ->assertSee('5 unit tersedia')
            ->assertSee('Tambah ke Keranjang')
            ->assertDontSee('4.9 (2.4rb ulasan)')
            ->assertDontSee('Produk Terbaru');
    }

    public function test_product_detail_does_not_show_a_promo_when_promo_price_is_missing(): void
    {
        $product = $this->createProduct();
        $product->update([
            'is_promo' => true,
            'promo_price' => null,
        ]);

        $this->get(route('products.show', $product))
            ->assertOk()
            ->assertSee('Rp 50.000')
            ->assertDontSee('PROMO')
            ->assertDontSee('Hemat');
    }

    public function test_shop_uses_host_relative_urls_for_product_images(): void
    {
        $publicAssetProduct = $this->createProduct();
        $publicAssetProduct->update(['image' => 'images/products/kulot-cewek-linen-celana.jpg']);

        $uploadedImageProduct = Product::create([
            'category_id' => $publicAssetProduct->category_id,
            'name' => 'Produk Gambar Unggahan',
            'slug' => 'produk-gambar-unggahan',
            'price' => 50000,
            'stock' => 5,
        ]);
        $uploadedImageProduct->update(['image' => 'products/uploaded-product.jpg']);

        $this->get(route('shop'))
            ->assertOk()
            ->assertSee('src="/images/products/kulot-cewek-linen-celana.jpg"', false)
            ->assertSee('src="/storage/products/uploaded-product.jpg"', false);
    }

    public function test_inactive_products_are_hidden_from_the_store_and_cannot_be_added_to_cart(): void
    {
        $product = $this->createProduct();
        $product->update(['is_active' => false]);

        $this->get(route('shop'))
            ->assertOk()
            ->assertDontSee($product->name);
        $this->get(route('products.show', $product))->assertNotFound();
        $this->post(route('cart.add', $product), ['quantity' => 1])->assertNotFound();
    }

    public function test_shop_shows_every_product_on_one_page(): void
    {
        $category = Category::create([
            'name' => 'Pakaian',
            'slug' => 'pakaian',
        ]);
        $productNames = [];

        for ($index = 1; $index <= 15; $index++) {
            $name = 'Produk Tes '.$index;
            $productNames[] = $name;

            Product::create([
                'category_id' => $category->id,
                'name' => $name,
                'slug' => 'produk-tes-'.$index,
                'price' => 50000,
                'stock' => 5,
            ]);
        }

        $response = $this->get(route('shop'))
            ->assertOk()
            ->assertDontSee('Pagination Navigation');

        foreach ($productNames as $name) {
            $response->assertSee($name);
        }
    }

    public function test_customer_search_finds_products_case_insensitively(): void
    {
        $category = Category::create([
            'name' => 'Pakaian',
            'slug' => 'pakaian',
        ]);
        $jeans = Product::create([
            'category_id' => $category->id,
            'name' => 'Celana Jeans',
            'slug' => 'celana-jeans',
            'price' => 50000,
            'stock' => 5,
        ]);
        $unrelatedProduct = Product::create([
            'category_id' => $category->id,
            'name' => 'Kaos Polos',
            'slug' => 'kaos-polos',
            'price' => 40000,
            'stock' => 5,
        ]);

        foreach (['home', 'shop'] as $route) {
            $this->get(route($route, ['search' => 'jeans']))
                ->assertOk()
                ->assertSee($jeans->name)
                ->assertDontSee($unrelatedProduct->name);
        }
    }

    public function test_promo_list_keeps_pagination(): void
    {
        $category = Category::create([
            'name' => 'Pakaian',
            'slug' => 'pakaian',
        ]);

        for ($index = 1; $index <= 13; $index++) {
            Product::create([
                'category_id' => $category->id,
                'name' => 'Promo Tes '.$index,
                'slug' => 'promo-tes-'.$index,
                'price' => 50000,
                'promo_price' => 35000,
                'is_promo' => true,
                'stock' => 5,
            ]);
        }

        $this->get(route('promotions.index'))
            ->assertOk()
            ->assertSee('Pagination Navigation', false)
            ->assertSee('Go to page 2', false);
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
