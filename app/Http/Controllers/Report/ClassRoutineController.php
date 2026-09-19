<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Academic\ClassesRepository;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\Report\ClassRoutineRepository;
use App\Repositories\StudentInfo\StudentRepository;
use App\Repositories\Examination\ExamAssignRepository;
use App\Http\Requests\Report\ClassRoutine\SearchRequest;
use App\Repositories\Academic\TimeScheduleRepository;
use PDF;

class ClassRoutineController extends Controller
{
    private $repo;
    private $examAssignRepo;
    private $classRepo;
    private $classSetupRepo;
    private $timeScheduleRepo;

    function __construct(
        ClassRoutineRepository    $repo,
        ExamAssignRepository   $examAssignRepo,
        ClassesRepository      $classRepo,
        ClassSetupRepository   $classSetupRepo,
        TimeScheduleRepository      $timeScheduleRepo,
    ) 
    {
        $this->repo               = $repo;
        $this->examAssignRepo     = $examAssignRepo;
        $this->classRepo          = $classRepo;
        $this->classSetupRepo     = $classSetupRepo;
        $this->timeScheduleRepo        = $timeScheduleRepo;
    }

    public function index()
    {
        $data['classes']            = $this->classRepo->assignedAll();
        $data['sections']           = [];
        return view('backend.report.class-routine', compact('data'));
    }

    public function search(SearchRequest $request)
    {
        $data['result']       = $this->repo->search($request);
        $data['time']         = $this->repo->time($request);
        // $data['time']         = $this->timeScheduleRepo->all();
        $data['request']      = $request;
        $data['classes']      = $this->classRepo->assignedAll();
        $data['sections']     = $this->classSetupRepo->getSections($request->class);
        // dd($data['time']);
        return view('backend.report.class-routine', compact('data'));
    }

    public function generatePDF($class, $section)
    {
        $request = new Request([
            'class'        => $class,
            'section'      => $section
        ]);

        $data['result']       = $this->repo->search($request);
        $data['time']         = $this->repo->time($request);
        
        $pdf = PDF::loadView('backend.report.class-routinePDF', compact('data'));
        return $pdf->download('class_routine'.'_'.date('d_m_Y').'.pdf');
    }
}
