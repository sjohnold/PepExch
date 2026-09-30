<?php
namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Banner_thumbnail;

class Banner_thumbnailRepository extends Repository
{
    public static function model()
    {
        return Banner_thumbnail::class;    
    }
}