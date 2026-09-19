<?php

namespace App\Enums;

use App\Models\Role;


class RoleEnum
{
    const SUPERADMIN = 1;
    const ADMIN = 2;
    const STAFF = 3;
    const ACCOUNTING = 4;
    const TEACHER = 5;
    const STUDENT = 6;
    const GUARDIAN = 7;

    public static function DRIVER()
    {
        return Role::where("slug", "driver")->value('id') ?? null;
    }
}

