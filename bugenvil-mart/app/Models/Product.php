<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'stock',
        'weight',
    ];

    /**
     * Relasi ke Review
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Relasi ke Order Items (Untuk hitung Terjual)
     * BARU DITAMBAHKAN
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relasi ke ProductImage (Galeri Foto)
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Helper untuk mengambil foto utama
    public function getThumbnailAttribute()
    {
        if ($this->image) {
            return $this->image;
        }
        
        return $this->images->first() ? $this->images->first()->image_path : null;
    }
}