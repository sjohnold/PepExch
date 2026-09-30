<?php

namespace Database\Factories;

use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NotificationHistory>
 */
class NotificationHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'receiver_id' => null,
            'sender_id'   => UserRepository::query()->inRandomOrder()->value('id'),
            'subject'     => $this->faker->word(),
            'body'        => $this->faker->sentence(1),
            'is_read'     => false,
        ];
    }
}
