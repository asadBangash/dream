<?php

namespace App\Http\Controllers\Admin;

use App\Enums\LectureType;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherLectureStoreRequest;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\Academic\SubjectAssignRepository;
use App\Repositories\TeacherLectureRepository;
use Illuminate\Http\Request;

class TeacherLectureController extends Controller
{
    public function __construct(
        private TeacherLectureRepository $repo,
        private ClassSetupRepository $classSetupRepo,
        private SubjectAssignRepository $assignSubjectRepo,
    ) {}

    public function index()
    {
        $data['title'] = 'Lecture Upload';
        $data['lectures'] = $this->repo->getPaginateAll();

        return view('backend.teacher-lecture.index', compact('data'));
    }

    public function create()
    {
        $data['title'] = 'Upload Lecture';
        $data['classes'] = $this->classSetupRepo->all();
        $data['lectureTypes'] = LectureType::labels();

        return view('backend.teacher-lecture.create', compact('data'));
    }

    public function store(TeacherLectureStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('teacher-lecture.index')->with('success', $result['message']);
        }

        return back()->with('danger', $result['message']);
    }

    public function edit($id, Request $request)
    {
        $data['lecture'] = $this->repo->show($id);
        $data['classes'] = $this->classSetupRepo->all();
        $data['sections'] = $this->classSetupRepo->getSections($data['lecture']->classes_id);
        $request->merge([
            'classes_id' => $data['lecture']->classes_id,
            'section_id' => $data['lecture']->section_id,
        ]);
        $data['subjects'] = $this->assignSubjectRepo->getSubjects($request);
        $data['lectureTypes'] = LectureType::labels();
        $data['title'] = 'Edit Lecture';

        return view('backend.teacher-lecture.edit', compact('data'));
    }

    public function update(TeacherLectureStoreRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if ($result['status']) {
            return redirect()->route('teacher-lecture.index')->with('success', $result['message']);
        }

        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        $result = $this->repo->destroy($id);
        if ($result['status']) {
            return response()->json([
                $result['message'], 'success', ___('alert.deleted'), ___('alert.OK'),
            ]);
        }

        return response()->json([
            $result['message'], 'error', ___('alert.oops'), ___('alert.OK'),
        ]);
    }
}
