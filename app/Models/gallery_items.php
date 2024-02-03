<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gallery_items extends Model
{
    use HasFactory;

    public $fillable = [
        'device_gallery_id',
        'device_id',
        'user_id',
        'media_type',
        'media_url'
    ];
}
