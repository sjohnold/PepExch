<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use Illuminate\Support\Facades\Storage;
use App\Models\Banner;

class BannerRepository extends Repository
{
    public static function model()
    {
        return Banner::class;
    }


    public static function updateBanner($request, $id)
    {
        $banner = self::query()->findOrFail($id);

        // Update banner fields
        $banner->update([
            'title'       => $request->title,
            'sub_title'   => $request->sub_title,
            'address'     => $request->address,
            'description' => $request->description,
            'status'      => true,
        ]);

        // Remove images if any
        if ($request->filled('removed_images')) {
            $removedIds = array_filter(explode(',', $request->removed_images));

            foreach ($removedIds as $mediaId) {
                $media = MediaRepository::find($mediaId);

                if ($media) {
                    // Detach from banner pivot & delete media
                    $banner->thumbnails()->detach($mediaId);
                    $media->delete();
                }
            }
        }

        // Handle new uploaded images
        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $file) {
                $media = MediaRepository::updateByRequest(null, $file, 'banners');
                // Attach to banner
                $banner->thumbnails()->attach($media->id);
            }
        }

        return $banner;
    }
}
