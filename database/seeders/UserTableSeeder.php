<?php

namespace Database\Seeders;

use App\Enums\Role as EnumsRole;
use App\Enums\UserStatus;
use App\Models\Media;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => EnumsRole::Admin->value]);

        $rootUser = UserRepository::query()->updateOrCreate([
            'email' => env('ROOT_EMAIL', 'admin@pepexch.example'),
        ], [
            'name' => 'PepExch Admin',
            'password' => Hash::make('secret'),
            'status' => UserStatus::Approve->value,
            'profile_photo_id' => Media::factory()->create()->id,
        ]);

        $rootUser->assignRole($role->name);

        if (env('APP_ENV') == 'local') {
            User::factory()->count(20)->create();
        }
    }
}
