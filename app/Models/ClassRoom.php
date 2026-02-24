<?php

namespace App\Models;

use App\Policies\ClassRoomPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[UsePolicy(ClassRoomPolicy::class)]
class ClassRoom extends Model
{
    /** @use HasFactory<\Database\Factories\CollectionFactory> */
    use HasFactory;

    use HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'is_public',
        'sort_order',
        'prerequisite_classroom_id',
    ];

    protected $table = 'classrooms';

    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class)
            ->withPivot('sort_order')
            ->withTimestamps();
    }

    public function prerequisite(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class, 'prerequisite_classroom_id');
    }

    public function dependents(): HasMany
    {
        return $this->hasMany(ClassRoom::class, 'prerequisite_classroom_id');
    }

    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true);
    }
}
