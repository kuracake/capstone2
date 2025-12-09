<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2); // Harga Asli
            $table->integer('stock')->default(0); // Stok
            $table->string('image')->nullable(); // Foto Produk
            
            // --- KOLOM LENGKAP ---
            $table->integer('weight')->default(1000); // Berat (Gram)
            $table->decimal('discount_price', 12, 2)->nullable(); // Harga Diskon
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};