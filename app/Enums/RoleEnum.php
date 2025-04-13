<?php

namespace App\Enums;

enum RoleEnum: string
{
    case SUPER_ADMIN = 'super-admin';
    case MANAGER = 'manager';

    public function title()
    {
        return match ($this) {
            static::SUPER_ADMIN => 'Super Admin',
            static::MANAGER => 'Manager',
        };
    }
}
