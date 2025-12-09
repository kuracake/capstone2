<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // KITA IZINKAN SEMUA KOLOM INI DISIMPAN
    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'stock',          // Wajib
        'weight',         // Wajib untuk ongkir
        'discount_price', // Opsional
    ];
}