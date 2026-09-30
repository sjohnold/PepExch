<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;

use App\Models\BoostPlan;

class BoostPlanRepository extends Repository
{
    public static function model()
    {
        return BoostPlan::class;
    }
    public static function countByPlans($status = null)
    {
        $query = self::query()->count();
        return $query;
    }
    public static function countBySold($status = null)
    {
        return BoostPostRepository::getAll()->count();
    }
    public static function countByTrash($status = null)
    {
        return BoostPlan::onlyTrashed()->count();
    }


}
