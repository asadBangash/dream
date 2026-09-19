<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\StudentInfo\Student;
use App\Repositories\leave\ParentLeaveRequestRepository;
use App\Traits\CommonHelperTrait;
use Illuminate\Http\Request;

class ParentLeaveController extends Controller
{
    use CommonHelperTrait;

    private $leaveRepo;


    public function __construct(ParentLeaveRequestRepository $leaveRepo){
        $this->leaveRepo = $leaveRepo;
    }

    public function index(){

        $user = auth()->user()->load('parent');
        $parentId = $user->parent->id;
        $data['leave_requests'] = LeaveRequest::where('request_by', $user->id)->paginate(10);
        $data['title'] = ___('leave.Add Leave Request');
        $data['types'] = LeaveType::where('active_status', true)->get();
        $data['students'] = Student::where('parent_guardian_id', $parentId)->get();
        return view('backend.leave.parent-leave', compact('data'));
    }

    public function store(Request $request)
    {
        $result = $this->leaveRepo->store($request);
        if ($result) {
            return redirect()->back()->with('success', ___('alert.updated_successfully'));
        } else {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function edit($id)
    {
        $user = auth()->user();
        $data = $this->leaveRepo->get($id);
        $data['title'] = ___('leave.Edit Leave Request');
        $data['types'] = LeaveType::where('active_status', true)->get();
        $parentId = $user->parent->id;
        $data['students'] = Student::where('parent_guardian_id', $parentId)->get();
        return view('backend.leave.parent-leave', compact('data'));
    }

    public function destroy($id){
        $result = LeaveRequest::findOrFail($id);
        $result->delete();
        if ($result) {
            $success[0] = 'Deleted Successfully';
            $success[1] = 'success';
            $success[2] = ___('alert.deleted');
            $success[3] = ___('alert.OK');
            return response()->json($success);
        }else{
            $response = [
                'message' => 'Something went wrong!',
                'status' => 'error',
                'title' => ___('alert.oops'),
                'button' => ___('alert.OK'),
            ];

            return response()->json($response);
        }
    }
}
