<?php
namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\FastSelling;

class FastSellingRepository extends Repository
{
    public static function model()
    {
        return FastSelling::class;    
    }
}