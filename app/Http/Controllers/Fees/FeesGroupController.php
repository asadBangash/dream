<?php

namespace App\Http\Controllers\Fees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fees\Group\FeesGroupStoreRequest;
use App\Http\Requests\Fees\Group\FeesGroupUpdateRequest;
use App\Interfaces\Fees\FeesGroupInterface;
use Illuminate\Http\Request;

class FeesGroupController extends Controller
{
    private $repo;

    function __construct(FeesGroupInterface $repo)
    {
        $this->repo       = $repo;
    }

    public function index()
    {
        $data['title']              = ___('fees.fees_group');
        $data['fees_groups'] = $this->repo->getPaginateAll();

        return view('backend.fees.group.index', compact('data'));

    }

    public function create()
    {
        $data['title']              = ___('fees.fees_group');
        return view('backend.fees.group.create', compact('data'));

    }

    public function store(FeesGroupStoreRequest $request)
    {
       
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('fees-group.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['fees_group']        = $this->repo->show($id);
        $data['title']       = ___('fees.fees_group');
        return view('backend.fees.group.edit', compact('data'));
    }

    public function update(FeesGroupUpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('fees-group.index')->with('success', $result['message']);
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
