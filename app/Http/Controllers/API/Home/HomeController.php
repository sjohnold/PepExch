<?php

namespace App\Http\Controllers\API\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Product\ProductResource;
use App\Repositories\BannerRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\SellingPostRepository;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = CategoryRepository::query()->with('thumbnail')->latest()->take(6)->get();
        $banner = BannerRepository::query()->first();
        $boostedProducts = SellingPostRepository::getBoostedProducts();

        $data = [
            'categories ' => CategoryResource::collection($categories),
            'banner' => BannerResource::make($banner),
            'boostedProducts' => ProductResource::collection($boostedProducts),
        ];

        return $this->json('Home Fetched Successfully', $data, 200);
    }


    // Near Products
    public function nearProducts(Request $request)
    {
        $nearProducts = SellingPostRepository::getNearProducts($request);
        $data = [
            'nearProducts' => ProductResource::collection($nearProducts),
        ];
        return $this->json('Near Product Fetched Successfully', $data, 200);
    }
}
