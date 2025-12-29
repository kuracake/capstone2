<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id', 
        'province_id', 'province_name', 
        'city_id', 'city_name', 
        'district_id', 'district_name',
        'village_name', 
        'postal_code', 'address_detail',
    ];
}