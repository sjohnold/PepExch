<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerRequest;
use App\Http\Requests\BannerSectionRequest;
use App\Models\Banner;
use App\Repositories\BannerRepository;
use App\Repositories\MediaRepository;
use App\Repositories\PageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banner = BannerRepository::query()->first();
        return view('admin.appearance.banners.create', compact('banner'));
    }


    public function update(BannerSectionRequest $request, $id)
    {
        BannerRepository::updateBanner($request, $id);
        return redirect()->back()->with('success', 'Updated Suceesfully');
    }




    public function removeImage(Request $request)
    {
        $banner  = BannerRepository::query()->findOrFail($request->banner_id);
        $mediaId = $request->media_id;
        $media = MediaRepository::query()->find($mediaId);

        if ($media) {
            // Detach + delete media
            $banner->thumbnails()->detach($mediaId);
            $media->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully'
        ]);
    }
}
