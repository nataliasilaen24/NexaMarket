<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_promo')->default(false);
            $table->decimal('promo_price', 12, 2)->nullable();
            $table->index(['is_promo', 'stock']);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['is_promo', 'stock']);
            $table->dropColumn(['is_promo', 'promo_price']);
        });
    }
};
