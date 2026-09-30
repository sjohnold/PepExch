<?php

namespace App\Http\Controllers\API\Banner;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Repositories\BannerRepository;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;

#[Group('Banner API')]
class BannerController extends Controller
{
    /**
     * Banner List
     *
     */
    public function index()
    {
        $banner = BannerRepository::query()->first();
        return $this->json('Banner Fetch successfully', BannerResource::make($banner));
    }
}
