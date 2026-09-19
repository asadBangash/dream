<?php

namespace App\Http\Controllers\ParentPanel;

use App\Http\Controllers\Controller;
use App\Models\MarkSheetApproval;
use Illuminate\Http\Request;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use App\Repositories\Report\ExamRoutineRepository;
use App\Repositories\ParentPanel\MarksheetRepository;
use App\Repositories\Report\MarksheetRepository as ReportMarksheetRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Examination\ExamAssignRepository;
use App\Repositories\StudentInfo\StudentRepository;
use Illuminate\Support\Facades\Session;
use PDF;

class MarksheetController extends Controller
{
    private $repo;
    private $typeRepo;
    private $reportMarksheetRepo;
    private $studentRepo;

    function __construct(
        MarksheetRepository $repo,
        ExamAssignRepository $typeRepo,
        ReportMarksheetRepository $reportMarksheetRepo,
        StudentRepository $studentRepo,
    )
    {
        $this->repo = $repo;
        $this->typeRepo = $typeRepo;
        $this->reportMarksheetRepo = $reportMarksheetRepo;
        $this->studentRepo = $studentRepo;
    }

    public function getExamTypes(Request $request)
    {
        return $this->typeRepo->getExamType($this->repo->studentInfo($request->id)); // student id
    }

    public function index()
    {
        $data                 = $this->repo->index();
        return view('parent-panel.marksheet', compact('data'));
    }

    public function search(Request $request)
    {

        $markSheetApproval = MarkSheetApproval::where('exam_type_id', $request->exam_type)
            ->where('student_id', $request->student)
            ->first();

        if (!$markSheetApproval || $markSheetApproval->status == 'rejected'){
            return redirect()->back()->with('danger', 'Marksheet is not generate yet');
        }

        $data               = $this->repo->search($request);
        $data['request']    = $request;
        return view('parent-panel.marksheet', compact('data','request'));
    }

    public function generatePDF($student, $type)
    {
        $student        = Student::where('id', $student)->first();
        $classSection   = SessionClassStudent::where('session_id', setting('session'))
                        ->where('student_id', @$student->id)
                        ->first();

        $request = new Request([
            'student'   => @$student->id,
            'exam_type' => $type,
            'class'     => $classSection->classes_id,
            'section'   => $classSection->section_id,
        ]);

        $data['student']      = $this->studentRepo->show(@$student->id);
        $data['resultData']   = $this->reportMarksheetRepo->search($request);

        $pdf = PDF::loadView('backend.report.marksheetPDF', compact('data'));
        return $pdf->download('marksheet'.'_'.date('d_m_Y').'_'.@$data['student']->first_name .'_'. @$data['student']->last_name .'.pdf');
    }
}
