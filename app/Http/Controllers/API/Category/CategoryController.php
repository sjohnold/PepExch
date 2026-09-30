<?php

namespace App\Http\Controllers\API\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryResource;
use App\Repositories\CategoryRepository;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;


#[Group('Category')]
class CategoryController extends Controller
{
    /**
     * Category List
     *
     */

    public function index(Request $request)
    {
        $perPage = $request->input('items_per_page', 20);
        $pageNumber = $request->input('page_number', 1);
        $skip = ($pageNumber - 1) * $perPage;

        $query = CategoryRepository::query()->with('thumbnail');

        $categories = $query->skip($skip)
            ->take($perPage)
            ->get();

        $totalItems = CategoryRepository::query()->count();

        return $this->json('Categories fetched successfully', [
            'total_categories' => $totalItems,
            'items_per_request' => count($categories),
            'categories' => CategoryResource::collection($categories),
        ]);
    }

    public function subCategories($id)
    {
        $categories = CategoryRepository::query()->with('thumbnail')->where('parent_id', $id)->get();

        return $this->json('Categories fetched successfully', [
            'categories' => CategoryResource::collection($categories),
        ]);
    }
}
