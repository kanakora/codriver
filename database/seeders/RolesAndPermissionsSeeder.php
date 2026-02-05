<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage content',
            'manage categories',
            'manage collections',
            'view content',
            'view collections',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo([
            'manage content',
            'manage categories',
            'manage collections',
            'view content',
            'view collections',
        ]);

        $studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
        $studentRole->givePermissionTo(['view content', 'view collections']);
    }
}
