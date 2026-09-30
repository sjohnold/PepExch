<?php

namespace Database\Factories;

use App\Models\BoostPlan;
use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;


class BoostPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = BoostPlan::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word() . ' Plan',
            'payable_amount' => fake()->randomFloat(2, 10, 500),
            'discount_amount' => fake()->randomFloat(2, 0, 50),
            'plan_items' => json_encode(['item1' => 'value1', 'item2' => 'value2']),
            'sustain_days' => fake()->numberBetween(1, 30),
            'thumbnail_id' => Media::factory(),
        ];
    }
}
