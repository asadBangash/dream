<?php

namespace App\Enums;

class IdCardType
{
    public const STUDENT = 'student';

    public const TEACHER = 'teacher';

    public static function values(): array
    {
        return [self::STUDENT, self::TEACHER];
    }

    public static function label(string $type): string
    {
        return match ($type) {
            self::TEACHER => ___('common.teacher'),
            default => ___('common.student'),
        };
    }
}
