<?php

namespace Database\Seeders;

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
        // Seed roles and permissions
        $this->call(RolesAndPermissionsSeeder::class);

        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole('admin');

        // Create student user
        $student = User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@example.com',
        ]);
        $student->assignRole('student');

        // Create additional test users
        User::factory(8)->create();
    }
}