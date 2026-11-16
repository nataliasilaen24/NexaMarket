<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCategoryManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_search_edit_and_delete_categories(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        $this->get(route('admin.categories.create'))
            ->assertOk()
            ->assertSee(route('admin.categories.store'));

        $this->post(route('admin.categories.store'), [
            'name' => 'Elektronik',
            'description' => 'Perangkat elektronik',
        ])->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('success');

        $category = Category::where('slug', 'elektronik')->firstOrFail();
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Elektronik',
            'description' => 'Perangkat elektronik',
        ]);

        $this->get(route('admin.categories.index', ['search' => 'elekt']))
            ->assertOk()
            ->assertSee('Elektronik')
            ->assertSee('Tambah Kategori')
            ->assertSee('Edit');
        $this->get(route('admin.categories.edit', $category))
            ->assertOk()
            ->assertSee(route('admin.categories.update', $category));

        $this->put(route('admin.categories.update', $category), [
            'name' => 'Elektronik Rumah',
            'description' => 'Perangkat untuk rumah',
        ])->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Elektronik Rumah',
            'slug' => 'elektronik-rumah',
        ]);

        $this->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('success');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_category_with_products_cannot_be_deleted(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $category = Category::create([
            'name' => 'Pakaian',
            'slug' => 'pakaian',
        ]);
        Product::create([
            'category_id' => $category->id,
            'name' => 'Kaos',
            'slug' => 'kaos',
            'price' => 50000,
            'stock' => 5,
        ]);

        $this->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_non_admin_cannot_manage_categories(): void
    {
        $category = Category::create([
            'name' => 'Pakaian',
            'slug' => 'pakaian',
        ]);
        $this->actingAs(User::factory()->create());

        $this->get(route('admin.categories.index'))->assertForbidden();
        $this->post(route('admin.categories.store'), [])->assertForbidden();
        $this->delete(route('admin.categories.destroy', $category))->assertForbidden();
    }
}
