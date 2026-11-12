<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => 'pakaian'],
            ['name' => 'Pakaian']
        );

        $products = [
            [
                'name' => 'Kaos Snowman',
                'slug' => 'kaos-snowman',
                'description' => 'Kaos hitam dengan gambar karakter snowman lucu.',
                'price' => 50000,
                'stock' => 20,
                'image' => 'products/kaos-snowman.jpg',
            ],
            [
                'name' => 'Kaos Smile',
                'slug' => 'kaos-smile',
                'description' => 'Kaos putih oversized dengan desain wajah tersenyum.',
                'price' => 50000,
                'stock' => 20,
                'image' => 'products/kaos-smile.jpg',
            ],
            [
                'name' => 'Kaos Minimalist',
                'slug' => 'kaos-minimalist',
                'description' => 'Kaos abu-abu dengan desain grafis minimalis.',
                'price' => 50000,
                'stock' => 20,
                'image' => 'products/kaos-minimalist.jpg',
            ],
            [
                'name' => 'Kaos Cartoon',
                'slug' => 'kaos-cartoon',
                'description' => 'Kaos hitam oversized dengan ilustrasi kartun.',
                'price' => 50000,
                'stock' => 20,
                'image' => 'products/kaos-cartoon.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                array_merge($product, [
                    'category_id' => $category->id,
                ])
            );
        }
    }
}