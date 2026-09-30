<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
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
            'media/m-1.jpg',
            'media/m-2.jpg',
        ];
        return [
            'original_name' => fake()->word() . '.' . fake()->fileExtension(),
            'src' =>  $randomMedia[array_rand($randomMedia)],
            'type' => "application/image",
            'extension' => "jpg",
            'added_by' => null
        ];
    }
}
