<?php

namespace App\Models;

use App\Repositories\MediaRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;


class Testimonial extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    protected $casts = [
        'status' => 'boolean',
    ];

    protected function isActive(): Attribute
    {
        return Attribute::make(
            get: fn($value) => (bool)$value,
            set: fn($value) => filter_var($value, FILTER_VALIDATE_BOOLEAN)
        );
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function thumbnile()
    {
        return $this->belongsTo(Media::class, 'thumbnail_id');
    }
    public function thumbnail()
    {
        return $this->belongsTo(Media::class, 'thumbnail_id');
    }


    protected function thumbnailPath(): Attribute
    {
        return Attribute::make(
            // GETTER
            get: fn() =>
            $this->thumbnail?->src
                ? asset('storage/' . $this->thumbnail->src)
                : 'https://placehold.jp/250x250.png',

            // SETTER
            set: function ($file) {
                if (empty($file)) {
                    return ['thumbnail_id' => null];
                }

                $media = MediaRepository::storeByRequest($file, 'thumbnails');

                return ['thumbnail_id' => $media->id];
            }
        );
    }
}
