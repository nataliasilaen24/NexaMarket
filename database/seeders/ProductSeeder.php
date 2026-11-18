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
            'casual-pants' => 'Celana bergaya kasual dengan tampilan sederhana yang mudah dipadukan untuk berbagai kegiatan sehari-hari.',
            'celana-bahan-formal-pria-hitam' => 'Celana panjang hitam bergaya formal untuk melengkapi penampilan kerja maupun acara resmi.',
            'celana-cargo-pria' => 'Celana cargo pria dengan tampilan kasual dan detail kantong khas cargo untuk gaya sehari-hari.',
            'celana-cowok-pendek-harian-polos' => 'Celana pendek polos untuk aktivitas santai. Desainnya mudah dipadukan dengan kaos atau atasan kasual.',
            'celana-cutbray-wanita' => 'Celana cutbray wanita dengan potongan melebar pada bagian bawah untuk tampilan yang menarik.',
            'celana-highwaist' => 'Celana highwaist dengan garis pinggang tinggi yang mudah dipadukan dengan berbagai model atasan.',
            'celana-jeans-gombrong-wanita' => 'Jeans wanita dengan potongan gombrong untuk tampilan kasual yang santai.',
            'celana-jeans-pendek-pria' => 'Celana jeans pendek pria untuk gaya kasual sehari-hari dan mudah dipadukan dengan berbagai atasan.',
            'celana-jeans-pendek-wanita' => 'Celana jeans pendek wanita dengan gaya kasual untuk melengkapi penampilan sehari-hari.',
            'celana-jeans-wanita' => 'Celana jeans wanita dengan tampilan denim yang mudah dipadukan untuk berbagai kesempatan.',
            'celana-kerja-wanita-kantor-formal-bahan' => 'Celana kerja wanita bergaya formal untuk melengkapi penampilan ke kantor atau acara resmi.',
            'celana-kerja-wanita-slim-fit' => 'Celana kerja wanita dengan potongan slim fit untuk tampilan rapi dan profesional.',
            'celana-kulot-highwaist-kantong-depan-jeans' => 'Kulot jeans highwaist dengan kantong depan, memadukan potongan lebar dan gaya denim kasual.',
            'celana-kulot-jeans' => 'Kulot berbahan jeans dengan tampilan kasual yang mudah dipadukan dengan berbagai atasan.',
            'celana-kulot-jeans-panjang' => 'Kulot jeans panjang untuk pilihan gaya kasual dengan siluet yang leluasa.',
            'celana-kulot-levis-wanita' => 'Kulot wanita bergaya jeans untuk melengkapi penampilan kasual sehari-hari.',
            'celana-kulot-panjang-wanita-spandex' => 'Kulot panjang wanita berbahan spandex dengan potongan leluasa untuk gaya sehari-hari.',
            'celana-kulot-pendek' => 'Kulot pendek dengan potongan santai untuk pilihan busana kasual.',
            'celana-kulot-wanita' => 'Kulot wanita dengan siluet lebar yang mudah dipadukan untuk berbagai kegiatan.',
            'celana-panjang-baggy-pria' => 'Celana panjang baggy pria dengan potongan longgar untuk tampilan kasual.',
            'celana-panjang-pria-jogger' => 'Celana jogger panjang pria untuk gaya santai dan sporty sehari-hari.',
            'celana-pendek-gadis-remaja' => 'Celana pendek untuk gadis remaja dengan gaya kasual yang cocok dipadukan dengan atasan favorit.',
            'celana-pendek-highwaist-wanita' => 'Celana pendek wanita model highwaist untuk melengkapi penampilan kasual.',
            'celana-pendek-pria' => 'Celana pendek pria dengan desain sederhana untuk aktivitas santai sehari-hari.',
            'celana-pendek-pria-cowok-resleting-premium' => 'Celana pendek pria dengan detail resleting dan tampilan kasual yang rapi.',
            'celana-pendek-pria-jeans-korean' => 'Celana jeans pendek pria bergaya Korea untuk pilihan tampilan kasual.',
            'celana-pendek-pria-premium' => 'Celana pendek pria dengan tampilan rapi yang mudah dipadukan untuk berbagai aktivitas santai.',
            'celana-pendek-pria-santai' => 'Celana pendek pria untuk bersantai dengan gaya simpel dan kasual.',
            'celana-pendek-wanita' => 'Celana pendek wanita dengan model kasual untuk melengkapi gaya sehari-hari.',
            'celana-pendek-wanita-hot-pants' => 'Hot pants wanita dengan potongan pendek untuk tampilan kasual yang percaya diri.',
            'celana-rayon-hommy-kallyotfit' => 'Celana rayon dengan model Hommy Kallyotfit untuk pilihan busana santai.',
            'celana-sivali-loose-pants' => 'Loose pants Sivali dengan potongan longgar untuk tampilan kasual yang leluasa.',
            'celana-sobek-pria-ripped-jeans' => 'Ripped jeans pria dengan detail sobekan untuk gaya denim kasual.',
            'celana-standar-pria-dewasa-kulot-pria' => 'Celana pria model standar dengan tampilan simpel untuk dipakai dalam berbagai kegiatan.',
            'hoodie-pria-gambar-anime' => 'Hoodie pria dengan gambar anime sebagai aksen untuk gaya kasual sehari-hari.',
            'jaket-couple-sport-cowok-cewek' => 'Jaket couple bergaya sporty untuk pilihan tampilan serasi bagi pria dan wanita.',
            'jaket-cowok-keren-terbaru' => 'Jaket pria dengan desain kasual modern yang mudah dipadukan dengan pakaian sehari-hari.',
            'jaket-crop-denim-lengan-pendek' => 'Jaket crop denim berlengan pendek untuk melengkapi gaya kasual.',
            'jaket-fashionable-untuk-wanita-dan-cowok' => 'Jaket bergaya kasual untuk wanita maupun pria, mudah dipadukan untuk berbagai penampilan.',
            'jaket-hoodie-baju-lengan-panjang' => 'Jaket hoodie berlengan panjang untuk pilihan busana santai sehari-hari.',
            'jaket-hoodie-nike-tech-fleece-windrunner' => 'Jaket hoodie bergaya Tech Fleece Windrunner dengan tampilan sporty.',
            'jaket-hoodie-pria' => 'Jaket hoodie pria dengan gaya kasual yang cocok untuk kegiatan sehari-hari.',
            'jaket-hoodie-warna-hitam-bahan-tebal' => 'Jaket hoodie hitam dengan bahan tebal untuk pilihan gaya kasual.',
            'jaket-hoodie-zipper-jaket-polos-sweater' => 'Jaket hoodie polos dengan ritsleting dan model sweater untuk tampilan kasual.',
            'jaket-jeans-oversize' => 'Jaket jeans model oversize untuk tampilan denim yang santai.',
            'jaket-parasut-pria-dan-wanita' => 'Jaket parasut untuk pria dan wanita dengan desain kasual yang mudah dipadukan.',
            'jaket-pria-wanita-bomber-original' => 'Jaket model bomber untuk pria maupun wanita dengan tampilan kasual.',
            'jaket-varsity-hoodie-jaket-baseball' => 'Jaket bergaya varsity dan baseball dengan sentuhan hoodie untuk tampilan kasual.',
            'jaket-varsity-hoodie-jaket-baseball-bomber-kancing-pria' => 'Jaket pria bergaya varsity, baseball, dan bomber dengan detail kancing.',
            'jaket-varsity-modern-keren-baseball' => 'Jaket varsity bergaya baseball dengan tampilan modern untuk melengkapi gaya kasual.',
            'jaket-vintage' => 'Jaket bergaya vintage untuk pilihan tampilan kasual dengan nuansa klasik.',
            'jaket-wanita-musim-dingin-hoodie-bulu-tebal-terbaru' => 'Jaket hoodie wanita dengan tampilan tebal dan aksen bulu untuk melengkapi busana cuaca dingin.',
            'jeans-cowok-gombrong' => 'Jeans pria dengan potongan gombrong untuk tampilan denim kasual.',
            'jeans-denim-korea' => 'Celana jeans denim bergaya Korea untuk pilihan busana kasual sehari-hari.',
            'jeans-pria-panjang-baggy-pants' => 'Jeans panjang pria model baggy dengan potongan longgar untuk gaya santai.',
            'jeans-pria-standar' => 'Jeans pria dengan potongan standar yang mudah dipadukan untuk berbagai kesempatan.',
            'jeans-skinny-pensil' => 'Jeans model skinny pensil dengan potongan mengikuti bentuk kaki untuk tampilan kasual.',
            'kaos-snowman' => 'Kaos hitam dengan gambar karakter snowman lucu.',
            'kaos-smile' => 'Kaos putih oversized dengan desain wajah tersenyum.',
            'kaos-minimalist' => 'Kaos abu-abu dengan desain grafis minimalis.',
            'kaos-cartoon' => 'Kaos hitam oversized dengan ilustrasi kartun.',
            'kulot-cewek-linen-celana' => 'Celana kulot wanita berbahan linen dengan potongan leluasa untuk gaya kasual.',
            'megan-jaket-crop-lengan-panjang' => 'Jaket crop lengan panjang dengan desain kasual yang mudah dipadukan.',
            'modis-jaket-wanita-dan-pria' => 'Jaket bergaya modis untuk wanita dan pria, cocok untuk melengkapi penampilan kasual.',
            'outer-jaket-wanita-dan-pria' => 'Outer jaket untuk wanita maupun pria sebagai lapisan tambahan pada gaya sehari-hari.',
            'sivali-factory-bonnie-cargo-pants' => 'Cargo pants Sivali Factory Bonnie dengan gaya kasual yang mudah dipadukan.',
            'zia-cargo-pants-wanita' => 'Cargo pants wanita dengan tampilan kasual untuk melengkapi gaya sehari-hari.',
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
            if (! isset($descriptions[$slug])) {
                throw new RuntimeException('Deskripsi produk belum disiapkan: '.$slug);
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
                'description' => $product->description ?: $descriptions[$slug],
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