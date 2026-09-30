<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserResetSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Delete all users (disabling FK checks for clean reset)
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::query()->forceDelete();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Create Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@pepexch.test',
            'password' => Hash::make('secret'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('Admin');

        // 3. Create regular user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@pepexch.test',
            'password' => Hash::make('secret'),
            'email_verified_at' => now(),
        ]);
        $user->assignRole('User');

        echo "Users reset successfully!\n";
        echo "Admin: admin@pepexch.test / secret\n";
        echo "User: user@pepexch.test / secret\n";
    }
}
