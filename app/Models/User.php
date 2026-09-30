<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_active' => 'datetime',
            'notif_matrix' => 'array',
        ];
    }

    public function profilePhoto()
    {
        return $this->belongsTo(Media::class, 'profile_photo_id');
    }

    public function profilePhotoPath(): Attribute
    {
        $path = asset('media/demo-img.png');

        if ($this->provider_img_url) {
            $path = $this->provider_img_url;
        }

        if ($this->profilePhoto && Storage::disk('public')->exists($this->profilePhoto->src)) {
            $path = Storage::url($this->profilePhoto->src);
        }

        return Attribute::make(
            get: fn() => $path,
        );
    }


    public function medias()
    {
        return $this->hasMany(Media::class, 'added_by');
    }
    public function posts()
    {
        return $this->hasMany(SellingPost::class);
    }


    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function sellingPosts()
    {
        return $this->hasMany(SellingPost::class, 'user_id');
    }

    public function receivedReviews()
    {
        return $this->hasMany(Review::class, 'seller_id');
    }

    public function givenReviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }
    public function messages()
    {
        return $this->hasMany(Conversation::class, 'sender_id');
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class, 'receiver_id')->latestOfMany();
    }
    public function lastMessageWithAuth(): HasOne
    {
        $authId = auth()->id();

        return $this->hasOne(Message::class, 'id', 'id')
            ->where(function ($q) use ($authId) {
                $q->where('sender_id', $authId)
                    ->where('receiver_id', $this->id)
                    ->orWhere(function ($q2) use ($authId) {
                        $q2->where('sender_id', $this->id)
                            ->where('receiver_id', $authId);
                    });
            })
            ->latest();
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id');
    }

    public function receivedReports()
    {
        return $this->hasMany(ReportSeller::class, 'seller_id');
    }

    public function submittedReports()
    {
        return $this->hasMany(ReportSeller::class, 'reporter_id');
    }

    public function getIsOnlineAttribute()
    {
        return $this->last_active && $this->last_active->gt(Carbon::now()->subMinutes(2));
    }

    public function wishlists()
    {
        return $this->belongsToMany(SellingPost::class, 'wishlists');
    }

    public function sentOffers()
    {
        return $this->hasMany(Offer::class, 'sender_id');
    }

    public function receivedOffers()
    {
        return $this->hasMany(Offer::class, 'receiver_id');
    }
}
