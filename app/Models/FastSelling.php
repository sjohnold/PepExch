<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FastSelling extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function thumbnail()
    {
        return $this->belongsTo(Media::class, 'thumbnail_id');
    }

    public function thumbnailPath(): Attribute
    {
        $path = 'https://placehold.co/600x400/png';

        if ($this->thumbnail || Storage::exists($this->thumbnail?->src)) {
            $path = Storage::url($this->thumbnail->src);
        }

        return Attribute::make(
            get: fn () => $path
        );
    }
}
