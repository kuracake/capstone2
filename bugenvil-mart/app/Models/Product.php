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
     * Relasi ke ProductImage (Galeri Foto)
     * PERBAIKAN: Menggunakan $this, bukan $table
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Helper untuk mengambil foto utama (foto pertama)
    public function getThumbnailAttribute()
    {
        // Prioritas: Ambil dari kolom 'image', jika kosong baru cari di galeri
        if ($this->image) {
            return $this->image;
        }
        
        return $this->images->first() ? $this->images->first()->image_path : null;
    }
}