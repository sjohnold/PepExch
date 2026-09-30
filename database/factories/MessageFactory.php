<?php

namespace Database\Factories;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\SellingPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Message::class;
    public function definition(): array
    {
        return [
            'contact' => fake()->sentence(),
             'selling_post_id' => SellingPost::factory(),
            'conversation_id' => Conversation::factory(),
            'receiver_id' =>  User::factory(),
            'is_read' => fake()->boolean(),
        ];
    }
}
