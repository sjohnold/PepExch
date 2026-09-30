<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Media;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mediaIds = Media::pluck('id')->toArray();
        /**
         * -------------------------------------------
         * 1. Real Main Categories (Fixed)
         * -------------------------------------------
         */
        $mainCategories = [
            'Electronics',
            'Fashion',
            'Home & Furniture',
            'Beauty & Health',
            'Sports & Outdoors',
        ];

        // Create Parent Categories
        $parents = collect();
        foreach ($mainCategories as $name) {
            $parents->push(
                Category::create([
                    'name' => $name,
                    'parent_id' => null,
                    'thumbnail_id' => !empty($mediaIds) ? collect($mediaIds)->random() : null,
                ])
            );
        }

        /**
         * -------------------------------------------
         * 2. Create Real Subcategories (Fixed)
         * -------------------------------------------
         * You can increase/decrease easily.
         */
        $subCategories = [
            'Electronics' => ['Mobiles', 'Laptops', 'Cameras'],
            'Fashion' => ['Men Clothing', 'Women Clothing', 'Accessories'],
            'Home & Furniture' => ['Furniture', 'Kitchen', 'Decor'],
            'Beauty & Health' => ['Skincare', 'Makeup', 'Supplements'],
            'Sports & Outdoors' => ['Gym Equipment', 'Outdoor Gear', 'Sportswear'],
        ];

        foreach ($parents as $parent) {
            $name = $parent->name;

            if (isset($subCategories[$name])) {
                foreach ($subCategories[$name] as $childName) {
                    Category::create([
                        'name' => $childName,
                        'parent_id' => $parent->id,
                        'thumbnail_id' => !empty($mediaIds) ? collect($mediaIds)->random() : null,
                    ]);
                }
            }
        }
    }
}
