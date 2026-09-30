<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'is_active' => 'boolean',
        'config' => 'array', // automatically cast JSON to array
    ];

    /**
     * Relationship with Media.
     */
    public function media()
    {
        return $this->belongsTo(Media::class);
    }

       public function imagePath(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->media && !empty($this->media->src)
                ? asset($this->media->src)  // wrap src in asset()
                : asset('assets/img/payment/default.png') // fallback
        );
    }

}
