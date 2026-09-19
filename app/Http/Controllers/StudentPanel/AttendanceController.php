<?php

namespace App\Http\Controllers\StudentPanel;

use App\Enums\AttendanceType;
use Illuminate\Http\Request;
use App\Models\StudentInfo\Student;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance\Attendance;
use App\Models\StudentInfo\SessionClassStudent;
use App\Repositories\StudentPanel\AttendanceRepository;

class AttendanceController extends Controller
{
    private $repo;

    function __construct(AttendanceRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $data['title']              = ___('common.Attendance');
        $data['results']            = [];
        return view('student-panel.attendance', compact('data'));
    }

    public function search(Request $request)
    {
        $data['title']        = ___('common.Attendance');
        $data['request']      = $request;
        $results              = $this->repo->search($request);
        $data['results']      = $results['results'];
        $data['days']         = $results['days'];



        // dd($data['results']);
        return view('student-panel.attendance', compact('data'));
    }



    public function attendance(Request $request){
        try {
            $student        = Student::where('user_id', Auth::user()->id)->first();
            $classSection   = SessionClassStudent::where('session_id', setting('session'))->where('student_id', $student->id)->latest()->first();

            $row = Attendance::where('session_id', setting('session'))->where('student_id', $student->id)->where('date', date('Y-m-d'))->first();
            if ($row){
                return response()->json([
                    'status' => 'success',
                    'data' =>[],
                    'message' => 'Already submitted'
                ], 200);
            }
            else{
                $row = new Attendance();
                $row->session_id                = $classSection->session_id;
                $row->classes_id                = $classSection->classes_id;
                $row->section_id                = $classSection->section_id;
                $row->student_id                = $classSection->student_id;
                $row->roll                      = $classSection->roll;
                $row->note                      = $request->message;
                $row->date                      = date('Y-m-d');
                $row->attendance                = AttendanceType::PRESENT;
                $row->save();

                return response()->json([
                    'status' => 'success',
                    'data' =>[],
                    'message' => 'Attendance successfully submitted'
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'data' =>[],
                'message' => 'Something went wrong'
            ], 500);
        }

    }
}
