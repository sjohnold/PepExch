<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserVerify>
 */
class UserVerifyFactory extends Factory
{
    protected $model = UserVerify::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first();

        if (!$user) {
            throw new \Exception('No User');
        }


        $contact = $this->faker->randomElement([$user->email, $user->phone_no]);

        return [
            'user_id' => $user->id,
            'otp' => $this->faker->numberBetween(1000, 9999),
            'contact' => $contact,
        ];
    }
}
