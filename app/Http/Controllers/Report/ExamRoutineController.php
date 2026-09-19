<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Academic\ClassesRepository;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\Report\ExamRoutineRepository;
use App\Repositories\StudentInfo\StudentRepository;
use App\Repositories\Examination\ExamAssignRepository;
use App\Http\Requests\Report\ExamRoutine\SearchRequest;
use App\Repositories\Academic\TimeScheduleRepository;
use App\Repositories\Examination\ExamTypeRepository;
use PDF;

class ExamRoutineController extends Controller
{
    private $repo;
    private $examAssignRepo;
    private $classRepo;
    private $classSetupRepo;
    private $timeScheduleRepo;
    private $typeRepo;

    function __construct(
        ExamRoutineRepository  $repo,
        ExamAssignRepository   $examAssignRepo,
        ClassesRepository      $classRepo,
        ClassSetupRepository   $classSetupRepo,
        TimeScheduleRepository $timeScheduleRepo,
        ExamTypeRepository     $typeRepo,
    ) 
    {
        $this->repo               = $repo;
        $this->examAssignRepo     = $examAssignRepo;
        $this->classRepo          = $classRepo;
        $this->classSetupRepo     = $classSetupRepo;
        $this->timeScheduleRepo   = $timeScheduleRepo;
        $this->typeRepo           = $typeRepo;
    }

    public function index()
    {
        $data['classes']            = $this->classRepo->assignedAll();
        $data['sections']           = [];
        $data['types']              = $this->typeRepo->all();
        return view('backend.report.exam-routine', compact('data'));
    }

    public function search(SearchRequest $request)
    {
        $data['result']       = $this->repo->search($request);
        $data['time']         = $this->repo->time($request);
        $data['request']      = $request;
        $data['classes']      = $this->classRepo->assignedAll();
        $data['sections']     = $this->classSetupRepo->getSections($request->class);
        $data['types']        = $this->typeRepo->all();
        // dd($data);
        return view('backend.report.exam-routine', compact('data'));
    }

    public function generatePDF($class, $section, $type)
    {
        $request = new Request([
            'class'        => $class,
            'section'      => $section,
            'type'         => $type,
        ]);

        $data['result']       = $this->repo->search($request);
        $data['time']         = $this->repo->time($request);
        
        $pdf = PDF::loadView('backend.report.exam-routinePDF', compact('data'));
        return $pdf->download('exam_routine'.'_'.date('d_m_Y').'.pdf');
    }
}
