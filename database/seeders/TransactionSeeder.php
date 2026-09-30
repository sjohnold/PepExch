<?php

namespace Database\Seeders;

use App\Models\BoostPlan;
use App\Models\SellingPost;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        Transaction::factory()->count(10)->create();
    }
}
