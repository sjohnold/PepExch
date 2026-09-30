<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getSubcategories($id)
    {
        $subcategories = CategoryRepository::query()->where('parent_id', $id)->get();

        if ($subcategories->isEmpty()) {
            return response()->json([
                'status' => 'empty',
                'message' => 'No Sub Category'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $subcategories
        ]);
    }
}
