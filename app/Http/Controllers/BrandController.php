<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Repositories\BrandRepository;
use Illuminate\Http\Request;


class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = BrandRepository::getPaginatedBrands($request);
        return view('admin.brand.index', compact('brands'));

    }

    public function show($id)
    {
        $brand = BrandRepository::findWithThumbnail($id);
        return view('admin.brand.show', compact('brand'));
    }

    public function create()
    {
        return view('admin.brand.create');
    }

    public function store(BrandRequest $request)
    {
        BrandRepository::storeBrand($request);
        return redirect()->route('brand.index')->with('success', 'Brand created successfully!');
    }

    public function edit($id)
    {
        $brand = BrandRepository::query()->with('thumbnail')->findOrFail($id);
        return view('admin.brand.edit', compact('brand'));
    }

    public function update(BrandRequest $request, $id)
    {
        BrandRepository::updateBrand($request, $id);
        return redirect()->route('brand.index')->with('success', 'Brand updated successfully!');
    }

    public function destroy($id)
    {
        BrandRepository::deleteBrand($id);
        return redirect()->route('brand.index')->with('success', 'Brand deleted successfully!');
    }
}
