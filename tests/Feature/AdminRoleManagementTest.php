<?php

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

test('admins can view the role management page', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $response = $this->actingAs($admin)->get(route('admin.roles.index'));

    $response->assertOk();
});

test('students cannot view the role management page', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $student = User::factory()->create();
    $student->assignRole('student');

    $response = $this->actingAs($student)->get(route('admin.roles.index'));

    $response->assertForbidden();
});

test('admins can create roles with permissions', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $permission = Permission::firstWhere('name', 'manage content');

    $response = $this->actingAs($admin)->post(route('admin.roles.store'), [
        'name' => 'editor',
        'permissions' => [$permission->id],
    ]);

    $response->assertRedirect();
    $role = Role::firstWhere('name', 'editor');
    $this->assertDatabaseHas('roles', ['name' => 'editor']);
    $this->assertDatabaseHas('role_has_permissions', [
        'role_id' => $role->id,
        'permission_id' => $permission->id,
    ]);
});
