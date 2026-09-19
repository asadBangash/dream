<?php

namespace App\Http\Controllers\ParentPanel;

use App\Http\Controllers\Controller;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use App\Repositories\ParentPanel\ClassRoutineRepository;
use App\Repositories\Report\ClassRoutineRepository as ReportClassRoutineRepository;
use Illuminate\Http\Request;
use PDF;

class ClassRoutineController extends Controller
{
    private $reportClassRoutineRepo;
    private $repo;

    function __construct(ReportClassRoutineRepository $reportClassRoutineRepo, ClassRoutineRepository $repo) 
    {
        $this->reportClassRoutineRepo = $reportClassRoutineRepo; 
        $this->repo               = $repo;
    }

    public function index()
    {
        $data = $this->repo->index();
        return view('parent-panel.class-routine', compact('data'));
    }

    public function search(Request $request)
    {
        $data = $this->repo->search($request);
        $data['request'] = $request;

        return view('parent-panel.class-routine', compact('data'));
    }

    public function generatePDF($student)
    {
        $student        = Student::where('id', $student)->first();
        $classSection   = SessionClassStudent::where('session_id', setting('session'))
                        ->where('student_id', @$student->id)
                        ->first();

        $request = new Request([
            'class'        => $classSection->classes_id,
            'section'      => $classSection->section_id
        ]);

        $data['result']       = $this->reportClassRoutineRepo->search($request);
        $data['time']         = $this->reportClassRoutineRepo->time($request);
        
        $pdf = PDF::loadView('backend.report.class-routinePDF', compact('data'));
        return $pdf->download('class_routine'.'_'.date('d_m_Y').'.pdf');
    }
}
