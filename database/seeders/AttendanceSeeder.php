<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Attendance\Attendance;
use App\Models\StudentInfo\SessionClassStudent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $firstDayOfYear         = Carbon::now()->startOfYear();
        $lastDayOfYear          = Carbon::now()->endOfYear();
        $datesForYear           = Carbon::parse($firstDayOfYear)->daysUntil($lastDayOfYear);
        $datesArray             = collect($datesForYear)->map(function ($date) {
                                    return $date->format('Y-m-d');
                                });
                            
        $sessionClassStudents   = SessionClassStudent::query()
                                ->with('student:id,roll_no')
                                ->whereHas('session', function ($q) {
                                    $q->whereYear('start_date', '<=', date('Y'))
                                    ->whereYear('end_date', '>=', date('Y'));
                                })
                                ->take(2)
                                ->get(['session_id', 'student_id', 'classes_id', 'section_id']);


        foreach($sessionClassStudents ?? [] as $sessionClassStudent) {
            foreach($datesArray ?? [] as $date) {
                Attendance::firstOrCreate([
                    'session_id'    => $sessionClassStudent->session_id,
                    'student_id'    => $sessionClassStudent->student_id,
                    'classes_id'    => $sessionClassStudent->classes_id,
                    'section_id'    => $sessionClassStudent->section_id,
                    'roll'          => $sessionClassStudent->student->roll_no,
                    'date'          => $date,
                ], [
                    'attendance'    => rand(0, 4),
                ]);
            }
        }
    }
}
