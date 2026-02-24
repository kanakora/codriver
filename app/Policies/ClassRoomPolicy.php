<?php

namespace App\Policies;

use App\Models\ClassRoom;
use App\Models\User;

class ClassRoomPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage classrooms') || $user->can('view classrooms');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ClassRoom $collection): bool
    {
        if ($user->can('manage classrooms')) {
            return true;
        }

        return $user->can('view classrooms') && $collection->is_public;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('manage classrooms');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ClassRoom $collection): bool
    {
        return $user->can('manage classrooms');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ClassRoom $collection): bool
    {
        return $user->can('manage classrooms');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ClassRoom $collection): bool
    {
        return $user->can('manage classrooms');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ClassRoom $collection): bool
    {
        return $user->can('manage classrooms');
    }
}
