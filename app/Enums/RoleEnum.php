<?php

namespace App\Enums;

enum RoleEnum: string
{
    case Admin = 'admin';
    case User = 'user';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'role');
    }
}



