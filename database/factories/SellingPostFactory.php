<?php

namespace Database\Factories;

use App\Enums\PostStatus;
use App\Models\Brand;
use App\Models\User;
use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SellingPost>
 */
class SellingPostFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $isSold = $this->faker->boolean;
        $soldPrice = $isSold ? $this->faker->randomFloat(2, 1000, 50000) : null;

        return [
            'name'           => $this->faker->sentence(3),
            'conditions'     => $this->faker->randomElement(['Brand New', 'Used Like New']),
            'asking_price'   => $this->faker->randomFloat(2, 1000, 50000),
            'sold_price'     => $soldPrice,
            'contact_number' => $this->faker->phoneNumber(),
            'email'          => $this->faker->safeEmail(),
            'description'    => $this->faker->paragraph(),
            'latitude'       => $this->faker->latitude(),
            'longitude'      => $this->faker->longitude(),
            'warranty_left'  => rand(100, 999),
            'model'          => $this->faker->word(),
            'color_code'     => $this->faker->hexColor(),
            'number_of_view' => rand(100, 999),
            'status'         => $this->faker->randomElement(PostStatus::cases())->value,
            'is_sold'        => false,
            'is_negotiable'  => false,
            'media_id'        => Media::inRandomOrder()->value('id') ?? Media::factory(),
            'user_id'        => User::inRandomOrder()->value('id') ?? User::factory(),
            'brand_id'       => Brand::inRandomOrder()->value('id') ?? Brand::factory(),
        ];
    }

    /**
     * Attach thumbnails automatically after creating a SellingPost
     */
    public function configure()
    {
        return $this->afterCreating(function ($post) {

            $media = Media::inRandomOrder()->first();

            if (!$media) {

                $media = Media::factory()->create();
            }


            $mediaIds = Media::inRandomOrder()
                ->limit(rand(1, 4))
                ->pluck('id')
                ->toArray();

            if (empty($mediaIds)) {
                $mediaIds = [$media->id];
            }

            $post->thumbnails()->attach(array_shift($mediaIds), ['default' => true]);

            foreach ($mediaIds as $id) {
                $post->thumbnails()->attach($id, ['default' => false]);
            }
        });
    }
}
