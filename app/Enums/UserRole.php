<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case INSTRUCTOR = 'instructor';
    case STUDENT = 'student';

    /**
     * Get all the values as an array.
     */
    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
