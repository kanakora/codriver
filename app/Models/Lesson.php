<?php

namespace App\Models;

use App\Policies\LessonPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[UsePolicy(LessonPolicy::class)]
class Lesson extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    public bool $shouldRecordRevision = true;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content_type',
        'file_path',
        'external_url',
        'content_text',
        'publish_status',
        'published_at',
        'scheduled_publish_at',
        'expires_at',
        'archived_at',
        'author_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'scheduled_publish_at' => 'datetime',
        'expires_at' => 'datetime',
        'archived_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saved(function (Lesson $lesson) {
            if (! $lesson->shouldRecordRevision) {
                return;
            }

            if (! $lesson->shouldCreateRevision()) {
                return;
            }

            $lesson->recordRevision();
        });
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(LessonRevision::class);
    }

    public function currentRevision(): BelongsTo
    {
        return $this->belongsTo(ContentRevision::class, 'current_revision_id');
    }

    public function classrooms(): BelongsToMany
    {
        return $this->belongsToMany(ClassRoom::class)
            ->withPivot('sort_order')
            ->withTimestamps();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('publish_status', 'published')
            ->whereNull('archived_at')
            ->where(function (Builder $query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->where(function (Builder $query) {
                $query->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('publish_status', 'draft');
    }

    public function scopeScheduled(Builder $query): Builder
    {
        return $query
            ->where('publish_status', 'draft')
            ->whereNotNull('scheduled_publish_at')
            ->where('scheduled_publish_at', '>', now());
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->published();
    }

    public function scopeExpired(Builder $query): Builder
    {
        return $query->whereNotNull('expires_at')->where('expires_at', '<=', now());
    }

    public function scopeArchived(Builder $query): Builder
    {
        return $query->whereNotNull('archived_at');
    }

    public function recordRevision(): LessonRevision
    {
        $revision = $this->revisions()->create([
            'user_id' => auth('web')->id(),
            'data' => $this->revisionPayload(),
        ]);

        $this->updateQuietly(['current_revision_id' => $revision->id]);

        $this->trimRevisions();

        return $revision;
    }

    public function revisionPayload(): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'content_type' => $this->content_type,
            'file_path' => $this->file_path,
            'external_url' => $this->external_url,
            'content_text' => $this->content_text,
            'publish_status' => $this->publish_status,
            'published_at' => optional($this->published_at)->toISOString(),
            'scheduled_publish_at' => optional($this->scheduled_publish_at)->toISOString(),
            'expires_at' => optional($this->expires_at)->toISOString(),
            'archived_at' => optional($this->archived_at)->toISOString(),
            'category_ids' => $this->categories()->pluck('categories.id')->all(),
        ];
    }

    public function shouldCreateRevision(): bool
    {
        if ($this->wasRecentlyCreated) {
            return true;
        }

        return $this->wasChanged([
            'title',
            'slug',
            'description',
            'content_type',
            'file_path',
            'external_url',
            'content_text',
            'publish_status',
            'published_at',
            'scheduled_publish_at',
            'expires_at',
            'archived_at',
        ]);
    }

    protected function trimRevisions(): void
    {
        $limit = config('content.revisions.limit');

        if (! $limit) {
            return;
        }

        $excess = $this->revisions()
            ->latest()
            ->pluck('id')
            ->slice($limit);

        if ($excess->isNotEmpty()) {
            ContentRevision::query()->whereIn('id', $excess->values())->delete();
        }
    }
}
