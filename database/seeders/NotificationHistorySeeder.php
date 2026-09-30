<?php

namespace Database\Seeders;

use App\Models\NotificationHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NotificationHistory::factory()->count(50)->create();
    }
}
