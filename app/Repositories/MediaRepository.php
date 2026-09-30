<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MediaRepository extends Repository
{
    public static function model()
    {
        return Media::class;
    }

    public static function storeByRequest($fileInputName, $folderName = 'default')
    {
        $file = $fileInputName;
        $path = Storage::disk('public')->put('/' . trim($folderName, '/'), $file);
        $extension = $file->extension();

        return self::create([
            'original_name' => $file->getClientOriginalName(),
            'src'           => $path,
            'type'          => $file->getClientMimeType(),
            'extension'     => $extension,
            'added_by'      => Auth::id(),
        ]);
    }

    public static function updateByRequest($model, $fileInputName, $folderName = 'default')
    {
        $oldMedia = self::find($model?->thumbnail_id);
        $file = $fileInputName;
        $path = Storage::disk('public')->put('/' . trim($folderName, '/'), $file);
        $extension = $file->extension();

        if ($oldMedia) {
            $oldPath = $oldMedia->src;
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            $oldMedia->original_name = $file->getClientOriginalName();
            $oldMedia->src           = $path;
            $oldMedia->type          = $file->getClientMimeType();
            $oldMedia->extension     = $extension;
            $oldMedia->added_by      = Auth::id();
            $oldMedia->save();

            return $oldMedia;
        }

        return self::create([
            'original_name' => $file->getClientOriginalName(),
            'src'           => $path,
            'type'          => $file->getClientMimeType(),
            'extension'     => $extension,
            'added_by'      => Auth::id(),
        ]);
    }

    public static function deleteIfUnused(?Media $media): bool
    {
        if (!$media || self::isUsed($media->id)) {
            return false;
        }

        if ($media->src && Storage::disk('public')->exists($media->src)) {
            Storage::disk('public')->delete($media->src);
        }

        $media->delete();

        return true;
    }

    public static function isUsed(int $mediaId): bool
    {
        $references = [
            ['banner_thumbnails', 'media_id'],
            ['brands', 'thumbnail_id'],
            ['boost_plans', 'thumbnail_id'],
            ['categories', 'thumbnail_id'],
            ['fast_sellings', 'thumbnail_id'],
            ['languages', 'thumbnail_id'],
            ['message_thumbnails', 'media_id'],
            ['notification_histories', 'media_id'],
            ['payment_gateways', 'media_id'],
            ['post_thumbnails', 'media_id'],
            ['selling_posts', 'media_id'],
            ['testimonials', 'thumbnail_id'],
            ['users', 'profile_photo_id'],
            ['wallets', 'media_id'],
        ];

        foreach ($references as [$table, $column]) {
            if (DB::getSchemaBuilder()->hasTable($table)
                && DB::getSchemaBuilder()->hasColumn($table, $column)
                && DB::table($table)->where($column, $mediaId)->exists()) {
                return true;
            }
        }

        return false;
    }
}
