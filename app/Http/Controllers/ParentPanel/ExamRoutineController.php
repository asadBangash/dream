<?php

namespace App\Http\Controllers\ParentPanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use App\Repositories\StudentInfo\StudentRepository;
use App\Repositories\Examination\ExamAssignRepository;
use App\Repositories\ParentPanel\ExamRoutineRepository;
use App\Repositories\Report\ExamRoutineRepository as ReportExamRoutineRepository;
use PDF;

class ExamRoutineController extends Controller
{
    private $reportExamRoutineRepo;
    private $repo;
    private $typeRepo;

    function __construct( ReportExamRoutineRepository $reportExamRoutineRepo, ExamRoutineRepository $repo, ExamAssignRepository $typeRepo) 
    { 
        $this->reportExamRoutineRepo = $reportExamRoutineRepo; 
        $this->repo = $repo; 
        $this->typeRepo = $typeRepo;
    }

    public function getExamTypes(Request $request)
    {
        return $this->typeRepo->getExamType($this->repo->studentInfo($request->id)); // student id
    }


    public function index()
    {
        $data = $this->repo->index();
        return view('parent-panel.exam-routine', compact('data'));
    }

    public function search(Request $request)
    {
        $data = $this->repo->search($request);
        $data['request'] = $request;
        return view('parent-panel.exam-routine', compact('data','request'));
    }

    public function generatePDF($student, $type)
    {
        $student        = Student::where('id', $student)->first();
        $classSection   = SessionClassStudent::where('session_id', setting('session'))
                        ->where('student_id', @$student->id)
                        ->first();

        $request = new Request([
            'class'        => $classSection->classes_id,
            'section'      => $classSection->section_id,
            'type'         => $type,
        ]);

        $data['result']       = $this->reportExamRoutineRepo->search($request);
        $data['time']         = $this->reportExamRoutineRepo->time($request);
        
        $pdf = PDF::loadView('backend.report.exam-routinePDF', compact('data'));
        return $pdf->download('exam_routine'.'_'.date('d_m_Y').'.pdf');
    }
}
