<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\BoostPlan;
use App\Models\BoostPost;
use Illuminate\Support\Facades\DB;

class BoostPostRepository extends Repository
{
    public static function model()
    {
        return BoostPost::class;
    }

    public static function getTopSoldPlans()
    {
        return BoostPlan::withCount('boostPosts')
            ->orderByDesc('boost_posts_count')
            ->take(5)
            ->get();
    }
}
