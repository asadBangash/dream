<?php

namespace Modules\MultiBranch\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\MultiBranch\Entities\Branch;
use Modules\MultiBranch\Http\Requests\BranchStoreRequest;
use Modules\MultiBranch\Interfaces\BranchInterface;

class BranchController extends Controller
{

    protected $branch;

    public function __construct(BranchInterface $branchInterface)
    {
        $this->branch = $branchInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = ___('multibranch.branches');
        $data['branches'] = $this->branch->paginate(10);
        return view('multibranch::branch.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = ___('multibranch.create branch');
        $data['countries'] = [];
        return view('multibranch::branch.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BranchStoreRequest $request)
    {
        try {
           $this->branch->store($request);
            return redirect()->route('branch.index')->with('success', ___('alert.successfully created'));
        }catch (\Exception $e) {
            dd($e);
            Log::error($e->getMessage());
            return back()->with('danger', ___('alert.something went wrong'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['title'] = ___('multibranch.create branch');
        $data['branch'] = $this->branch->show($id);
        return view('multibranch::branch.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $this->branch->update($request, $id);
            return redirect()->route('branch.index')->with('success', ___('alert.successfully updated'));
        }catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('danger', ___('alert.something went wrong'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $result = $this->branch->delete($id);
        if($result):
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
