<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bersihkan user lama untuk mencegah duplikat error
        User::where('email', 'admin@gmail.com')->delete();
        User::where('email', 'user@gmail.com')->delete();

        // 2. Buat Akun Admin (LENGKAP dengan data dummy untuk kolom baru)
        User::create([
            'name' => 'Admin Ganteng',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => true, // Gunakan boolean true/false agar lebih aman
            'phone' => '081234567890', // Wajib diisi (dummy)
            'gender' => 'Laki-laki',   // Wajib diisi (dummy)
            'avatar' => null,          // Boleh null (jika diset nullable di migrasi) atau isi string kosong
            'email_verified_at' => now(),
        ]);
        
        // 3. Buat User Biasa (LENGKAP)
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@gmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => false,
            'phone' => '089876543210',
            'gender' => 'Perempuan',
            'avatar' => null,
            'email_verified_at' => now(),
        ]);
    }
}