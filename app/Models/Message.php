<?php

namespace App\Models;

use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'receiver_id',
        'selling_post_id',
        'offer_id',
        'contact',
        'is_read'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // Message belongs to a selling post (optional)
    public function sellingPost()
    {
        return $this->belongsTo(SellingPost::class, 'selling_post_id');
    }
    // Message has many thumbnails
    public function thumbnails()
    {
        return $this->belongsToMany(Media::class, 'message_thumbnails', 'message_id', 'media_id');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    public function chatUser()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }


    public function myPhoto(): Attribute
    {
        return new Attribute(
            get: fn() => $this->sender?->profilePhotoPath
        );
    }

    public function getMediaPathAttribute()
    {
        return $this->thumbnails->first()?->media?->src;
    }
}
