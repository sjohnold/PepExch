<?php

namespace Database\Factories;


use App\Enums\Seting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Settings>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(Seting::cases())->value,
            'data' => json_encode([
                'value' => $this->faker->sentence(),
            ]),
        ];
    }
}
