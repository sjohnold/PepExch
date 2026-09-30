<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Step 1: Create 5 parent attributes (without parent_id)
        Attribute::factory(5)->create();
        // Step 2: Get the IDs of those parent attributes
        $parentAttributeIds = Attribute::whereNull('parent_id')->pluck('id')->toArray();

        // Step 3: Create random child attributes with parent_id
        for ($i = 0; $i < rand(5, 10); $i++) {
            Attribute::factory(rand(1, 10))->create([
                'parent_id' => fake()->randomElement($parentAttributeIds),
            ]);
        }
    }
}
