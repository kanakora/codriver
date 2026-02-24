<?php

namespace App\Policies;

use App\Models\Lesson;
use App\Models\User;

class LessonPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage lessons') || $user->can('view lessons');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Lesson $lesson): bool
    {
        if ($user->can('manage lessons')) {
            return true;
        }

        if (! $user->can('view lessons')) {
            return false;
        }

        if ($lesson->publish_status !== 'published') {
            return false;
        }

        if ($lesson->archived_at) {
            return false;
        }

        if ($lesson->expires_at && $lesson->expires_at->isPast()) {
            return false;
        }

        if ($lesson->published_at && $lesson->published_at->isFuture()) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('manage lessons');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Lesson $lesson): bool
    {
        return $user->can('manage lessons');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Lesson $lesson): bool
    {
        return $user->can('manage lessons');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Lesson $lesson): bool
    {
        return $user->can('manage lessons');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Lesson $lesson): bool
    {
        return $user->can('manage lessons');
    }

    /**
     * Determine whether the user can publish the lesson.
     */
    public function publish(User $user, Lesson $lesson): bool
    {
        return $user->can('manage lessons');
    }

    /**
     * Determine whether the user can unpublish the lesson.
     */
    public function unpublish(User $user, Lesson $lesson): bool
    {
        return $user->can('manage lessons');
    }
}
