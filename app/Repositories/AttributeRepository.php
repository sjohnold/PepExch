<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Attribute;

class AttributeRepository extends Repository
{
    public static function model()
    {
        return Attribute::class;
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
        $attribute = self::find($data['id']);
        if ($attribute) {
            $attribute->update([
                'name' => $data['name'],
                'category_id' => $data['category_id'],
                'parent_id' => $data['parent_id'] ?? null,
            ]);
            return $attribute;
        }
        return null;
    }
    public static function getAllExcept($id)
    {
        return self::query()->where('id', '!=', $id)->get();
    }

    public static function DeleteData($id)
    {
        $attribute = self::find($id);
        if ($attribute) {
            return $attribute->delete();
        }
        return false;
    }
}
