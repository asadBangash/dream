<?php

namespace App\Http\Controllers\Leave;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $data['title']              = ___('leave.Leave Type');
        $data['types']              = LeaveType::paginate(10);;
        return view('backend.leave.type', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        try {
            $data = $request->type_id ? LeaveType::findOrFail($request->type_id) : new LeaveType();

            $data->name = $request->name;
            $data->short_desc = $request->description;
            $data->role_id = RoleEnum::STUDENT;
            $data->active_status = $request->status;
            $data->save();
            return redirect()->route('leave-type.index')->with('success', 'Operation successful.');
        }catch (\Exception $e){
            return redirect()->back()->with('danger', 'Something went wrong');
        }
    }

    public function edit($id)
    {
        try {
            $data['title']              = ___('leave.Leave Type');
            $data['types']              = LeaveType::paginate(10);
            $data['edit_type']          = LeaveType::findOrFail($id);
            return view('backend.leave.type', compact('data'));
        }catch (\Exception){
            return redirect()->back()->with('danger', 'Something went wrong');
        }
    }

    public function delete($id)
    {
        try {
            LeaveType::findOrFail($id)->delete();
            $success[0] = 'Deleted Successfully';
            $success[1] = 'success';
            $success[2] = ___('alert.deleted');
            $success[3] = ___('alert.OK');
            return response()->json($success);

        }catch (\Exception $e){
            $response = [
                'message' => $e->getMessage(),
                'status' => 'error',
                'title' => ___('alert.oops'),
                'button' => ___('alert.OK'),
            ];

            return response()->json($response);
        }
    }
}
