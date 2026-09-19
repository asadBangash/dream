<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\IdCard\IdCardRepository;
use App\Http\Requests\IdCard\IdCardStoreRequest;
use App\Http\Requests\IdCard\IdCardSearchRequest;
use App\Http\Requests\IdCard\IdCardUpdateRequest;
use App\Repositories\Academic\ClassSetupRepository;
use App\Http\Requests\Examination\Homework\HomeworkStoreRequest;

class IdCardController extends Controller
{
    private $repo;
    private $classSetupRepo;

    function __construct(IdCardRepository $repo, ClassSetupRepository $classSetupRepo)
    {
        $this->repo               = $repo;
        $this->classSetupRepo     = $classSetupRepo;  
        
    }

    public function index()
    {
        $data['title']              = ___('common.id_cards');
        $data['id_cards']           = $this->repo->getPaginateAll();
        return view('backend.id-card.index', compact('data'));
    }

    public function create()
    {
        $data['title']                  = ___('common.id_cards_create');
        return view('backend.id-card.create', compact('data'));
    }

    public function store(IdCardStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('idcard.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id, Request $request)
    {
        $data['id_card']              = $this->repo->show($id);

        
        $data['title']                 = ___('common.id_cards_edit');
        return view('backend.id-card.edit', compact('data'));
    }

    public function update(IdCardUpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('idcard.index')->with('success', $result['message']);
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

    public function preview(Request $request)
    {
        $data['idcard'] = $this->repo->show($request->idcard_id);
        
        $data['view'] = view('backend.id-card.preview', compact('data'))->render();

        return response()->json($data);

    }

    public function generate()
    {
        $data['title']              = ___('common.generate_id_cards');
        $data['id_cards']           = $this->repo->all();
        $data['classes']            = $this->classSetupRepo->all();
        return view('backend.id-card.generate', compact('data'));
    }

    public function generateSearch(IdCardSearchRequest $request)
    {
        $result = $this->repo->generateSearch($request);
        if ($result['status']) {
            $data['idcard']             = $result['data']['idcard'];
            $data['students']           = $result['data']['students'];
            $data['title']              = ___('common.generate_id_cards');

            $data['id_cards']           = $this->repo->all();
            $data['classes']            = $this->classSetupRepo->all();

            return view('backend.id-card.generate', compact('data'));
        }
        return back()->with('danger', $result['message']);

    }

}
