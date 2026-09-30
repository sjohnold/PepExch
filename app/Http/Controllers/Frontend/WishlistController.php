<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SellingPost;
use App\Models\Wishlist;
use App\Repositories\SellingPostRepository;
use App\Repositories\WishlistRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{

    public function index()
    {

        $wishlistIds = WishlistRepository::query()->where('user_id', Auth::id())
            ->pluck('selling_post_id')
            ->toArray();

        $products = SellingPostRepository::query()
            ->whereIn('id', $wishlistIds)
            ->with(['user', 'brand', 'thumbnails', 'profile', 'categories', 'activeBoost', 'offers'])
            ->withCount('views')
            ->paginate(8);

        return \Inertia\Inertia::render('Wishlist', [
            'products' => $products->through(fn ($product) => $this->mapProduct($product)),
            'wishlistIds' => $wishlistIds,
        ]);
    }

    public function addWishlist($postId)
    {
        $message = WishlistRepository::toggleWishlist($postId);

        return redirect()->back()->with('success', $message);
    }

    private function mapProduct($product): array
    {
        $category = $product->categories?->first();

        return [
            'id' => $product->id,
            'name' => $product->name,
            'title' => $product->name,
            'description' => $product->description,
            'desc' => $product->description,
            'status' => $product->status,
            'created_label' => $product->created_at?->diffForHumans() ?? __('Just now'),
            'profilePath' => $product->profilePath,
            'img_url' => $product->profilePath,
            'thumbnail' => $product->profilePath,
            'location' => $product->location,
            'location_name' => $product->location_name,
            'category' => [
                'id' => $category?->id,
                'name' => $category?->name,
            ],
            'categories' => $product->categories?->map(fn ($category) => [
                'id' => $category->id,
                'name' => $category->name,
            ])->values() ?? [],
            'views_count' => $product->views_count ?? $product->number_of_view ?? 0,
            'offers_count' => $product->relationLoaded('offers') ? $product->offers->count() : 0,
            'is_boosted' => (bool) $product->activeBoost,
        ];
    }
}
