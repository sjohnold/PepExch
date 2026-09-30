<?php

namespace Database\Factories;

use App\Models\BoostPlan;
use App\Models\PaymentGateway;
use App\Models\SellingPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sellingPostIds = SellingPost::pluck('id')->toArray();
        $boostPlanIds = BoostPlan::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();
        $paymentGatewayIds = PaymentGateway::pluck('id')->toArray();

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'selling_post_id' => $this->faker->randomElement($sellingPostIds),
            'boost_plan_id' => $this->faker->randomElement($boostPlanIds),
            'payment_method_id' => $this->faker->randomElement($paymentGatewayIds),

            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'contact' => $this->faker->phoneNumber(),

            'auto_pay' => $this->faker->boolean(),
            'is_paid' => $this->faker->boolean(),
            'paid_at' => $this->faker->optional()->dateTimeThisYear(),

            'identifier' => strtoupper(Str::random(12)),
            'amount' => $this->faker->randomFloat(2, 10, 500),

            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
