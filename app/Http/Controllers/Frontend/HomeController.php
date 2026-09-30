<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\Seting;
use App\Http\Controllers\Controller;
use App\Repositories\BannerRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\FastSellingRepository;
use App\Repositories\SellingPostRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\SettingRepository;
use App\Repositories\TestimonialRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Constants\CacheKey;
use App\Models\Wishlist;
use App\Repositories\WishlistRepository;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        $data = Cache::remember(
            CacheKey::HOME_PAGE,
            now()->addMinutes(30),
            function () {
                $frontendCategories = CategoryRepository::activeCategory();

                $banner = BannerRepository::query()->with('thumbnails')->first();
                $bannerPaths = $banner->thumbnailPaths;

                $boostedProducts = SellingPostRepository::getBoostedProducts();

                $testimonials = TestimonialRepository::query()
                    ->with('thumbnail')
                    ->active()
                    ->latest()
                    ->take(6)
                    ->get();
                $newProducts = SellingPostRepository::getNewProducts();

                $mainService = ServiceRepository::query()->first();

                $services = collect($mainService?->services_with_media)
                    ->where('status', 'active');

                $fastSelling = FastSellingRepository::query()
                    ->with('thumbnail')
                    ->latest()
                    ->first();

                $getAllData = SettingRepository::query()
                    ->where('type', Seting::DownloadLinks->value)
                    ->first();

                $allData = $getAllData ? json_decode($getAllData->data) : null;

                return compact(
                    'frontendCategories',
                    'banner',
                    'boostedProducts',
                    'testimonials',
                    'newProducts',
                    'mainService',
                    'services',
                    'allData',
                    'fastSelling',
                    'bannerPaths',
                );
            }
        );

        // User-specific wishlistIds
        $wishlistIds = WishlistRepository::query()->where('user_id', Auth::id())
            ->pluck('selling_post_id')
            ->toArray();

        return view('web.home', array_merge($data, [
            'wishlistIds' => $wishlistIds
        ]));
    }
}
