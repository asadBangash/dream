<?php

namespace App\Http\Controllers\Examination;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\Examination\ExamTypeRepository;
use App\Repositories\Examination\MarksRegisterRepository;
use App\Http\Requests\Examination\MarksRegister\MarksRegisterStoreRequest;
use App\Http\Requests\Examination\MarksRegister\MarksRegisterUpdateRequest;
use App\Models\Examination\ExamAssign;
use App\Models\Examination\MarksRegisterChildren;
use App\Repositories\Academic\ClassesRepository;
use App\Repositories\Academic\SectionRepository;
use App\Repositories\Academic\SubjectRepository;
use App\Repositories\Examination\ExamAssignRepository;
use App\Repositories\StudentInfo\StudentRepository;

class MarksRegisterController extends Controller
{
    private $repo;
    private $classRepo;
    private $classSetupRepo;
    private $sectionRepo;
    private $examTypeRepo;
    private $subjectRepo;
    private $examAssignRepo;
    private $studentRepo;

    function __construct(
        MarksRegisterRepository $repo,
        ClassSetupRepository $classSetupRepo,
        ClassesRepository $classRepo,
        SectionRepository $sectionRepo,
        ExamTypeRepository $examTypeRepo,
        SubjectRepository $subjectRepo,
        ExamAssignRepository $examAssignRepo,
        StudentRepository $studentRepo
    ) {
        $this->repo               = $repo;
        $this->classRepo          = $classRepo;
        $this->classSetupRepo     = $classSetupRepo;
        $this->sectionRepo        = $sectionRepo;
        $this->examTypeRepo       = $examTypeRepo;
        $this->subjectRepo        = $subjectRepo;
        $this->examAssignRepo     = $examAssignRepo;
        $this->studentRepo        = $studentRepo;
    }

    public function index()
    {
        $data['title']              = ___('examination.marks_register');
        $data['classes']            = $this->classRepo->assignedAll();
        $data['marks_registers']    = $this->repo->getPaginateAll();
        return view('backend.examination.marks-register.index', compact('data'));
    }

    public function search(Request $request)
    {
        $data['title']              = ___('examination.marks_register');
        $data['classes']            = $this->classRepo->assignedAll();
        $data['marks_registers']    = $this->repo->searchMarkRegister($request);
        return view('backend.examination.marks-register.index', compact('data'));
    }


    public function show(Request $request)
    {
        $data['marks_register']        = $this->repo->show($request->id);


        $request = new Request([
            'class'     => $data['marks_register']->classes_id,
            'section'   => $data['marks_register']->section_id,
            'exam_type' => $data['marks_register']->exam_type_id,
            'subject'   => $data['marks_register']->subject_id
        ]);

        $data['examAssign']            = $this->examAssignRepo->getExamAssign($request);
        $data['students']              = $this->studentRepo->getStudents($request);


        return view('backend.examination.marks-register.view', compact('data'));
    }

    public function create()
    {
        $data['classes']                = $this->classSetupRepo->all();
        $data['exam_types']             = $this->examAssignRepo->assignedExamType();
        $data['title']                  = ___('examination.marks_register');
        return view('backend.examination.marks-register.create', compact('data'));
    }

    public function store(MarksRegisterStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('marks-register.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['classes']               = $this->classSetupRepo->all();
        $data['sections']              = $this->sectionRepo->all();

        $data['subjects']              = $this->subjectRepo->all();
        $data['marks_register']        = $this->repo->show($id);
        $data['title']                 = ___('examination.marks_register');

        $request = new Request([
            'class'     => $data['marks_register']->classes_id,
            'section'   => $data['marks_register']->section_id,
        ]);
        $data['exam_types']            = $this->examAssignRepo->getExamType($request); // get assigned exam type

        $request = new Request([
            'class'     => $data['marks_register']->classes_id,
            'section'   => $data['marks_register']->section_id,
            'exam_type' => $data['marks_register']->exam_type_id,
            'subject'   => $data['marks_register']->subject_id
        ]);

        $data['examAssign']            = $this->examAssignRepo->getExamAssign($request);
        $data['students']              = $this->studentRepo->getStudents($request);
        return view('backend.examination.marks-register.edit', compact('data'));
    }

    public function update(MarksRegisterUpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if ($result['status']) {
            return redirect()->route('marks-register.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }


    public function updateMarksheetStatus(Request $request, $id)
    {
        $result = $this->repo->updateMarksheetStatus($request, $id);
        if ($result['status']) {
            return response()->json([
                'status' => 'success',
                'message' => $result['message'],
            ], 200);
        }
        return response()->json([
            'status' => 'error',
            'message' => $result['message'],
        ], 500);
    }

    public function delete($id)
    {

        $result = $this->repo->destroy($id);
        if ($result['status']):
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
}
