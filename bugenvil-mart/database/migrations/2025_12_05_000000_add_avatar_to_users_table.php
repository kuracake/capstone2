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
        Schema::table('users', function (Blueprint $table) {
            // Cek dulu agar tidak error jika kolom sudah ada
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 20)->nullable()->after('avatar');
            }
            if (!Schema::hasColumn('users', 'gender')) {
                $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('gender');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'phone', 'gender', 'address']);
        });
    }
};