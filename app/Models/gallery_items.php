<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class gallery_items extends Model
{
    use HasFactory;
    public $fillable = [
        'device_gallery_id',
        'device_id',
        'user_id',
        'media_type',
        'media_url',
        'size'
    ];

    public function s3Url()
    {
        $mins = 5;
        $user = clients::where('client_id', session('user_id'))->first();
        $url = Storage::disk('s3')->temporaryUrl(
            'gallery/images/' . $user->client_id . '/' . $user->device_id . '/' . $this->media_url,
            now()->addMinutes($mins)
        );
        return $url;
    }
}
