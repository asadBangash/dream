<?php

namespace App\Http\Controllers\Fees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fees\Master\FeesMasterStoreRequest;
use App\Http\Requests\Fees\Master\FeesMasterUpdateRequest;
use App\Interfaces\Fees\FeesGroupInterface;
use App\Interfaces\Fees\FeesMasterInterface;
use App\Interfaces\Fees\FeesTypeInterface;
use App\Repositories\Academic\ClassesRepository;
use Illuminate\Http\Request;

class FeesMasterController extends Controller
{
    private $repo;
    private $type;
    private $group;
    private $classRepo;

    function __construct(FeesMasterInterface $repo,FeesTypeInterface $type,FeesGroupInterface $group, ClassesRepository $classRepo)
    {
        $this->repo       = $repo; 
        $this->type       = $type; 
        $this->group      = $group; 
        $this->classRepo  = $classRepo; 
    }
    
    public function index()
    {
        $data['title']        = ___('fees.fees_master');
        $data['fees_masters'] = $this->repo->getPaginateAll();
        return view('backend.fees.master.index', compact('data'));
    }
    
    public function getAllTypes(Request $request)
    {
        $types = $this->repo->groupTypes($request);
        return view('backend.fees.master.fees-types', compact('types'))->render();
    }

    public function create()
    {
        $data['title']        = ___('fees.fees_master');
        $data['fees_types']   = $this->type->all();
        $data['fees_groups']  = $this->group->all();
        return view('backend.fees.master.create', compact('data'));
    }

    public function store(FeesMasterStoreRequest $request)
    {
        // dd($request->all());
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('fees-master.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['title']        = ___('fees.fees_master');
        $data['fees_master']  = $this->repo->show($id);
        $data['fees_types']   = $this->type->all();
        $data['fees_groups']  = $this->group->all();
        // dd($data);
        return view('backend.fees.master.edit', compact('data'));
    }

    public function update(FeesMasterUpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('fees-master.index')->with('success', $result['message']);
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
