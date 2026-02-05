<?php

use App\Models\Content;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;

test('students can view published content', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $student = User::factory()->create();
    $student->assignRole('student');

    $author = User::factory()->create();

    $publishedContent = Content::create([
        'title' => 'Published content',
        'slug' => 'published-content',
        'description' => 'Published content description',
        'content_type' => 'text',
        'content_text' => 'Hello world',
        'publish_status' => 'published',
        'published_at' => now(),
        'author_id' => $author->id,
    ]);

    $response = $this->actingAs($student)->get(
        route('student.contents.show', $publishedContent),
    );

    $response->assertOk();
});

test('students cannot view draft content', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $student = User::factory()->create();
    $student->assignRole('student');

    $author = User::factory()->create();

    $draftContent = Content::create([
        'title' => 'Draft content',
        'slug' => 'draft-content',
        'description' => 'Draft content description',
        'content_type' => 'text',
        'content_text' => 'Draft text',
        'publish_status' => 'draft',
        'published_at' => null,
        'author_id' => $author->id,
    ]);

    $response = $this->actingAs($student)->get(
        route('student.contents.show', $draftContent),
    );

    $response->assertForbidden();
});
