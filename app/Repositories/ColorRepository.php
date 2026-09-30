<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Color;

class ColorRepository extends Repository
{
    public static function model()
    {
        return Color::class;
    }
    public static function getAllOrSearch($perPage = 15)
    {
        $searchKey = request('search');
        $query = self::query();

        if ($searchKey) {
            $query->where('name', 'like', "%{$searchKey}%");
        }

        return $query->latest('id')->paginate($perPage);
    }

    public static function StoreData($data)
    {
        return self::create($data);
    }

    public static function UpdateData($data)
    {
        $color = self::find($data['id']);
        if ($color) {
            $color->update($data);
            return $color;
        }
        return null;
    }


}
