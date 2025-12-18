<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',          // Harus ada agar No. Pesanan tersimpan
        'product_id',
        'issue_description', // Harus ada agar Detail Kendala tersimpan
        'image',             // Harus ada agar Foto tersimpan
        'status',            // Default: 'pending'
    ];

    // Relasi untuk mengambil nama pelapor
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Relasi untuk mengambil data Pesanan
    public function order() {
        return $this->belongsTo(Order::class);
    }
}