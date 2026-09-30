<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Load permission array from config/acl.php
        $permissionGroups = config('acl');

        foreach ($permissionGroups as $permissionGroup) {
            foreach ($permissionGroup['permissions'] as $permission) {

                // Create permission if not exists
                $newPermission = Permission::firstOrCreate([
                    'name' => $permission['permission'],
                ]);

                // Attach permission to roles
                if (isset($permission['role']) && is_array($permission['role'])) {
                    foreach ($permission['role'] as $roleName) {
                        $role = Role::firstOrCreate(['name' => $roleName]);
                        $role->givePermissionTo($newPermission); // pass Permission model object
                    }
                }
            }
        }
        Role::firstOrCreate(['name' => "User"]);
        $this->command->info('Roles & Permissions seeded successfully!');
    }
}
