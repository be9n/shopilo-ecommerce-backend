<?php

namespace App\Enums;

enum AdminRoleEnum: string
{
    case SUPER_ADMIN = 'super-admin';

    public function title()
    {
        return match ($this) {
            static::SUPER_ADMIN => 'Super Admin',
        };
    }
}
