<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const CITIES = [
        'Jakarta',
        'Bandung',
        'Surabaya',
        'Yogyakarta',
        'Semarang',
        'Medan',
        'Makassar',
        'Denpasar',
        'Palembang',
        'Malang',
        'Solo',
        'Balikpapan',
    ];

    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('origin_city')->default('Jakarta');
        });

        $cityIndex = 0;
        DB::table('products')
            ->select('id')
            ->orderBy('id')
            ->chunkById(100, function ($products) use (&$cityIndex) {
                foreach ($products as $product) {
                    DB::table('products')
                        ->where('id', $product->id)
                        ->update(['origin_city' => self::CITIES[$cityIndex % count(self::CITIES)]]);
                    $cityIndex++;
                }
            });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('origin_city');
        });
    }
};
