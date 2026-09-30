<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MediaTableSeeder::class,
            ColorSeeder::class,
            SettingSeeder::class,
            PageSeeder::class,
            RolePermissionSeeder::class,
            PaymentGatewaySeeder::class,
            BannerSeeder::class,
            LanguageSeeder::class,
            ServiceSeeder::class,
        ]);

        if (app()->isLocal()) {
            $this->call([
                UserTableSeeder::class,
                TestimonialSeeder::class,
                FastSellingSeeder::class,
                BoostPlanSeeder::class,
                CategoryTableSeeder::class,
                BrandSeeder::class,
                SellingPostSeeder::class,
                ConversationSeeder::class,
                TransactionSeeder::class,
                NotificationSeeder::class,
                ReviewSeeder::class,
                NotificationHistorySeeder::class,

            ]);
        }
    }
}
