<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute as CatAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function thumbnail()
    {
        return $this->belongsTo(Media::class, 'thumbnail_id');
    }

    public function thumbnailPath(): CatAttribute
    {
        $path = "https://placehold.co/600x400";

        if ($this->thumbnail && Storage::exists($this->thumbnail?->src)) {
            $path = Storage::url($this->thumbnail->src);
        }

        return CatAttribute::make(
            get: fn() => $path
        );
    }

    public function child()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class, 'category_id');
    }
    public function sellingPosts()
    {
        return $this->belongsToMany(SellingPost::class, 'post_categories', 'category_id', 'selling_post_id');
    }


}
