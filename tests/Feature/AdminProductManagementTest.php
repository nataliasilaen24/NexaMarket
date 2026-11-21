<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProductManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_update_and_delete_products(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $category = $this->createCategory();
        $existingProduct = $this->createProduct($category, 'kaos-tes', 'Kaos Tes');

        $this->get(route('admin.products.create'))
            ->assertOk()
            ->assertSee(route('admin.products.store'));

        $this->post(route('admin.products.store'), [
            'name' => 'Kaos Tes',
            'category_id' => $category->id,
            'origin_city' => 'Bandung',
            'price' => 50000,
            'stock' => 5,
            'description' => 'Kaos nyaman',
        ])->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('success');

        $createdProduct = Product::where('slug', 'kaos-tes-2')->firstOrFail();
        $this->assertDatabaseHas('products', [
            'id' => $createdProduct->id,
            'category_id' => $category->id,
            'origin_city' => 'Bandung',
            'name' => 'Kaos Tes',
            'price' => 50000,
            'stock' => 5,
        ]);

        $this->get(route('admin.products.index'))
            ->assertOk()
            ->assertSee('Tambah Produk')
            ->assertSee('title="Edit produk"', false)
            ->assertSee($existingProduct->name);

        $this->get(route('admin.products.edit', $createdProduct))
            ->assertOk()
            ->assertSee(route('admin.products.update', $createdProduct));

        $this->put(route('admin.products.update', $createdProduct), [
            'name' => 'Kaos Baru',
            'category_id' => $category->id,
            'origin_city' => 'Yogyakarta',
            'price' => 60000,
            'stock' => 8,
            'description' => 'Deskripsi diperbarui',
            'is_active' => '0',
        ])->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'id' => $createdProduct->id,
            'slug' => 'kaos-baru',
            'name' => 'Kaos Baru',
            'origin_city' => 'Yogyakarta',
            'price' => 60000,
            'stock' => 8,
            'is_active' => 0,
        ]);
        $this->get(route('admin.products.index'))
            ->assertOk()
            ->assertSee('Tidak Aktif');

        $this->delete(route('admin.products.destroy', $createdProduct))
            ->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('products', ['id' => $createdProduct->id]);
    }

    public function test_customer_cannot_manage_products(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('admin.products.create'))->assertForbidden();
        $this->post(route('admin.products.store'), [])->assertForbidden();
    }

    public function test_admin_can_search_products_and_open_category_menu(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $category = $this->createCategory();
        $this->createProduct($category, 'kaos-tes', 'Kaos Tes');
        $this->createProduct($category, 'celana-tes', 'Celana Tes')->update(['is_active' => false]);

        $this->get(route('admin.products.index', ['search' => 'Kaos']))
            ->assertOk()
            ->assertSee('Kaos Tes')
            ->assertDontSee('Celana Tes');

        $this->get(route('admin.categories.index'))
            ->assertOk()
            ->assertSee('Pakaian')
            ->assertSee('Kategori');
    }

    public function test_admin_product_list_shows_all_products_without_next_page(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $category = $this->createCategory();

        for ($index = 1; $index <= 12; $index++) {
            $number = str_pad((string) $index, 2, '0', STR_PAD_LEFT);
            $this->createProduct($category, 'produk-'.$number, 'Produk '.$number);
        }

        $this->get(route('admin.products.index'))
            ->assertOk()
            ->assertSee('Produk 12')
            ->assertDontSee('Pagination Navigation');
    }

    public function test_admin_can_replace_a_product_image_and_update_stock(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $category = $this->createCategory();
        $product = $this->createProduct($category, 'produk-gambar', 'Produk Gambar');
        $oldImage = 'products/old-image.png';
        Storage::disk('public')->put($oldImage, 'old image');
        $product->update(['image' => $oldImage]);

        $image = UploadedFile::fake()->createWithContent(
            'new-image.png',
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/lGQAAAAASUVORK5CYII=')
        );

        $this->put(route('admin.products.update', $product), [
            'name' => $product->name,
            'category_id' => $category->id,
            'origin_city' => $product->origin_city,
            'price' => 50000,
            'stock' => 12,
            'image' => $image,
        ])->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('success');

        $updatedProduct = $product->fresh();
        $this->assertSame(12, $updatedProduct->stock);
        $this->assertNotSame($oldImage, $updatedProduct->image);
        Storage::disk('public')->assertExists($updatedProduct->image);
        Storage::disk('public')->assertMissing($oldImage);
    }

    private function createCategory(): Category
    {
        return Category::create([
            'name' => 'Pakaian',
            'slug' => 'pakaian',
        ]);
    }

    private function createProduct(Category $category, string $slug, string $name): Product
    {
        return Product::create([
            'category_id' => $category->id,
            'name' => $name,
            'slug' => $slug,
            'origin_city' => 'Jakarta',
            'price' => 50000,
            'stock' => 5,
        ]);
    }
}
