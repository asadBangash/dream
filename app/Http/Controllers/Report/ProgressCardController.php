<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Academic\ClassesRepository;
use App\Repositories\Report\MarksheetRepository;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\StudentInfo\StudentRepository;
use App\Http\Requests\Report\ProgressCard\SearchRequest;
use App\Repositories\Examination\ExamAssignRepository;
use App\Repositories\Report\ProgressCardRepository;
use PDF;

class ProgressCardController extends Controller
{
    private $repo;
    private $examAssignRepo;
    private $classRepo;
    private $classSetupRepo;
    private $studentRepo;

    function __construct(
        ProgressCardRepository    $repo,
        ExamAssignRepository   $examAssignRepo,
        ClassesRepository      $classRepo,
        ClassSetupRepository   $classSetupRepo,
        StudentRepository      $studentRepo,
    ) 
    {
        $this->repo               = $repo;
        $this->examAssignRepo     = $examAssignRepo;
        $this->classRepo          = $classRepo;
        $this->classSetupRepo     = $classSetupRepo;
        $this->studentRepo        = $studentRepo;
    }

    public function index()
    {
        $data['classes']            = $this->classRepo->assignedAll();
        $data['sections']           = [];
        $data['students']           = [];
        return view('backend.report.progress-card', compact('data'));
    }

    public function getStudents(Request $request){
        return $this->studentRepo->getStudents($request);
    }

    public function search(SearchRequest $request)
    {
        $data                 = $this->repo->search($request);
        $data['student']      = $this->studentRepo->show($request->student);
        $data['exam_types']   = $this->examAssignRepo->assignedExamType();
        $data['request']      = $request;
        $data['classes']      = $this->classRepo->assignedAll();
        $data['sections']     = $this->classSetupRepo->getSections($request->class);
        $data['students']     = $this->studentRepo->getStudents($request);
        
        // dd($data);
        return view('backend.report.progress-card', compact('data'));
    }
    
    public function generatePDF($class, $section, $student)
    {
        $request = new Request([
            'class'     => $class,
            'section'   => $section,
            'student'   => $student,
        ]);

        $data                 = $this->repo->search($request);
        $data['student']      = $this->studentRepo->show($request->student);
        
        $pdf = PDF::loadView('backend.report.progress-cardPDF', compact('data'));
        return $pdf->download('progress_card'.'_'.date('d_m_Y').'_'.@$data['student']->first_name .'_'. @$data['student']->last_name .'.pdf');
    }
}
