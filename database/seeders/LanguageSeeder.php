<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Media;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $randomMedia = [
            'bn' => 'media/bn.jpg',
            'cn' => 'media/cn.jpg',
            'us' => 'media/en.jpg',
        ];

        // Create Media rows
        $mediaIds = [];
        foreach ($randomMedia as $key => $path) {
            $media = Media::create([
                'original_name' => basename($path),
                'src'           => $path,
                'type'          => 'image/jpeg',
                'extension'     => 'jpg',
            ]);

            $mediaIds[$key] = $media->id;
        }

        // Create Languages with correct images
        Language::updateOrCreate([
            'name' => 'bn',
        ], [
            'thumbnail_id' => $mediaIds['bn'],
            'title'        => 'Bangla',
            'status'       => 1,
        ]);

        Language::updateOrCreate([
            'name' => 'cn',
        ], [
            'thumbnail_id' => $mediaIds['cn'],
            'title'        => 'Chinese',
            'status'       => 1,
        ]);

        Language::updateOrCreate([
            'name' => 'us',
        ], [
            'thumbnail_id' => $mediaIds['us'],
            'title'        => 'English',
            'status'       => 1,
        ]);
    }
}
