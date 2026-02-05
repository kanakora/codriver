<?php

use App\Models\Collection;
use App\Models\Content;
use App\Models\ContentRevision;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;

test('content revisions can be restored', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $content = Content::factory()->create([
        'author_id' => $admin->id,
    ]);

    $this->actingAs($admin)
        ->put(route('admin.contents.update', $content), [
            'title' => 'Updated title',
            'slug' => $content->slug,
            'description' => $content->description,
            'content_type' => $content->content_type,
            'content_text' => $content->content_text,
            'publish_status' => 'draft',
            'category_ids' => [],
        ])
        ->assertRedirect();

    $revisions = ContentRevision::query()
        ->where('content_id', $content->id)
        ->oldest()
        ->get();

    expect($revisions)->not()->toBeEmpty();

    $original = $revisions->first();

    $this->actingAs($admin)
        ->post(route('admin.contents.revisions.restore', [
            'content' => $content->id,
            'revision' => $original->id,
        ]))
        ->assertRedirect();

    expect($content->fresh()->title)->toBe($original->data['title']);
});

test('scheduled publishing and expiration are processed', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $scheduled = Content::factory()->create([
        'author_id' => $admin->id,
        'publish_status' => 'draft',
        'scheduled_publish_at' => now()->subHour(),
    ]);

    $expired = Content::factory()->published()->create([
        'author_id' => $admin->id,
        'expires_at' => now()->subHour(),
    ]);

    $this->artisan('contents:process-schedule')->assertExitCode(0);

    expect($scheduled->fresh()->publish_status)->toBe('published');
    expect($scheduled->fresh()->published_at)->not()->toBeNull();
    expect($expired->fresh()->archived_at)->not()->toBeNull();
});

test('collections preserve content order', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $contents = Content::factory()->count(3)->create([
        'author_id' => $admin->id,
    ]);

    $payload = [
        'title' => 'Onboarding collection',
        'slug' => 'onboarding-collection',
        'description' => 'A curated onboarding path.',
        'is_public' => true,
        'sort_order' => 1,
        'prerequisite_collection_id' => null,
        'content_ids' => [
            $contents[1]->id,
            $contents[0]->id,
            $contents[2]->id,
        ],
    ];

    $this->actingAs($admin)
        ->post(route('admin.collections.store'), $payload)
        ->assertRedirect();

    $collection = Collection::query()->where('slug', 'onboarding-collection')->firstOrFail();
    $ordering = $collection->contents()->pluck('collection_content.sort_order', 'contents.id');

    expect($ordering[$contents[1]->id])->toBe(1);
    expect($ordering[$contents[0]->id])->toBe(2);
    expect($ordering[$contents[2]->id])->toBe(3);
});
