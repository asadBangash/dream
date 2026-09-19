<?php

namespace Database\Seeders\Demo;

use App\Models\Attendance\Attendance;
use App\Models\StudentInfo\SessionClassStudent;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DemoAttendanceSeeder extends Seeder
{
    public static int $attendanceCount = 0;

    public function run(): void
    {
        $sessionId = (int) setting('session');
        $dates = collect(range(0, 29))->map(fn ($i) => Carbon::now()->subDays($i)->format('Y-m-d'));

        foreach (DemoContext::branches() as $branchId => $branchName) {
            $enrollments = SessionClassStudent::withoutGlobalScopes()
                ->where('branch_id', $branchId)
                ->where('session_id', $sessionId)
                ->with('student:id,roll_no')
                ->get();

            foreach ($enrollments as $enrollment) {
                foreach ($dates as $date) {
                    if (Carbon::parse($date)->isWeekend()) {
                        continue;
                    }

                    Attendance::create([
                        'session_id' => $sessionId,
                        'student_id' => $enrollment->student_id,
                        'classes_id' => $enrollment->classes_id,
                        'section_id' => $enrollment->section_id,
                        'roll'       => $enrollment->student->roll_no ?? $enrollment->roll,
                        'date'       => $date,
                        'attendance' => [1, 1, 1, 0, 2][rand(0, 4)],
                        'branch_id'  => $branchId,
                    ]);
                    self::$attendanceCount++;
                }
            }
        }
    }
}
