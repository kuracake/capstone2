<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus user lama jika ada (untuk mencegah duplikat)
        User::where('email', 'admin@gmail.com')->delete();

        // Buat Akun Admin
        User::create([
            'name' => 'Admin Ganteng',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => 1, // Pastikan kolom ini sesuai dengan migrasi Anda
            'email_verified_at' => now(),
        ]);
        
        // Buat User Biasa (Opsional, untuk tes)
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@gmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => 0,
            'email_verified_at' => now(),
        ]);
    }
}