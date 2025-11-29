<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoTutorial extends Model
{
    use HasFactory;

    // Pastikan nama tabel sesuai dengan yang ada di migrasi
    protected $table = 'video_tutorials';
    
    protected $fillable = ['title', 'video_url', 'description'];
}