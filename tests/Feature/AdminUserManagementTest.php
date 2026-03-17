<?php

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Spatie\Permission\Models\Role;

test('admins can view the user management page', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $response = $this->actingAs($admin)->get(route('admin.users.index'));

    $response->assertOk();
});

test('students cannot view the user management page', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $student = User::factory()->create();
    $student->assignRole('student');

    $response = $this->actingAs($student)->get(route('admin.users.index'));

    $response->assertForbidden();
});

test('admins can update user roles', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $target = User::factory()->create();
    $role = Role::firstWhere('name', 'student');

    $response = $this->actingAs($admin)->put(
        route('admin.users.update', $target),
        ['roles' => [$role->id]],
    );

    $response->assertRedirect();
    expect($target->refresh()->hasRole('student'))->toBeTrue();
});

test('admins can create new users', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $studentRole = Role::firstWhere('name', 'student');

    $response = $this->actingAs($admin)->post(route('admin.users.store'), [
        'name' => 'New User',
        'email' => 'newuser@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'roles' => [$studentRole->id],
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('users', [
        'name' => 'New User',
        'email' => 'newuser@example.com',
    ]);

    $user = User::where('email', 'newuser@example.com')->first();
    expect($user)->not->toBeNull()
        ->and($user->hasRole('student'))->toBeTrue();
});
