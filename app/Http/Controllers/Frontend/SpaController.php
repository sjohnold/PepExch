<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SellingPost;
use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Repositories\BannerRepository;
use App\Repositories\TestimonialRepository;
use App\Repositories\SellingPostRepository;
use App\Repositories\WishlistRepository;

class SpaController extends Controller
{
    public function index()
    {
        $mapPost = fn($post) => [
            'id' => $post->id,
            'title' => $post->name,
            'desc' => $post->description,
            'img_url' => $post->profilePath, 
            'location' => $post->location,
            'category' => [
                'id' => $post->categories->first()?->id,
                'name' => $post->categories->first()?->name,
            ],
            'views_count' => $post->views_count ?? 0, 
            'offers_count' => $post->offers->count(),
            'is_boosted' => $post->activeBoost ? true : false,
        ];

        $boostedProducts = SellingPostRepository::getBoostedProducts(10)->map($mapPost);
        $newProducts = SellingPostRepository::getNewProducts(10)->map($mapPost);
        
        // Latest listings for the grid
        $listings = SellingPostRepository::filterProducts(request())
            ->with(['categories', 'profile', 'offers', 'activeBoost'])
            ->withCount('views')
            ->latest()
            ->take(20)
            ->get()
            ->map($mapPost);

        // Get main categories (parent_id is null) with their children
        $categories = Category::with(['child', 'thumbnail'])
            ->whereNull('parent_id')
            ->get()
            ->map(function($cat) {
                return [
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'icon_url' => $cat->thumbnailPath,
                    'subs' => $cat->child->pluck('name')->toArray(),
                ];
            });

        $banner = BannerRepository::query()->with('thumbnails')->first();
        $bannerData = $banner ? [
            'title' => $banner->title,
            'sub_title' => $banner->sub_title,
            'description' => $banner->description,
            'address' => $banner->address,
            'images' => $banner->thumbnailPaths,
        ] : null;

        $testimonials = TestimonialRepository::query()
            ->with('thumbnail')
            ->active()
            ->latest()
            ->take(6)
            ->get()
            ->map(fn($t) => [
                'name' => $t->name,
                'designation' => $t->designation,
                'comment' => $t->comment,
                'star' => $t->star,
                'avatar' => $t->thumbnailPath
            ]);

        $wishlistIds = Auth::check() 
            ? WishlistRepository::query()->where('user_id', Auth::id())->pluck('selling_post_id')->toArray()
            : [];

        return Inertia::render('Home', [
            'listings' => $listings,
            'boostedProducts' => $boostedProducts,
            'newProducts' => $newProducts,
            'categories' => $categories,
            'banner' => $bannerData,
            'testimonials' => $testimonials,
            'wishlistIds' => $wishlistIds,
            'auth' => [
                'user' => Auth::user(),
            ],
        ]);
    }
}
