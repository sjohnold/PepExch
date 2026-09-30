<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Notification::class;

    public function definition(): array
    {
        $userIds = User::pluck('id')->toArray();
        return [
            'user_id' => $this->faker->randomElement($userIds),
            'message' => json_encode([
                'title' => $this->faker->randomElement(['New Messgae', 'New Update', 'New Offer']),
                'body' => $this->faker->sentence(5),
                'type' => $this->faker->randomElement(['info', 'success', 'warning']),
            ]),
            'is_read' => $this->faker->randomElement([true, false]),
        ];
    }
}
