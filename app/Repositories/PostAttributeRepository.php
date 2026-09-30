<?php
namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\PostAttribute;
use App\Models\PostAttributes;

class PostAttributeRepository extends Repository
{
    public static function model()
    {
        return PostAttribute::class;    
    }
}