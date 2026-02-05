<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentRevision extends Model
{
    /** @use HasFactory<\Database\Factories\ContentRevisionFactory> */
    use HasFactory;

    protected $fillable = [
        'content_id',
        'user_id',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
