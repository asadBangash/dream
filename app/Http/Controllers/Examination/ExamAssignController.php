<?php

namespace App\Http\Controllers\Examination;

use Illuminate\Http\Request;
use App\Models\Academic\Section;
use App\Models\Academic\Subject;
use App\Http\Controllers\Controller;
use App\Models\Examination\ExamType;
use App\Models\Academic\SubjectAssign;
use App\Models\Academic\SubjectAssignChildren;
use App\Repositories\Academic\SectionRepository;
use App\Repositories\Academic\SubjectRepository;
use App\Interfaces\Academic\SubjectAssignInterface;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\Examination\ExamTypeRepository;
use App\Repositories\Examination\ExamAssignRepository;
use App\Http\Requests\Examination\Assign\ExamAssignStoreRequest;
use App\Http\Requests\Examination\Assign\ExamAssignUpdateRequest;
use App\Repositories\Academic\ClassesRepository;

class ExamAssignController extends Controller
{
    private $repo;
    private $classRepo;
    private $sectionRepo;
    private $subjectRepo;
    private $examTypeRepo;
    private $classSetupRepo;

    function __construct(
        ExamAssignRepository $repo, 
        ClassesRepository $classRepo, 
        SectionRepository $sectionRepo, 
        SubjectRepository $subjectRepo, 
        ExamTypeRepository $examTypeRepo,
        ClassSetupRepository $classSetupRepo,
        SubjectAssignInterface $subjectAssignRepo,
        )
    {
        $this->repo               = $repo; 
        $this->classRepo          = $classRepo; 
        $this->sectionRepo        = $sectionRepo; 
        $this->subjectRepo        = $subjectRepo; 
        $this->examTypeRepo       = $examTypeRepo; 
        $this->classSetupRepo     = $classSetupRepo; 
    }
    
    public function index()
    {
        $data['title']        = ___('examination.exam_assign');
        $data['classes']      = $this->classRepo->assignedAll();
        $data['exam_assigns'] = $this->repo->getPaginateAll();
        // dd($data);

        return view('backend.examination.exam-assign.index', compact('data'));
        
    }

    public function search(Request $request)
    {
        $data['title']        = ___('examination.exam_assign');
        $data['exam_assigns'] = $this->repo->searchExamAssign($request);
        $data['subjectArr']   = Subject::pluck('name','id')->toArray();
        $data['sectionArr']   = Section::pluck('name','id')->toArray();
        $data['examArr']      = ExamType::pluck('name','id')->toArray();
        $data['classes']      = $this->classRepo->assignedAll();

        return view('backend.examination.exam-assign.index', compact('data'));
        
    }

    public function create()
    {
        $data['title']                  = ___('examination.exam_assign');
        $data['classes']                = $this->classSetupRepo->all();
        $data['exam_types']             = $this->examTypeRepo->all();
        return view('backend.examination.exam-assign.create', compact('data'));
        
    }

    public function marksDistribution(Request $request)
    {
        // $subjectArr   = Subject::pluck('name','id')->toArray();
        return view('backend.examination.exam-assign.marks_distribute', compact('request'))->render();
    }

    public function subjectMarksDistribution(Request $request)
    {
        // return $request->all();
        $subjectArr   = Subject::pluck('name','id')->toArray();
        return view('backend.examination.exam-assign.subject_marks_distribute', compact('subjectArr', 'request'))->render();
    }

    public function store(ExamAssignStoreRequest $request)
    {
        // dd($request->all());
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('exam-assign.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $result = $this->repo->show($id);
        if(!$result)
            return redirect()->route('exam-assign.index')->with('danger', 'You cannot edit this! because, already marks registred.');

        $data['exam_assign']        = $result;
        $data['title']              = ___('examination.exam_assign');
        $data['classes']            = $this->classRepo->all();
        $data['sections']           = $this->classSetupRepo->getSections($data['exam_assign']->classes_id);
 

        $result                   = SubjectAssign::active()->where('session_id', setting('session'))->where('classes_id', $data['exam_assign']->classes_id)->where('section_id', $data['exam_assign']->section_id)->first();
        $data['subjects']         = SubjectAssignChildren::with('subject')->where('subject_assign_id', @$result->id)->select('subject_id')->get();

        $data['exam_types']         = $this->examTypeRepo->all();
        
        return view('backend.examination.exam-assign.edit', compact('data'));
    }

    public function update(ExamAssignUpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('exam-assign.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function checkMarkRegister($id)
    {
        $result = $this->repo->checkMarkRegister($id);
        return response()->json($result, 200);
    }
    
    public function delete($id)
    {
        
        $result = $this->repo->destroy($id);
        if($result['status']):
            $success[0] = $result['message'];
            $success[1] = 'success';
            $success[2] = ___('alert.deleted');
            $success[3] = ___('alert.OK');
            return response()->json($success);
        else:
            $success[0] = $result['message'];
            $success[1] = 'error';
            $success[2] = ___('alert.oops');
            return response()->json($success);
        endif;      
    }

    public function getSections(Request $request)
    {
        $data = $this->classSetupRepo->getSections($request->id);

        return response()->json($data);
    }

    public function getSubjects(Request $request)
    {
        $result = $this->repo->getSubjects($request);
        return response()->json($result, 200);
    }

    public function getExamType(Request $request)
    {
        $result = $this->repo->getExamType($request);
        return response()->json($result, 200);
    }

    public function checkSubmit(Request $request)
    {
        $result = $this->repo->checkSubmit($request);
        return response()->json($result, 200);
    }
}
