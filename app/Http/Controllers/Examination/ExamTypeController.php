<?php

namespace App\Http\Controllers\Examination;

use App\Http\Controllers\Controller;
use App\Http\Requests\Examination\Type\ExamTypeStoreRequest;
use App\Http\Requests\Examination\Type\ExamTypeUpdateRequest;
use App\Interfaces\Examination\ExamTypeInterface;
use Illuminate\Http\Request;

class ExamTypeController extends Controller
{
    private $repo;

    function __construct(ExamTypeInterface $repo)
    {
        $this->repo       = $repo; 
    }
    
    public function index()
    {
        $data['title']              = ___('examination.exam_type');
        $data['exam_types'] = $this->repo->getPaginateAll();

        return view('backend.online-examination.type.index', compact('data'));
        
    }

    public function create()
    {
        $data['title']              = ___('examination.exam_type');
        return view('backend.online-examination.type.create', compact('data'));
        
    }

    public function store(ExamTypeStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('online-exam-type.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['exam_type']        = $this->repo->show($id);
        $data['title']       = ___('examination.exam_type');
        return view('backend.online-examination.type.edit', compact('data'));
    }

    public function update(ExamTypeUpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('online-exam-type.index')->with('success', $result['message']);
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
