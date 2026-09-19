<?php

namespace App\Http\Controllers\StudentInfo;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentInfo\DisabledStudent\DisabledStudentRequest;
use App\Repositories\Academic\ClassesRepository;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\Academic\SectionRepository;
use App\Repositories\StudentInfo\DisabledStudentRepository;
use Illuminate\Http\Request;

class DisabledStudentController extends Controller
{
    private $repo;
    private $classRepo;
    private $sectionRepo;
    private $classSetupRepo;

    function __construct(
        DisabledStudentRepository $repo,
        ClassesRepository         $classRepo, 
        SectionRepository         $sectionRepo,
        ClassSetupRepository      $classSetupRepo
        )
    {
        $this->repo              = $repo; 
        $this->classRepo         = $classRepo; 
        $this->sectionRepo       = $sectionRepo;
        $this->classSetupRepo    = $classSetupRepo;
    }
    
    public function index()
    {
        $data['title']              = ___('student_info.disabled_list');
        $data['classes']            = $this->classRepo->assignedAll();
        $data['sections']           = [];
        $students                   = [];
        $request                    = [];
        return view('backend.student-info.disabled-student.index', compact('data','students','request'));
        
    }

    public function search(DisabledStudentRequest $request)
    {
        
        $data['title']              = ___('student_info.disabled_list');
        $data['classes']            = $this->classRepo->assignedAll();
        $data['sections']           = $this->classSetupRepo->getSections($request->class);
        $students                   = $this->repo->search($request);
        return view('backend.student-info.disabled-student.index', compact('data','students','request'));
    }

    public function store(Request $request)
    {
        $result = $this->repo->store($request);
        if($result['status']){
            $data['title']              = ___('student_info.disabled_list');
            $data['student_categories'] = $this->repo->getPaginateAll();
            $data['classes']            = $this->classRepo->assignedAll();
            $data['sections']           = $this->sectionRepo->all();
            $students                   = $this->repo->search($request);
            return view('backend.student-info.disabled-student.index', compact('data','students','request'));
        }
        return redirect()->route('disabled_students.index')->with('danger', $result['message']);
    }
}
