<?php

namespace Database\Seeders;

use App\Models\BoostPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BoostPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BoostPlan::factory()->count(5)->create();
    }
}
