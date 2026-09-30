<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Media;
use App\Repositories\MediaRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $randomMedia = [
            'media/p-1.jpg',
            'media/p-2.jpg',
            'media/p-3.jpg',
            'media/p-4.jpg',
            'media/p-5.jpg',
            'media/p-6.jpg',
            'media/p-7.jpg',
            'media/p-8.jpg',
            'media/p-9.jpg',
        ];

        // Create Media rows
        $mediaIds = [];

        foreach ($randomMedia as $path) {
            $media = Media::create([
                'original_name' => basename($path),
                'src'           => $path,
                'type'          => 'image/jpeg',
                'extension'     => 'jpg',
            ]);

            $mediaIds[] = $media->id;
        }

        $banner = Banner::create([
            'title'       => 'Buy & Sell Pre-Owned',
            'sub_title'   => 'Products Easily & Safely – All in One Place',
            'description' => 'Looking to sell your unused items or grab a great deal? Our trusted marketplace helps you connect with real people to buy and sell second-hand products — fast, simple, and secure. ',
            'address'     => 'West Shewrapara, Mirpur, Dhaka, Bangladesh',
            'status'      => false,
        ]);

        $banner->thumbnails()->attach($mediaIds);
    }
}
