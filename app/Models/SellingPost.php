<?php

namespace App\Models;

use App\Models\Attribute as ModelsAttribute;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class SellingPost extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "selling_posts";

    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    protected $casts = [
        'expired_at' => 'datetime',
        'exchange_categories_json' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_categories', 'selling_post_id', 'category_id');
    }
    public function attributes()
    {
        return $this->belongsToMany(ModelsAttribute::class, 'post_attributes', 'selling_post_id', 'attribute_id');
    }

    public function thumbnails()
    {
        return $this->belongsToMany(
            Media::class,
            'post_thumbnails',
            'selling_post_id',
            'media_id'
        )->withPivot('default');
    }


    public function thumbnailPaths(): Attribute
    {
        return Attribute::make(
            get: function () {

                // ensure thumbnails is loaded
                $thumbnails = $this->relationLoaded('thumbnails')
                    ? $this->thumbnails
                    : $this->thumbnails()->get();

                if ($thumbnails->isEmpty()) {
                    return [asset('media/demo-product.jpg')];
                }

                return $thumbnails->map(function ($thumb) {
                    if ($thumb->src && Storage::disk('public')->exists($thumb->src)) {
                        return Storage::url($thumb->src);
                    }
                    return asset('media/demo-product.jpg');
                });
            }
        );
    }

    public function allImages(): Attribute
    {
        return Attribute::make(
            get: function () {
                $images = [];
                $mainImage = null;

                if ($this->media_id && $this->profile && Storage::disk('public')->exists($this->profile->src)) {
                    $mainImage = Storage::url($this->profile->src);
                    $images[] = $mainImage;
                }

                // Additional thumbnails
                $additional = $this->thumbnails ?? collect();

                foreach ($additional as $thumb) {
                    if ($thumb->src && Storage::disk('public')->exists($thumb->src)) {
                        $url = Storage::url($thumb->src);

                        // Only add if different from mainImage
                        if ($url !== $mainImage) {
                            $images[] = $url;
                        }
                    }
                }

                return array_values(array_unique($images));
            }
        );
    }

    public function defaultThumbnail()
    {
        return $this->belongsToMany(
            Media::class,
            'post_thumbnails',
            'selling_post_id',
            'media_id'
        )->wherePivot('default', 1)
            ->limit(1);
    }

    public function profile()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }
    public function profilePath(): Attribute
    {
        $path = asset('media/demo-product.jpg');

        if ($this->profile && Storage::disk('public')->exists($this->profile->src)) {
            $path = Storage::url($this->profile->src);
        }

        return Attribute::make(
            get: fn() => $path
        );
    }

    public function boosts()
    {
        return $this->belongsToMany(BoostPlan::class, 'boost_posts', 'selling_post_id', 'boost_plan_id')->withPivot('expired_at');;
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function views()
    {
        return $this->hasMany(PostView::class);
    }


    public function rating()
    {
        return $this->hasMany(Testimonial::class);
    }
    public function boostPost()
    {
        return $this->hasOne(BoostPost::class);
    }


    public function activeBoost()
    {
        return $this->hasOne(BoostPost::class)
            ->where('expired_at', '>', Carbon::now());
    }

    public function getLocationNameAttribute(): ?string
    {
        if ($this->latitude && $this->longitude) {
            return getLocationName($this->latitude, $this->longitude);
        }

        return null;
    }
    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'wishlists');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'selling_post_id');
    }
}
