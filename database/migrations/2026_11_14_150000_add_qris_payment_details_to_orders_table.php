<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('qris_transaction_id')->nullable();
            $table->text('qris_image_url')->nullable();
            $table->timestamp('qris_expires_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['qris_transaction_id', 'qris_image_url', 'qris_expires_at']);
        });
    }
};
