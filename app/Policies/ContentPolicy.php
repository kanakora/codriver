<?php

namespace App\Policies;

use App\Models\Content;
use App\Models\User;

class ContentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage content') || $user->can('view content');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Content $content): bool
    {
        if ($user->can('manage content')) {
            return true;
        }

        if (! $user->can('view content')) {
            return false;
        }

        if ($content->publish_status !== 'published') {
            return false;
        }

        if ($content->archived_at) {
            return false;
        }

        if ($content->expires_at && $content->expires_at->isPast()) {
            return false;
        }

        if ($content->published_at && $content->published_at->isFuture()) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('manage content');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Content $content): bool
    {
        return $user->can('manage content');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Content $content): bool
    {
        return $user->can('manage content');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Content $content): bool
    {
        return $user->can('manage content');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Content $content): bool
    {
        return $user->can('manage content');
    }

    /**
     * Determine whether the user can publish the content.
     */
    public function publish(User $user, Content $content): bool
    {
        return $user->can('manage content');
    }

    /**
     * Determine whether the user can unpublish the content.
     */
    public function unpublish(User $user, Content $content): bool
    {
        return $user->can('manage content');
    }
}
