<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Collection extends Model
{
    /** @use HasFactory<\Database\Factories\CollectionFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'is_public',
        'sort_order',
        'prerequisite_collection_id',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function contents(): BelongsToMany
    {
        return $this->belongsToMany(Content::class)
            ->withPivot('sort_order')
            ->withTimestamps()
            ->orderBy('collection_content.sort_order');
    }

    public function prerequisite(): BelongsTo
    {
        return $this->belongsTo(Collection::class, 'prerequisite_collection_id');
    }

    public function dependents(): HasMany
    {
        return $this->hasMany(Collection::class, 'prerequisite_collection_id');
    }

    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true);
    }
}
