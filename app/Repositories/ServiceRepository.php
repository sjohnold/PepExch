<?php

namespace App\Repositories;

use Abedin\Maker\Repositories\Repository;
use App\Models\Media;
use App\Models\Service;
use Illuminate\Http\UploadedFile;

class ServiceRepository extends Repository
{
    public static function model()
    {
        return Service::class;
    }

    public static function getAllOrSearch($perPage = 15)
    {
        $searchKey = request('search');
        $query = self::query();
        if ($searchKey) {
            $query->where('name', 'like', "%{$searchKey}%");
        }
        return $query->latest('id')->paginate($perPage);
    }

    public static function storeData($request)
    {
        $servicesData = [];

        foreach ($request->services as $key => $service) {
            $thumbnailId = null;
            if (isset($service['thumbnail_id']) && $service['thumbnail_id'] instanceof UploadedFile) {
                $path = $service['thumbnail_id']->store('services', 'public');
                $media = MediaRepository::storeByRequest($request->file('thumbnail'), 'thumbnails');
                $thumbnailId = $media->id;
            }

            $servicesData[$key] = [
                'thumbnail_id' => $thumbnailId,
                'title' => $service['title'],
                'service_title' => $service['service_title'], 
                'subtitle' => $service['subtitle'] ?? null,
                'description' => $service['description'] ?? null,
            ];
        }

        // Main Service
        $serviceMain = self::create([
            'title' => $request['title'],
            'description' => $request['description'] ?? null,
            'services' => $servicesData,
        ]);
        return $serviceMain;
    }


    public static function updateData($request, $id)
    {
        // Find the main service
        $serviceMain = self::find($id);
        if (!$serviceMain) {
            return null;
        }

        $servicesData = [];
        if (!empty($request['services']) && is_array($request['services'])) {
            foreach ($request['services'] as $key => $service) {

                // Use old_thumbnail_id if no new file is uploaded
                $thumbnailId = $service['old_thumbnail_id'] ?? ($serviceMain->services[$key]['thumbnail_id'] ?? null);

                // Handle new thumbnail upload
                if (isset($service['thumbnail_id']) && $service['thumbnail_id'] instanceof UploadedFile) {
                    $path = $service['thumbnail_id']->store('services', 'public');

                    // Create or update media record
                    $media = MediaRepository::create([
                        'original_name' => $service['thumbnail_id']->getClientOriginalName(),
                        'src' => $path
                    ]);
                    $media = MediaRepository::updateByRequest($serviceMain, $service['thumbnail_id'], 'thumbnails');
                    $thumbnailId = $media->id;
                }

                $servicesData[$key] = [
                    'thumbnail_id' => $thumbnailId,
                    'title' => $service['title'] ?? null,
                    'service_title' => $service['service_title'] ?? null,
                    'subtitle' => $service['subtitle'] ?? null,
                    'description' => $service['description'] ?? null,
                    'status' => $service['status'] ?? 'inactive', // <-- added status
                ];
            }
        }

        // Update main service fields
        $serviceMain->title = $request['title'] ?? $serviceMain->title;
        $serviceMain->description = $request['description'] ?? $serviceMain->description;
        $serviceMain->services = $servicesData;

        $serviceMain->save();

        return $serviceMain;
    }


    public static function getMainService()
    {
        return self::query()->first();
    }

    public static function getLimitedServices($limit = 4)
    {
        $mainService = self::getMainService();
        return collect($mainService?->services ?? [])->take($limit);
    }
}
