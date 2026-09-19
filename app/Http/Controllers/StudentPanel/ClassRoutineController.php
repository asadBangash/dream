<?php

namespace App\Http\Controllers\StudentPanel;

use App\Http\Controllers\Controller;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use App\Repositories\Report\ClassRoutineRepository as ReportClassRoutineRepository;
use App\Repositories\StudentPanel\ClassRoutineRepository;
use Illuminate\Http\Request;
use PDF;

class ClassRoutineController extends Controller
{
    private $reportClassRoutineRepo;
    private $repo;

    function __construct(ReportClassRoutineRepository $reportClassRoutineRepo, ClassRoutineRepository $repo)
    { 
        $this->reportClassRoutineRepo = $reportClassRoutineRepo; 
        $this->repo = $repo; 
    }

    public function index()
    {
        $data = $this->repo->index();
        return view('student-panel.class-routine', $data);
    }

    public function generatePDF()
    {
        $data   = $this->repo->index();
        $pdf    = PDF::loadView('backend.report.class-routinePDF', $data);

        return $pdf->download('class_routine'.'_'.date('d_m_Y').'.pdf');
    }
}
