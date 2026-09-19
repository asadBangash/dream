<?php

namespace App\Http\Controllers\Fees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fees\Type\FeesTypeStoreRequest;
use App\Http\Requests\Fees\Type\FeesTypeUpdateRequest;
use App\Interfaces\Fees\FeesTypeInterface;
use Illuminate\Http\Request;

class FeesTypeController extends Controller
{
    private $repo;

    function __construct(FeesTypeInterface $repo)
    {
        $this->repo       = $repo;
    }

    public function index()
    {
        $data['title']              = ___('fees.fees_type');
        $data['fees_types'] = $this->repo->getPaginateAll();

        return view('backend.fees.type.index', compact('data'));

    }

    public function create()
    {
        $data['title']              = ___('fees.fees_type');
        return view('backend.fees.type.create', compact('data'));

    }

    public function store(FeesTypeStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if($result['status']){
            return redirect()->route('fees-type.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['fees_type']        = $this->repo->show($id);
        $data['title']       = ___('fees.fees_type');
        return view('backend.fees.type.edit', compact('data'));
    }

    public function update(FeesTypeUpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('fees-type.index')->with('success', $result['message']);
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
