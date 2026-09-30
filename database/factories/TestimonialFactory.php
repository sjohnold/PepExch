<?php

namespace Database\Factories;

use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'designation' => $this->faker->jobTitle(),
            'rating' => $this->faker->numberBetween(1, 5),
            'description' => $this->faker->paragraph(),
            'thumbnail_id' => Media::inRandomOrder()->first()?->id,
            'status' => $this->faker->boolean(90),
        ];
    }
}
