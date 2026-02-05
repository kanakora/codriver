<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content>
 */
class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('###'),
            'description' => fake()->sentence(12),
            'content_type' => 'text',
            'file_path' => null,
            'external_url' => null,
            'content_text' => fake()->paragraphs(3, true),
            'publish_status' => 'draft',
            'published_at' => null,
            'author_id' => User::factory(),
        ];
    }

    public function published(): static
    {
        return $this->state([
            'publish_status' => 'published',
            'published_at' => now(),
        ]);
    }
}
