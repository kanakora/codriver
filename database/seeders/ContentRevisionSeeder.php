<?php

namespace Database\Seeders;

use App\Models\ContentRevision;
use Illuminate\Database\Seeder;

class ContentRevisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContentRevision::factory()->count(5)->create();
    }
}
