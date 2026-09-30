<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;;

class CategoryController extends Controller
{
    public function index()
    {
        $categoryPaginations = CategoryRepository::getAllOrSearch(15);

        return view('admin.category.index', compact('categoryPaginations'));
    }


    public function show($id)
    {
        $category = CategoryRepository::query()->with(['thumbnail', 'child.thumbnail'])->findOrFail($id);
        return view('admin.category.show', compact('category'));
    }

    public function create()
    {
        $parents = CategoryRepository::getAll();
        return view('admin.category.create', compact('parents'));
    }

    public function store(CategoryRequest $request)
    {
        CategoryRepository::store($request);

        Cache::forget('header_categories');
        return redirect()->route('category.index')
            ->with('success', 'Category created successfully');
    }


    public function edit(Category $category)
    {
        $parents = CategoryRepository::query()->pluck('name', 'id');
        return view('admin.category.edit', compact('category', 'parents'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail');
        }

        $updated = CategoryRepository::updateCategory($category, $request);

        if ($updated) {
            return redirect()->route('category.index')->with('success', 'Category updated successfully!');
        }

        Cache::forget('header_categories');
        return redirect()->route('category.index')->with('error', 'Failed to update category.');
    }


    public function delete(Category $category)
    {
        $category->delete();
        Cache::forget('header_categories');
        return back()->with('success', 'Category deleted successfully');
    }
}
