<?php

namespace App\Http\Controllers\Examination;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Examination\MarksGradeRepository;
use App\Http\Requests\Examination\MarksGrade\MarksGradeStoreRequest;
use App\Http\Requests\Examination\MarksGrade\MarksGradeUpdateRequest;

class MarksGradeController extends Controller
{
    private $repo;

    function __construct(MarksGradeRepository $repo)
    {
        $this->repo       = $repo;
    }

    public function index()
    {
        $data['title']              = ___('examination.marks_grade');
        $data['marks_grades'] = $this->repo->getPaginateAll();

        return view('backend.examination.marks-grade.index', compact('data'));

    }

    public function create()
    {
        $data['title']              = ___('examination.marks_grade');
        return view('backend.examination.marks-grade.create', compact('data'));

    }

    public function store(MarksGradeStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('marks-grade.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['marks_grade']        = $this->repo->show($id);
        $data['title']       = ___('examination.marks_grade');
        return view('backend.examination.marks-grade.edit', compact('data'));
    }

    public function update(MarksGradeUpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('marks-grade.index')->with('success', $result['message']);
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
}
