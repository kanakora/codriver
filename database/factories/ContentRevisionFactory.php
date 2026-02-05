<?php

namespace Database\Factories;

use App\Models\Content;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContentRevision>
 */
class ContentRevisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content_id' => Content::factory(),
            'user_id' => User::factory(),
            'data' => [
                'title' => fake()->sentence(4),
                'slug' => fake()->slug(),
                'description' => fake()->sentence(12),
                'content_type' => 'text',
                'content_text' => fake()->paragraphs(2, true),
                'publish_status' => 'draft',
                'published_at' => null,
                'scheduled_publish_at' => null,
                'expires_at' => null,
                'archived_at' => null,
                'category_ids' => [],
            ],
        ];
    }
}
