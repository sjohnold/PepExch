<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function thumbnails()
    {
        return $this->belongsToMany(Media::class, 'banner_thumbnails', 'banner_id', 'media_id')
            ->withTimestamps();
    }

    public function thumbnailPaths(): Attribute
    {
        return Attribute::make(
            get: function () {
                $mediaItems = $this->thumbnails;
                if ($mediaItems->isEmpty()) {
                    return [asset('media/market/default.png')];
                }

                return $mediaItems->map(function ($media) {
                    return $media
                        ? Storage::url($media->src)
                        : asset('media/market/default.png');
                })->toArray();
            },
        );
    }
}
