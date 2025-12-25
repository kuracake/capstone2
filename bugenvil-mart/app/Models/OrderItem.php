<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'quantity',
        'price',
    ];

    // Relasi ke Order Utama
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi ke Produk (INI YANG PENTING AGAR GAMBAR MUNCUL)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}