<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Brand\BrandResource;
use App\Http\Resources\User\UserResource;
use App\Models\Wishlist;
use App\Repositories\ReviewRepository;
use App\Repositories\WishlistRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProductDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $user = auth('sanctum')->user() ?? auth()->user();
        
        $reviewCount = 0;
        $averageRating = 0;
        
        if ($this->user_id) {
            $query = ReviewRepository::query()->where('seller_id', $this->user_id);
            $reviewCount = $query->count();
            $totalRating = $query->sum('rating');
            $averageRating = $reviewCount > 0 ? number_format($totalRating / $reviewCount, 1) : 0;
        }

        $isWishListed = $user ? \App\Models\Wishlist::where('user_id', $user->id)
            ->where('selling_post_id', $this->id)
            ->exists() : false;

        $images = $this->allImages;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'thumbnail' => $images[0] ?? null,
            'additional_thumbnails' => $images,
            'reviewCount' => $reviewCount,
            'averageRating' => $averageRating,
            'asking_price' => $this->asking_price,
            'conditions' => $this->conditions,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'location_name' => $this->location_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'brand' => BrandResource::make($this->brand),
            'model' => $this->model,
            'warranty_left' => $this->warranty_left,
            'color_code' => $this->color_code,
            'description' => $this->description,
            'number_of_view' => $this->number_of_view,
            'is_negotiable' => $this->is_negotiable,
            'user' => UserResource::make($this->user),
            'is_wishlisted' => $isWishListed,
        ];
    }
}
