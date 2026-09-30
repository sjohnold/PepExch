<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Service;
use App\Repositories\ServiceRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceRepository::query()->updateOrCreate([
            'id' => 1,
        ], [
            'title' => 'Main Service Section',
            'description' => 'This is the main service section. You can add/remove services later.',
            'services' => [
                [
                    'title' => '3500+',
                    'service_title' => 'Web Development',
                    'subtitle' => 'Frontend + Backend',
                    'description' => 'We build responsive web applications.',
                    'thumbnail_id' => Media::inRandomOrder()->first()->id,
                    'status'=> 'active',
                ],
                [
                    'title' => '2500+',
                    'service_title' => 'Mobile App',
                    'subtitle' => 'Android & iOS',
                    'description' => 'Cross-platform high performance apps.',
                    'thumbnail_id' => Media::inRandomOrder()->first()->id,
                    'status'=> 'active',
                ],
                [
                    'title' => '3200+',
                    'service_title' => 'UI/UX Design',
                    'subtitle' => 'Creative Designs',
                    'description' => 'User-friendly and modern UI/UX designs.',
                    'thumbnail_id' => Media::inRandomOrder()->first()->id,
                    'status'=> 'active',
                ],
                [
                    'title' => '5422+',
                    'service_title' => 'Graphics',
                    'subtitle' => 'Creative Designs',
                    'description' => 'User-friendly and modern Graphics designs.',
                    'thumbnail_id' => Media::inRandomOrder()->first()->id,
                    'status'=> 'active',
                ],
            ]
        ]);
    }
}
