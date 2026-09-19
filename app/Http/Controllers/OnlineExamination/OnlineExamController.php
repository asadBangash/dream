<?php

namespace App\Http\Controllers\OnlineExamination;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\GenderRepository;
use Illuminate\Support\Facades\Schema;
use App\Repositories\Academic\ClassesRepository;
use App\Repositories\Academic\SectionRepository;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\Examination\ExamTypeRepository;
use App\Interfaces\OnlineExamination\OnlineExamInterface;
use App\Repositories\StudentInfo\StudentCategoryRepository;
use App\Interfaces\OnlineExamination\QuestionGroupInterface;
use App\Http\Requests\OnlineExamination\OnlineExam\StoreRequest;
use App\Http\Requests\OnlineExamination\OnlineExam\UpdateRequest;
use App\Repositories\Academic\SubjectAssignRepository;
use App\Repositories\StudentInfo\StudentRepository;
use PDF;

class OnlineExamController extends Controller
{
    private $repo;
    private $groupRepo;
    private $genderRepo;
    private $categoryRepo;
    private $classRepo;
    private $sectionRepo;
    private $typeRepo;
    private $classSetupRepo;
    private $subjectAssingRepo;
    private $studentRepo;

    function __construct(
        OnlineExamInterface $repo,
        QuestionGroupInterface $groupRepo,
        GenderRepository $genderRepo,
        StudentCategoryRepository $categoryRepo,
        ClassesRepository $classRepo,
        SectionRepository $sectionRepo,
        ExamTypeRepository $typeRepo,
        ClassSetupRepository $classSetupRepo,
        SubjectAssignRepository $subjectAssingRepo,
        StudentRepository $studentRepo
    )
    {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        } 
        $this->repo              = $repo; 
        $this->groupRepo         = $groupRepo;
        $this->genderRepo        = $genderRepo;
        $this->categoryRepo      = $categoryRepo;
        $this->classRepo         = $classRepo;
        $this->sectionRepo       = $sectionRepo;
        $this->typeRepo          = $typeRepo;
        $this->classSetupRepo    = $classSetupRepo;
        $this->subjectAssingRepo = $subjectAssingRepo;
        $this->studentRepo       = $studentRepo;
    }

    public function index()
    {
        $data['online_exam'] = $this->repo->getAll();
        $data['title']       = ___('online-examination.online_exam');
        $data['classes']     = $this->classRepo->assignedAll();
        $data['sections']    = [];
        $data['subjects']    = [];
        return view('backend.online-examination.online-exam.index', compact('data'));
    }
    
    public function search(Request $request)
    {
        $data['classes']     = $this->classRepo->assignedAll();
        $data['sections']    = $this->classSetupRepo->getSections($request->class);
        
        $searchRequest = new Request([
            'classes_id' => $request->class,
            'section_id' => $request->section,
        ]);
        $data['subjects']         = $this->subjectAssingRepo->getSubjects($searchRequest);

        $data['request']     = $request;
        $data['title']       = ___('online-examination.online_exam');
        $data['online_exam'] = $this->repo->search($request);
        return view('backend.online-examination.online-exam.index', compact('data'));
    }

    public function create()
    {
        $data['title']            = ___('online-examination.create_online_exam');
        $data['classes']          = $this->classRepo->assignedAll();
        $data['sections']         = [];
        $data['subjects']         = [];
        $data['question_groups']  = $this->groupRepo->all();
        $data['genders']          = $this->genderRepo->all();
        $data['categories']       = $this->categoryRepo->all();
        $data['types']            = $this->typeRepo->all();

        return view('backend.online-examination.online-exam.create', compact('data'));
    }

    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('online-exam.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['online_exam']      = $this->repo->show($id);

        $data['classes']          = $this->classRepo->assignedAll();
        $data['sections']         = $this->classSetupRepo->getSections($data['online_exam']->classes_id);
        $data['question_groups']  = $this->groupRepo->all();
        $data['genders']          = $this->genderRepo->all();
        $data['categories']       = $this->categoryRepo->all();
        $data['types']            = $this->typeRepo->all();
        
        $request = new Request([
            'classes_id' => $data['online_exam']->classes_id,
            'section_id' => $data['online_exam']->section_id,
        ]);
        $data['subjects']         = $this->subjectAssingRepo->getSubjects($request);

        $data['questions']    = $this->repo->getAllQuestions($data['online_exam']->question_group_id);

        $request = new Request();
        $request->replace(['class' => $data['online_exam']->classes_id, 'section' => $data['online_exam']->section_id]);
        $data['students']     = $this->studentRepo->getStudents($request);
        
        $data['title']            = ___('online-examination.edit_online_exam');
        return view('backend.online-examination.online-exam.edit', compact('data'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('online-exam.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
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

    public function getAllQuestions(Request $request)
    {
        $items = $this->repo->getAllQuestions($request->id);
        return view('backend.online-examination.online-exam.questions', compact('items'))->render();
    }

    public function viewStudents(Request $request)
    {
        $data = $this->repo->show($request->id);
        return view('backend.online-examination.online-exam.view_students', compact('data'));
    }

    public function viewQuestions(Request $request)
    {
        $data = $this->repo->show($request->id);
        return view('backend.online-examination.online-exam.view_questions', compact('data'));
    }
    public function answer($id, $student_id)
    {
        $data['exam']    = $this->repo->show($id);
        $data['answer']  = $this->repo->answer($id, $student_id);
        $data['title']   = ___('online-examination.Exam Answer');
        return view('backend.online-examination.online-exam.answer', compact('data','student_id'));
    }

    public function markSubmit(Request $request)
    {
        $result  = $this->repo->markSubmit($request);
        if($result['status']){
            return back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    function questionDownload($id){
        $data = $this->repo->show($id);
        $pdf = PDF::loadView('backend.online-examination.online-exam.download_questions', compact('data'));
        return $pdf->download('marksheet'.'_'.date('d_m_Y').'.pdf');
    }
    
}
