<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        $sections = ['Banner', 'Legal', 'About Us', 'Contact Us'];
        $section = $this->faker->randomElement($sections);
        $data = [];

        if (in_array($section, ['Banner'])) {
            $data[] = [
                'title' => $this->faker->sentence(3),
                'description' => $this->faker->paragraph(2),
                'image' => 'uploads/' . $this->faker->word() . '.jpg',
                'link' => $this->faker->url(),
            ];
        } else {
            $data[] = [
                'title' => $this->faker->sentence(3),
                'description' => $this->faker->paragraph(2),
            ];
        }

        return [
            'section' => $section,
            'data' => $data,
        ];
    }
}
