<?php

namespace App\Services;

use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;

class ClassSectionNotificationService
{
    public function notifyStudentsInClassSection(
        int $classesId,
        int $sectionId,
        string $title,
        string $message,
        ?string $url = null
    ): int {
        $sessionId = (int) setting('session');
        $count = 0;

        $studentIds = SessionClassStudent::withoutGlobalScopes()
            ->where('session_id', $sessionId)
            ->where('classes_id', $classesId)
            ->where('section_id', $sectionId)
            ->pluck('student_id');

        Student::withoutGlobalScopes()
            ->whereIn('id', $studentIds)
            ->whereNotNull('user_id')
            ->pluck('user_id')
            ->each(function ($userId) use ($title, $message, $url, &$count) {
                send_web_notification($title, $message, (int) $userId, $url);
                $count++;
            });

        return $count;
    }
}
