<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('product_images', function (Blueprint $table) {
        $table->id();
        // Ini untuk menghubungkan ke tabel products
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        // Ini untuk menyimpan path gambar tambahan
        $table->string('image_path');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
