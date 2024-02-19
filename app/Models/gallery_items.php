<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        $mins = 120;
        $user = clients::where('client_id', session('user_id'))->first();
        // $directory = 'gallery/images/' . $user->name . '/' . $user->device_id;
        // $type = $this->media_type == 'image' ? 'images/' : 'videos/';
        $url = Storage::disk('s3')->temporaryUrl(
            'gallery/images/' . $user->client_id . '/' . $user->device_id . '/' . $this->media_url,
            now()->addMinutes($mins)
        );
        return $url;
    }
}
