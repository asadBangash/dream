<?php

namespace App\Http\Controllers\Settings;

use App\Models\BloodGroup;
use Illuminate\Http\Request;
use App\Interfaces\BloodGroupInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\BloodGroup\BloodGroupStoreRequest;
use App\Http\Requests\BloodGroup\BloodGroupUpdateRequest;
use Illuminate\Support\Facades\Schema;

class BloodGroupController extends Controller
{
    private $bloodGroup;

    function __construct(BloodGroupInterface $bloodGroup)
    {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        } 
        $this->bloodGroup       = $bloodGroup; 
    }

    public function index()
    {
        $data['bloodGroup'] = $this->bloodGroup->getAll();
        $data['title'] = ___('settings.blood_groups');
        return view('backend.blood_group.index', compact('data'));
    }

    public function create()
    {
        $data['title']       = ___('settings.create_blood_group');
        return view('backend.blood_group.create', compact('data'));
    }

    public function store(BloodGroupStoreRequest $request)
    {
        $result = $this->bloodGroup->store($request);
        if($result['status']){
            return redirect()->route('blood-groups.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['bloodGroup']        = $this->bloodGroup->show($id);
        $data['title']       = ___('settings.edit_blood_group');
        return view('backend.blood_group.edit', compact('data'));
    }

    public function update(BloodGroupUpdateRequest $request, $id)
    {
        $result = $this->bloodGroup->update($request, $id);
        if($result['status']){
            return redirect()->route('blood-groups.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        $result = $this->bloodGroup->destroy($id);
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
