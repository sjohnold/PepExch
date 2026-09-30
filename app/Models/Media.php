<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $table = 'medias';
    protected $guarded = ['id'];

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function banners()
    {
        return $this->belongsToMany(Banner::class, 'banner_thumbnails', 'media_id', 'banner_id')
            ->withTimestamps();
    }
}
