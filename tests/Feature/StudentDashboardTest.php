<?php

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Inertia\Testing\AssertableInertia as Assert;

test('students can visit the student dashboard', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $student = User::factory()->create();
    $student->assignRole('student');

    $response = $this->actingAs($student)->get(route('student.dashboard'));

    $response
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Student/Dashboard')
            ->has('stats')
            ->has('latestContents')
        );
});

test('admins cannot visit the student dashboard', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $response = $this->actingAs($admin)->get(route('student.dashboard'));

    $response->assertForbidden();
});
