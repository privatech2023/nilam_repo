<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class videos extends Model
{
    use HasFactory;
    public $fillable = [
        'user_id',
        'device_id',
        'filename'
    ];

    public function s3Url()
    {
        $mins = 5;
        $url = Storage::disk('s3')->temporaryUrl(
            'videos/' . $this->filename,
            now()->addMinutes($mins)
        );
        return $url;
    }
}
