<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\VideoTutorial;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. ADMIN
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@bougainvilla.com',
            'is_admin' => true,
            'password' => bcrypt('password'),
        ]);

        // 2. PRODUK (Bahasa Indonesia)
        Product::create([
            'name' => 'Pink Paradise',
            'description' => 'Kelopak merah muda lembut yang menawan hati.',
            'price' => 150000,
            'image_path' => null, 
        ]);
        Product::create([
            'name' => 'Crimson Beauty',
            'description' => 'Warna merah menyala yang berani dan elegan.',
            'price' => 175000,
            'image_path' => null,
        ]);
        Product::create([
            'name' => 'White Angel',
            'description' => 'Putih suci yang memberikan kesan damai.',
            'price' => 160000,
            'image_path' => null,
        ]);
        Product::create([
            'name' => 'Sunset Orange',
            'description' => 'Warna oranye cerah seperti matahari terbenam.',
            'price' => 180000,
            'image_path' => null,
        ]);

        // 3. VIDEO TUTORIAL
        VideoTutorial::create([
            'title' => 'Cara Membuka Paket', 
            'description' => 'Pelajari cara aman membuka kotak bugenvil Anda.',
            'video_url' => 'https://www.youtube.com/embed/S2q8-gOq-0A'
        ]);
        VideoTutorial::create([
            'title' => 'Panduan Menanam', 
            'description' => 'Langkah demi langkah menanam di tanah atau pot.',
            'video_url' => 'https://www.youtube.com/embed/abc456'
        ]);
        VideoTutorial::create([
            'title' => 'Perawatan & Pemupukan', 
            'description' => 'Tips penting agar bunga tetap sehat dan mekar.',
            'video_url' => 'https://www.youtube.com/embed/def789'
        ]);
    }
}