<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LessonRevision extends Model
{
    use HasFactory;

    protected $table = 'content_revisions';

    protected $fillable = [
        'lesson_id', // Foreign key to the Lesson
        'user_id',   // ID of the user who made the revision
        'data',      // The actual revision data
    ];

    protected $casts = [
        'data' => 'array', // Assuming the revision data is stored as an array
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
