<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;


class NotificationHistory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function notificationReceiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function notificationSender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function notifyProfilePic()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }
}
