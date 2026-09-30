<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use App\Models\Media;
use App\Services\SettingsService;
use Illuminate\Support\Facades\File;
use Request;


class LanguageRepository extends Repository
{
    public static function model()
    {
        return Language::class;
    }


    public static function store($request)
    {
        $thumbnailId = null;
        if ($request->hasFile('thumbnail')) {
            $media = MediaRepository::storeByRequest($request->file('thumbnail'), 'thumbnails');
            $thumbnailId = $media->id;
        }

        $isActive = $request->has('status') == 1 ? true : false;

        $language = self::create([
            'title' => $request->title,
            'thumbnail_id' => $thumbnailId,
            'name' => $request->name,
            'status' => $isActive,
        ]);

        $jsonFilePath = base_path('lang/' . $request->name . '.json');

        if (File::exists($jsonFilePath)) {
            return redirect()->back()->with('error', 'File already exists for language: ' . $request->name);
        }

        $jsonData = [
            'title' => $request->title,
            'name' => $request->name,
            'status' => $request->status ?? 0,
            'welcome' => 'Welcome to ' . $request->title,
        ];

        $langDir = base_path('lang');
        if (!File::exists($langDir)) {
            File::makeDirectory($langDir, 0755, true);
        }

        $jsonContent = json_encode($jsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($jsonContent === false) {
            return redirect()->back()->with('error', 'Failed to create JSON file for language: ' . $request->name);
        }
        File::put($jsonFilePath, $jsonContent);
        return $language;
    }


    public static function updateLanguage(LanguageRequest $request, $id)
    {
        $language = self::findOrFail($id);
        $oldName = $language->name;

        $language->title  = $request->title;
        $language->name   = $request->name;
        $language->status = $request->status;

        if ($request->hasFile('thumbnail')) {
            $oldThumbnail = $language->thumbnail;
            $media = MediaRepository::storeByRequest($request->file('thumbnail'), 'thumbnails');
            $language->thumbnail_id = $media->id;
            $language->save();
            MediaRepository::deleteIfUnused($oldThumbnail);
        }

        // JSON file rename if name changed
        if ($oldName !== $request->name) {
            $oldJsonFilePath = base_path('lang/' . $oldName . '.json');
            if (File::exists($oldJsonFilePath)) {
                File::delete($oldJsonFilePath);
            }
        }

        // Read existing translations and only update meta fields
        $jsonFilePath  = base_path('lang/' . $request->name . '.json');
        $existingData  = [];
        if (File::exists($jsonFilePath)) {
            $existingData = json_decode(File::get($jsonFilePath), true) ?? [];
        }

        $existingData['title']  = $request->title;
        $existingData['name']   = $request->name;
        $existingData['status'] = $request->status;

        File::put($jsonFilePath, json_encode($existingData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $language->save();
        SettingsService::clearCache();

        return $language->fresh();
    }


    public static function deleteLanguage($id)
    {
        $language = self::findOrFail($id);
        $thumbnail = $language->thumbnail;

        $jsonFilePath = base_path('lang/' . $language->name . '.json');
        if (File::exists($jsonFilePath)) {
            File::delete($jsonFilePath);
        }

        $language->delete();
        MediaRepository::deleteIfUnused($thumbnail);
        SettingsService::clearCache();

        return true;
    }
}
