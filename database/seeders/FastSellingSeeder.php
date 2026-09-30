<?php

namespace Database\Seeders;

use App\Models\FastSelling;
use App\Models\Media;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FastSellingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        FastSelling::create([
            'title' => 'Just Fast Selling',
            'subtitle' => 'No Fees, No Hassles',
            'description' => 'Reach thousands of local buyers instantly. List your old products in seconds...',
            'thumbnail_id' => Media::inRandomOrder()->first()?->id,
        ]);
    }
}
