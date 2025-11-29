<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
 // Ganti isinya dengan ini
protected $fillable = ['order_id', 'product_id', 'product_name', 'quantity', 'price'];
}
