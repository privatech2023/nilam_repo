<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class images extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'device_id',
        'filename',
        'size'
    ];

    public function s3Url()
    {
        $mins = 5;
        $url = Storage::disk('s3')->temporaryUrl(
            'images/' . $this->filename,
            now()->addMinutes($mins)
        );
        return $url;
    }
}
