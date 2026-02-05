<?php

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Inertia\Testing\AssertableInertia as Assert;

test('admins can visit the admin dashboard', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Admin/Dashboard')
            ->has('stats')
            ->has('recentContents')
        );
});

test('students cannot visit the admin dashboard', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $student = User::factory()->create();
    $student->assignRole('student');

    $response = $this->actingAs($student)->get(route('admin.dashboard'));

    $response->assertForbidden();
});
