<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageThumbnail extends Model
{
    protected $table = 'message_thumbnails';
    public $timestamps = false; // Disable automatic timestamps

    protected $fillable = [
        'message_id',
        'media_id',
    ];

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id'); // adjust column name
    }
}
