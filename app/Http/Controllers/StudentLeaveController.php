<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Repositories\leave\StudentLeaveRequestRepository;
use Illuminate\Http\Request;

class StudentLeaveController extends Controller
{
    private $leaveRepo;

    public function __construct(StudentLeaveRequestRepository $leaveRepo){
        $this->leaveRepo = $leaveRepo;
    }

    public function index()
    {
        $data['leave_requests'] = $this->leaveRepo->list();
        $data['title'] = ___('leave.Add Leave Request');
        $data['types'] = LeaveType::where('active_status', true)->get();
        return view('backend.leave.student-leave', compact('data'));
    }

    public function store(Request $request)
    {
        $result = $this->leaveRepo->store($request);
        if ($result) {
            return redirect()->back()->with('success', ___('alert.updated_successfully'));
        }
        return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
    }

    public function edit($id)
    {
        $userId = auth()->user()->id;
        $editLeave = LeaveRequest::where('user_id', $userId)
            ->where('id', $id)->first();
        $leaveRequest = LeaveRequest::where('user_id', $userId)->paginate(10);
        $data['leave_requests'] = $leaveRequest;
        $data['editLeave'] = $editLeave;
        $data['title'] = ___('leave.Edit Leave Request');
        $data['types'] = LeaveType::where('active_status', true)->get();
        return view('backend.leave.student-leave', compact('data'));
    }

    public function destroy($id){
        $result = LeaveRequest::findOrFail($id)->where('user_id', auth()->user()->id)->delete();
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
