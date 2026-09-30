<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorRequest;
use App\Repositories\ColorRepository;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = ColorRepository::getAllOrSearch();
        return view("admin.colors.index", compact("colors"));

    }

    public function create()
    {
        return view("admin.colors.create");
    }
    public function store(ColorRequest $request)
    {
        $data = $request->only(['name', 'code']);
        ColorRepository::StoreData($data);
        return redirect()->route('colors.index')->with('success', 'Color added successfully!');
    }

    public function show($id)
    {
        $color = ColorRepository::find($id);
        return view("admin.colors.show", compact("color"));
    }
    public function edit($id)
    {
        $color = ColorRepository::find($id);
        return view("admin.colors.edit", compact("color"));
    }
    public function update(ColorRequest $request, $id)
    {
        $data = $request->validated();

        $data['id'] = $id;

        $color = ColorRepository::UpdateData($data);

        if (!$color) {
            return redirect()->route('colors.index')->with('error', 'Color not found.');
        }

        return redirect()->route('colors.index')->with('success', 'Color updated successfully!');
    }
    public function destroy($id){
        $color = ColorRepository::find($id);
        if (!$color) {
            return redirect()->route('colors.index')->with('error', 'Color not found.');
        }
        $color->delete();
        return redirect()->route('colors.index')->with('success', 'Color deleted successfully!');
    }
}
