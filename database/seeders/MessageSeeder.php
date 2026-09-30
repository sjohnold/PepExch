<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Repositories\MediaRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medias = MediaRepository::query()->pluck('id')->toArray();

        for ($i = 0; $i < rand(50, 100); $i++) {
            $message = Message::factory()->create();

            if (fake()->boolean(50)) {
                $mediaIds = fake()->randomElements($medias, rand(1, 5));
                $message->thumbnails()->attach($mediaIds);
            }
        }
    }
}
