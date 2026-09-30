<?php

namespace App\Http\Resources\Product;

use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isWishlisted = false;

        if (Auth::guard('api')->check()) {
            $isWishlisted = Wishlist::query()
                ->where('user_id', Auth::guard('api')->user()->id)
                ->where('selling_post_id', $this->id)
                ->exists();
        }

        return [
            'id' => $this?->id ?? $this?->selling_post_id,
            'name' => $this->name,
            'asking_price' => $this->asking_price,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'address' => getLocationName($this->latitude, $this->longitude),
            'created_at' => Carbon::parse($this->created_at)->format('d F, Y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('d F, Y'),
            'thumbnail' => $this->profilePath,
            'user' => ProductUserResource::make($this->user),
            'is_wishlisted' => $isWishlisted,
        ];
    }
}
