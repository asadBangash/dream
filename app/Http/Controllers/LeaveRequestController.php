<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveRequestStoreRequest;
use App\Models\Academic\Section;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\StudentInfo\Student;
use App\Repositories\Academic\ClassesRepository;
use App\Repositories\leave\LeaveRequestRepository;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    private $leaveRequestRepo;
    private $classRepo;

    public function __construct(LeaveRequestRepository $leaveRequestRepo, ClassesRepository $classRepo){
        $this->leaveRequestRepo = $leaveRequestRepo;
        $this->classRepo = $classRepo;
    }

    public function index(){
        $data['leave_requests'] = $this->leaveRequestRepo->all();
        $data['title'] = ___('leave.Leave Request');
        $data['types'] = LeaveType::where('active_status', true)->get();

        $data['classes'] = $this->classRepo->assignedAll();
        $data['sections'] = [];

        $data['students'] = [];
        return view('backend.leave.request', compact('data'));
    }

    public function store(LeaveRequestStoreRequest $request)
    {

        if ($request->editLeaveId){
            $result = $this->leaveRequestRepo->update($request);
        }else{
            $result = $this->leaveRequestRepo->store($request);
        }

        if ($result) {
            return redirect()->back()->with('success', ___('alert.updated_successfully'));
        }
        return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
    }


    public function edit($id)
    {
        $data['leave_requests'] = $this->leaveRequestRepo->all();
        $data['title'] = ___('leave.Leave Request');
        $data['types'] = LeaveType::where('active_status', true)->get();

        $data['classes'] = $this->classRepo->assignedAll();
        $data['sections'] = [];

        $data['students'] = [];

        $editLeave = $this->leaveRequestRepo->show($id);

        $student = Student::with('session_class_student')
        ->where('user_id', $editLeave->user_id)->first();

        $data['class_id'] = $student->session_class_student->classes_id;
        $data['section'] = $student->session_class_student->section;
        $data['student_id'] = $student->id;

        return view('backend.leave.request', compact('data', 'editLeave'));
    }

    public function delete($id)
    {
        $result = $this->leaveRequestRepo->delete($id);
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
