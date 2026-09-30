<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class ConversationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Conversation::class;
    public function definition(): array
    {
        return [
            'receiver_id' => User::factory(),
            'sender_id' => User::factory(),
        ];
    }
}
