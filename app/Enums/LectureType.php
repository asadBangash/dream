<?php

namespace App\Enums;

class LectureType
{
    const PDF = 'pdf';

    const VIDEO = 'video';

    const LECTURE = 'lecture';

    public static function labels(): array
    {
        return [
            self::PDF     => 'PDF Notes',
            self::VIDEO   => 'Video',
            self::LECTURE => 'Lecture Material',
        ];
    }
}
