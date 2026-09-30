<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $media = Media::factory()->count(5)->create();
        Testimonial::factory(10)->create();
    }
}
