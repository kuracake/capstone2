<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoTutorial extends Model
{
    // Tambahkan 'description' ke dalam fillable
    protected $fillable = ['title', 'description', 'video_url']; 
}