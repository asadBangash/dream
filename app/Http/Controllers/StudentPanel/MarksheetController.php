<?php

namespace App\Http\Controllers\StudentPanel;

use App\Models\MarkSheetApproval;
use GPBMetadata\Google\Api\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use App\Repositories\Examination\ExamAssignRepository;
use App\Repositories\Report\MarksheetRepository as ReportMarksheetRepository;
use App\Repositories\StudentInfo\StudentRepository;
use App\Repositories\StudentPanel\MarksheetRepository;
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
        StudentRepository $studentRepo
    )
    {
        $this->repo = $repo;
        $this->typeRepo = $typeRepo;
        $this->reportMarksheetRepo = $reportMarksheetRepo;
        $this->studentRepo = $studentRepo;
    }

    public function index()
    {
        $data['exam_types']   = $this->typeRepo->getExamType($this->repo->index());
        return view('student-panel.marksheet', compact('data'));
    }

    public function search(Request $request)
    {
        $student = Student::where('user_id', \auth()->user()->id)->first();

        $markSheetApproval = MarkSheetApproval::where('exam_type_id', $request->exam_type)
            ->where('student_id', $student->id)
            ->first();

        if (!$markSheetApproval || $markSheetApproval->status == 'rejected'){
            return redirect()->back()->with('danger', 'Marksheet is not generate yet');
        }

        $data                   = $this->repo->search($request);
        $data['exam_types']     = $this->typeRepo->assignedExamType();
        $data['request']        = $request;

        return view('student-panel.marksheet', compact('data','request'));
    }

    public function generatePDF($type)
    {
        $student        = Student::where('id', request()->filled('student_id') ? request('student_id') : @auth()->user()->student->id)->first();
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
