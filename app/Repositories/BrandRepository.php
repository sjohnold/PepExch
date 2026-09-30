<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use lluminate\Http\Request;


class BrandRepository extends Repository
{
    public static function model()
    {
        return Brand::class;
    }

    public static function getPaginatedBrands($request, $perPage = 10)
    {
        return self::query()->latest()->with('thumbnail')->where('name', 'like', '%' . $request->input('search', '') . '%')->paginate($perPage);
    }

    public static function findWithThumbnail($id)
    {
        return self::query()->with('thumbnail')->findOrFail($id);
    }


    public static function storeBrand($request)
    {
        $thumbnailId = null;

        if ($request->hasFile('thumbnail')) {
            $media = MediaRepository::storeByRequest($request->file('thumbnail'), 'brands');
            $thumbnailId = $media->id;
        }

        return self::create([
            'name' => $request->name,
            'is_active' => $request->is_active,
            'thumbnail_id' => $thumbnailId,
        ]);
    }


    public static function updateBrand($request, $id)
    {
        $brand = self::findOrFail($id);



        // If thumbnail uploaded, add it
        if ($request->hasFile('thumbnail')) {
            $media = MediaRepository::updateByRequest($brand, $request->file('thumbnail'), 'brands');
            $brand->thumbnail_id = $media->id;
            $brand->save();
        }

        // Update brand
        $brand->update([
            'name' => $request->input('name') ?? $brand->name,
            'is_active' => $request->is_active,
        ]);

        return $brand;
    }


    public static function getActive()
    {
        return self::query()->active()->get();
    }



    public static function deleteBrand($id)
    {
        $brand = self::findOrFail($id);

        if ($brand->thumbnail_id) {
            $media = MediaRepository::find($brand->thumbnail_id);
            if ($media) {
                if (Storage::disk('public')->exists($media->src)) {
                    Storage::disk('public')->delete($media->src);
                }
            }
        }
        return $brand->delete();
    }
}
