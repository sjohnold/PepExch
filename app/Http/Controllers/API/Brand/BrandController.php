<?php

namespace App\Http\Controllers\API\Brand;

use App\Http\Controllers\Controller;
use App\Http\Resources\Brand\BrandResource;
use App\Repositories\BrandRepository;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = BrandRepository::query()->get();

        return $this->json('Brands fetched successfully', [
            'brands' => BrandResource::collection($brands),
        ]);
    }
}
