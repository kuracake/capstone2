<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('user_addresses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        // Simpan ID agar kompatibel dengan RajaOngkir
        $table->string('province_id'); 
        $table->string('province_name');
        $table->string('city_id');
        $table->string('city_name');
        $table->string('district_id')->nullable(); 
        $table->string('district_name');
        $table->string('postal_code');
        $table->text('address_detail');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
