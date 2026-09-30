<?php

namespace App\Http\Controllers;

use App\Models\FastSelling;
use App\Repositories\FastSellingRepository;
use App\Repositories\MediaRepository;
use Illuminate\Http\Request;

class FastSellingController extends Controller
{

    public function index()
    {
        $fastSellings = FastSellingRepository::query()
            ->with('thumbnail')
            ->paginate(10);

        return view('admin.fast_sellings.index', compact('fastSellings'));
    }

    public function edit($id)
    {
        $fastSelling = FastSellingRepository::query()->with('thumbnail')->find($id);

        return view('admin.fast_sellings.edit', compact('fastSelling'));
    }

    public function update(Request $request, $id)
    {


        $fastSelling = FastSelling::findOrFail($id);


        $fastSelling->title = $request->title;
        $fastSelling->subtitle = $request->subtitle;
        $fastSelling->description = $request->description;


        if ($request->hasFile('thumbnail')) {

            $media = MediaRepository::storeByRequest($request->file('thumbnail'), 'fast-selling');

            $fastSelling->thumbnail_id = $media->id;
        }

        $fastSelling->save();


        return redirect()->route('fast-selling.index')->with('success', 'Fast Selling updated successfully.');
    }
}
