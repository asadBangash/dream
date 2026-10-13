<?php

namespace App\Enums;

class TalentTestApplicationStatus
{
    public const PENDING = 0;

    public const REVIEWED = 1;

    public const APPROVED = 2;

    public const REJECTED = 3;

    public static function labels(): array
    {
        return [
            self::PENDING => 'Pending',
            self::REVIEWED => 'Reviewed',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
        ];
    }

    public static function label(int $status): string
    {
        return self::labels()[$status] ?? 'Pending';
    }
}
