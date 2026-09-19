<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Gmeet\GmeetRepository;
use App\Http\Requests\Gmeet\GmeetStoreRequest;
use App\Http\Requests\Gmeet\GmeetUpdateRequest;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\Academic\SubjectAssignRepository;

class GmeetController extends Controller
{
    private $repo;
    private $classSetupRepo;
    private $subjectAssign;

    function __construct(GmeetRepository $repo, ClassSetupRepository $classSetupRepo, SubjectAssignRepository $subjectAssign)
    {
        $this->repo               = $repo;
        $this->classSetupRepo     = $classSetupRepo;
        $this->subjectAssign      = $subjectAssign;
    }

    public function index()
    {
        $data['title']              = ___('common.gmeet');
        $data['classes']            = $this->classSetupRepo->all();
        $data['gmeets']             = $this->repo->getPaginateAll();
        return view('backend.gmeet.index', compact('data'));
    }

    public function create()
    {
        $data['title']                  = ___('common.gmeet_create');
        $data['classes']                = $this->classSetupRepo->all();
        return view('backend.gmeet.create', compact('data'));
    }

    public function store(GmeetStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('gmeet.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id, Request $request)
    {
        $data['gmeet']              = $this->repo->show($id);
        $data['classes']            = $this->classSetupRepo->all();
        $data['sections']           = $this->classSetupRepo->getSections($data['gmeet']->classes_id);

        $request->merge(['classes_id' => $data['gmeet']->classes_id]);
        $request->merge(['section_id' => $data['gmeet']->section_id]);

        $data['subjects']           = $this->subjectAssign->getSubjects($request);

        
        $data['title']                 = ___('common.gmeet_edit');
        return view('backend.gmeet.edit', compact('data'));
    }

    public function update(GmeetUpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('gmeet.index')->with('success', $result['message']);
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

    public function search(Request $request)
    {
        $data['title']              = ___('common.gmeet');
        $data['classes']            = $this->classSetupRepo->all();
        $data['gmeets']             = $this->repo->search($request);
        return view('backend.gmeet.index', compact('data'));
    }

}
