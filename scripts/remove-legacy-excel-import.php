<?php

/**
 * Remove first-pass imports (excel-combined-{n}) kept when row-based codes were added.
 * Keeps excel-combined-row-* and manual students (no code).
 */

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use App\Models\User;
use Illuminate\Support\Facades\DB;

$legacy = Student::query()
    ->withoutGlobalScopes()
    ->whereNotNull('student_code')
    ->where('student_code', 'regexp', '^excel-combined-[0-9]+$')
    ->get();

if ($legacy->isEmpty()) {
    echo "No legacy excel-combined-N records to remove.\n";
    exit(0);
}

echo 'Removing ' . $legacy->count() . " legacy duplicate import rows...\n";

DB::transaction(function () use ($legacy) {
    foreach ($legacy as $student) {
        SessionClassStudent::query()->where('student_id', $student->id)->delete();
        $userId = $student->user_id;
        $student->delete();
        if ($userId) {
            User::query()->where('id', $userId)->delete();
        }
    }
});

echo "Done. Remaining students: " . Student::query()->withoutGlobalScopes()->count() . "\n";
