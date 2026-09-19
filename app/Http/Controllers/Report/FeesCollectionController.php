<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Report\FeesCollectionRequest;
use App\Repositories\Academic\ClassesRepository;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\StudentInfo\StudentRepository;
use App\Repositories\Examination\ExamAssignRepository;
use App\Repositories\Report\FeesCollectionRepository;
use App\Repositories\Report\MeritListRepository;
use Illuminate\Support\Facades\Crypt;
use PDF;

class FeesCollectionController extends Controller
{
    private $repo;
    private $examAssignRepo;
    private $classRepo;
    private $classSetupRepo;
    private $studentRepo;

    function __construct(
        FeesCollectionRepository    $repo,
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
        return view('backend.report.fees-collection', compact('data'));
    }

    public function search(FeesCollectionRequest $request)
    {
        $data['result']       = $this->repo->search($request);
        $data['request']      = $request;
        $data['classes']      = $this->classRepo->assignedAll();
        $data['sections']     = $this->classSetupRepo->getSections($request->class);
        return view('backend.report.fees-collection', compact('data'));
    }
    
    public function generatePDF($class, $section, $dates)
    {
        $request = new Request([
            'class'        => $class,
            'section'      => $section,
            'dates'        => Crypt::decryptString($dates),
        ]);

        $data['result']       = $this->repo->searchPDF($request);
        
        $pdf = PDF::loadView('backend.report.fees-collectionPDF', compact('data'));
        return $pdf->download('fees_collection'.'_'.date('d_m_Y').'.pdf');
    }
}
