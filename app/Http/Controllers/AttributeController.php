<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttributeRequest;
use App\Repositories\AttributeRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = AttributeRepository::getAllOrSearch();
        return view('admin.attributes.index', compact('attributes'));
    }
    public function create()
    {
        $categories = CategoryRepository::getAll();
        $attributes = AttributeRepository::getAll();
        return view('admin.attributes.create', compact('categories', 'attributes'));
    }
    public function store(AttributeRequest $request)
    {
        AttributeRepository::StoreData($request->validated());
        return redirect()->route('attributes.index')->with('success', 'Attribute created successfully!');
    }
    public function show($id)
    {
        $attribute = AttributeRepository::find($id);
        return view('admin.attributes.show', compact('attribute'));
    }
    public function edit($id)
    {
        $attribute = AttributeRepository::findOrFail($id);
        $categories = CategoryRepository::getAll();
        $attributes = AttributeRepository::getAllExcept($id); // prevent self-parent

        return view('admin.attributes.edit', compact('attribute', 'categories', 'attributes'));
    }

    public function update(AttributeRequest $request, $id)
    {
        $attribute = AttributeRepository::findOrFail($id);
        $attribute->update($request->validated());

        return redirect()->route('attributes.index')->with('success', 'Attribute updated successfully!');
    }

    public function destroy($id)
    {
        $attribute = AttributeRepository::findOrFail($id);
        $attribute->delete();

        return redirect()->route('attributes.index')->with('success', 'Attribute deleted successfully!');
    }
}
