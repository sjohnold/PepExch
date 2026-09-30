<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Category;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class CategoryRepository extends Repository
{
    public static function model()
    {
        return Category::class;
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


    public static function store($request)
    {
        $thumbnailId = null;
        $isFeatured = false;

        if ($request->hasFile('thumbnail')) {
            $media = MediaRepository::storeByRequest($request->file('thumbnail'), 'thumbnails');
            $thumbnailId = $media->id;
        }

        if (isset($request->is_featured)) {
            $isFeatured = true;
        }

        return self::create([
            'name' => $request->name,
            'thumbnail_id' => $thumbnailId,
            'parent_id' => $request->parent_id,
            'is_featured' => $isFeatured,
        ]);
    }


    public static function updateCategory(Category $category, $request): Category
    {
        $category->name = $request->name ?? $category->name;
        $category->parent_id = $request->parent_id ?? $category->parent_id;

        if (isset($request->is_featured)) {
            $category->is_featured = true;
        } else {
            $category->is_featured = false;
        }

        if (isset($request->thumbnail)) {
            // Delete old image if exists
            if ($category->thumbnail && $category->thumbnail->file_path) {
                if (Storage::disk('public')->exists($category->thumbnail->file_path)) {
                    Storage::disk('public')->delete($category->thumbnail->file_path);
                }
                $category->thumbnail->delete();
            }

            $media = MediaRepository::updateByRequest($category, $request->file('thumbnail'), 'thumbnails');
            $category->thumbnail_id = $media->id;
        }
        $category->save();
        return $category->fresh();
    }

    public static function activeCategory()
    {
        return self::query()
            ->with('thumbnail')
            ->withCount([
                'sellingPosts as activePost' => function ($query) {
                    $query->where('status', 'Approve');
                }
            ])
            ->where('is_featured', 1)
            ->get();
    }
}
