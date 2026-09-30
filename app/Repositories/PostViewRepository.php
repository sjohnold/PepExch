<?php
namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\PostView;

class PostViewRepository extends Repository
{
    public static function model()
    {
        return PostView::class;    
    }
}