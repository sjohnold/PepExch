<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'services' => 'array',
    ];

    public function getServicesWithMediaAttribute()
    {
        return collect($this->services)->map(function ($item) {
            $media = Media::find($item['thumbnail_id']);
            $item['thumbnail_url'] = $media?->src ? Storage::url($media->src) : null;

            return $item;
        });
    }









}
