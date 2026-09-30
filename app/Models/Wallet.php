<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Wallet extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function image()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function imagePath(): Attribute
    {
        $path = asset('media/demo-img.png');

        if ($this->image && Storage::exists($this->image->src)) {
            $path = Storage::url($this->image->src);
        }

        return Attribute::make(
            get: fn() => $path,
        );
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }
}
