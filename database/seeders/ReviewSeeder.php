<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Repositories\UserRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = UserRepository::query()->pluck('id');

        $totalReviews = 20;

        for ($i = 0; $i < $totalReviews; $i++) {
            $seller = $userIds->random();

            do {
                $reviewer = $userIds->random();
            } while ($seller == $reviewer);

            Review::factory()->create([
                'seller_id' => $seller,
                'reviewer_id' => $reviewer,
            ]);
        }
    }
}
