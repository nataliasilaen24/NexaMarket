<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_every_seeded_product_has_a_description(): void
    {
        $this->seed(ProductSeeder::class);

        $this->assertGreaterThan(0, Product::count());
        $this->assertSame(
            0,
            Product::whereNull('description')->orWhere('description', '')->count()
        );
    }
}
