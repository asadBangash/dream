<?php

namespace App\Repositories\StudentPanel;

use Illuminate\Http\Request;
use App\Models\StudentInfo\Student;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance\Attendance;
use App\Models\StudentInfo\SessionClassStudent;
use App\Interfaces\StudentPanel\AttendanceInterface;

class AttendanceRepository implements AttendanceInterface
{
    public function search($request)
    {
        try {
            $student        = Student::where('user_id', Auth::user()->id)->first();
            $classSection   = SessionClassStudent::where('session_id', setting('session'))->where('student_id', $student->id)->latest()->first();

            $result = Attendance::query();
            $result = $result->where('session_id', setting('session'))
            ->where('classes_id', $classSection->classes_id)
            ->where('section_id', $classSection->section_id)
            ->where('student_id', $student->id);
            if($request->month != "") {
                $result = $result->where('date', 'LIKE', $request->month.'%');
            }
            if($request->date != "") {
                $result = $result->where('date', $request->date);
            }

            $year = 0;
            $month = 0;
            if ($request->month != "") {
                $abc = explode('-', $request->month);
                $year = $abc[0];
                $month = $abc[1];
            }


            if ($request->date != "") {
                $abc   = explode('-', $request->date);
                $year  = $abc[0];
                $month = $abc[1];
            }

            $data = [];
            $data['days'] = getAllDaysInMonth($year, $month);


            if($request->view == 0) {
                $data['results'] = $result->get();
            }
            else{
                $data['results'] = $result->paginate(10);
            }

            return $data;

        } catch (\Throwable $th) {
            return false;
        }
    }
}
