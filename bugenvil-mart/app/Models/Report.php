<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // Sesuai dengan database Anda
    protected $fillable = [
        'user_id',
        'order_id',           
        'product_id',         
        'subject',            // Kolom subject Anda
        'description',        // Kolom description Anda
        'evidence_image_path', // Kolom foto Anda
        'status',             
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }
}