<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RuntimeException;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => 'pakaian'],
            ['name' => 'Pakaian']
        );

        $nameOverrides = [
            'aket-hoodie-zipper-jaket-polos-sweater' => 'Jaket Hoodie Zipper Jaket Polos Sweater',
            'eans-pria-panjang-baggy-pants' => 'Jeans Pria Panjang Baggy Pants',
            'jens-skinny-pensil' => 'Jeans Skinny Pensil',
            'jeans-denin-korea' => 'Jeans Denim Korea',
            'jaket-varsity-modern-keren-basebal' => 'Jaket Varsity Modern Keren Baseball',
            'celana-standart-pria-dewasa-kulot-pria' => 'Celana Standar Pria Dewasa Kulot Pria',
        ];

        $descriptions = [
            'kaos-snowman' => 'Kaos hitam dengan gambar karakter snowman lucu.',
            'kaos-smile' => 'Kaos putih oversized dengan desain wajah tersenyum.',
            'kaos-minimalist' => 'Kaos abu-abu dengan desain grafis minimalis.',
            'kaos-cartoon' => 'Kaos hitam oversized dengan ilustrasi kartun.',
        ];

        $files = File::files(public_path('images/products'));

        if ($files === []) {
            throw new RuntimeException('Foto produk tidak ditemukan di public/images/products.');
        }

        usort($files, fn ($left, $right) => strnatcasecmp($left->getFilename(), $right->getFilename()));

        $products = [];

        foreach ($files as $file) {
            $extension = strtolower($file->getExtension());

            if (! in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                throw new RuntimeException('Format foto produk tidak didukung: '.$file->getFilename());
            }

            $sourceSlug = Str::slug($file->getBasename('.'.$file->getExtension()));
            $name = $nameOverrides[$sourceSlug]
                ?? Str::title(str_replace(['-', '_'], ' ', $file->getBasename('.'.$file->getExtension())));
            $slug = Str::slug($name);

            if (isset($products[$slug])) {
                throw new RuntimeException('Slug produk duplikat ditemukan: '.$slug);
            }

            $products[$slug] = [
                'name' => $name,
                'image' => 'images/products/'.$file->getFilename(),
            ];
        }

        foreach ($products as $slug => $productData) {
            $product = Product::firstOrNew(['slug' => $slug]);
            $isNew = ! $product->exists;

            $product->fill([
                'category_id' => $category->id,
                'name' => $productData['name'],
                'description' => $descriptions[$slug] ?? $product->description,
                'image' => $productData['image'],
            ]);

            if ($isNew) {
                $product->price = random_int(50, 350) * 1000;
                $product->stock = random_int(1, 100);
            }

            $product->save();
        }
    }
}