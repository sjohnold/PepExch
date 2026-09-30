<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Brand extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

        protected $casts = [
        'is_active' => 'boolean',
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
        return $query->where('is_active', true);
    }


    public function thumbnail()
    {
        return $this->belongsTo(Media::class, 'thumbnail_id');
    }

    public function thumbnailPath(): Attribute
    {
        $path = "https://placehold.co/600x400";

        if ($this->thumbnail && Storage::exists($this->thumbnail?->src)) {
            $path = Storage::url($this->thumbnail->src);
        }

        return Attribute::make(
            get: fn() => $path,
        );
    }

    public function sellingPosts()
    {
        return $this->hasMany(SellingPost::class, 'brand_id');
    }
}
