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
        'stock',  // Pastikan kolom ini ada di database
        'weight', // Pastikan kolom ini ada di database
    ];

    /**
     * Relasi ke Review
     * Satu produk memiliki banyak review
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}