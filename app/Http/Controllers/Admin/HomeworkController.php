<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\StudentInfo\SessionClassStudent;
use App\Repositories\Academic\ClassesRepository;
use App\Repositories\Academic\SectionRepository;
use App\Repositories\Academic\SubjectRepository;
use App\Repositories\Homework\HomeworkRepository;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\Academic\SubjectAssignRepository;
use App\Http\Requests\Examination\Homework\HomeworkStoreRequest;
use App\Http\Requests\Examination\Homework\HomeworkUpdateRequest;

class HomeworkController extends Controller
{
    private $repo;
    private $classRepo;
    private $classSetupRepo;
    private $sectionRepo;
    private $subjectRepo;
    private $assignSubjectRepo;

    function __construct(
        HomeworkRepository $repo,
        ClassSetupRepository $classSetupRepo,
        ClassesRepository $classRepo,
        SectionRepository $sectionRepo,
        SubjectRepository $subjectRepo,
        SubjectAssignRepository $assignSubjectRepo,
        )
    {
        $this->repo               = $repo;
        $this->classRepo          = $classRepo;
        $this->classSetupRepo     = $classSetupRepo;
        $this->sectionRepo        = $sectionRepo;
        $this->subjectRepo        = $subjectRepo;
        $this->assignSubjectRepo        = $assignSubjectRepo;
    }

    public function index()
    {
        $data['title']              = ___('examination.homework');
        $data['classes']            = $this->classRepo->assignedAll();
        $data['homeworks']    = $this->repo->getPaginateAll();
        return view('backend.homework.index', compact('data'));
    }

    public function search(Request $request)
    {
        $data['title']              = ___('examination.homework');
        $data['classes']            = $this->classRepo->assignedAll();
        $data['homeworks']    = $this->repo->search($request);
        return view('backend.homework.index', compact('data'));
    }


    public function show(Request $request)
    {
        $data['homework']        = $this->repo->show($request->id);

        $request = new Request([
            'class'     => $data['homework']->classes_id,
            'section'   => $data['homework']->section_id,
            'exam_type' => $data['homework']->exam_type_id,
            'subject'   => $data['homework']->subject_id
        ]);

        return view('backend.homework.view', compact('data'));
    }

    public function create()
    {
        $data['classes']                = $this->classSetupRepo->all();
        $data['title']                  = ___('examination.homework');
        return view('backend.homework.create', compact('data'));
    }

    public function store(HomeworkStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('homework.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id, Request $request)
    {
        $data['homework']              = $this->repo->show($id);
        $data['classes']               = $this->classSetupRepo->all();
        $data['sections']              = $this->classSetupRepo->getSections($data['homework']->classes_id);

        $request->merge([
            'classes_id' => $data['homework']->classes_id,
            'section_id' => $data['homework']->section_id
        ]);

        $data['subjects']              = $this->assignSubjectRepo->getSubjects($request);


        $data['title']                 = ___('examination.homework');
        return view('backend.homework.edit', compact('data'));
    }

    public function update(HomeworkUpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('homework.index')->with('success', $result['message']);
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

    public function students(Request $request)
    {
        $data['homework']   = $this->repo->show($request->homework_id);
        $data['students']   = SessionClassStudent::with(['homeworkStudent' => function ($query) use ($data) {
                                                        $query->where('homework_id', $data['homework']->id);
                                                    }])
                                                    ->where('session_id', setting('session'))
                                                    ->where('classes_id', $data['homework']->classes_id)
                                                    ->where('section_id', $data['homework']->section_id)
                                                    ->get();

        $data['view'] = view('backend.homework.evaluation', compact('data'))->render();
        return response()->json($data);


    }

    public function evaluationSubmit(Request $request)
    {
        $result = $this->repo->evaluationSubmit($request);
        if($result['status']){
            return redirect()->route('homework.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }


}
