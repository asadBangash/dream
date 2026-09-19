<?php

namespace App\Repositories\leave;

use App\Enums\RoleEnum;
use App\Models\LeaveRequest;
use App\Traits\CommonHelperTrait;
use Illuminate\Http\Request;

class ParentLeaveRequestRepository
{
    use CommonHelperTrait;

    private $leaveRequestRepo;
    private $leaveRepo;


    public function __construct(LeaveRequestRepository $leaveRequestRepo, LeaveRequestRepository $leaveRepo){
        $this->leaveRequestRepo = $leaveRequestRepo;
        $this->leaveRepo = $leaveRepo;
    }

    public function store(Request $request)
    {
        try {
            $user = auth()->user();
            if ($request->editLeaveId != null){
                $leaveRequest = LeaveRequest::where('request_by', $user->id)
                    ->where('id', $request->editLeaveId)->first();
            }else{
                $leaveRequest = new LeaveRequest();
            }
            $leaveRequest->leave_type_id = $request->leave_type;
            $leaveRequest->start_date = $request->start_date;
            $leaveRequest->end_date = $request->end_date;
            $leaveRequest->description = $request->description;
            if ($request->hasFile('attachment')){
                $upload_id = $this->UploadImageCreate($request->file('attachment'), 'backend/uploads/students');
                $leaveRequest->attachment_id = $upload_id;
            }
            $leaveRequest->user_id = $request->student;
            $leaveRequest->request_by = auth()->id();
            $leaveRequest->session_id = setting('session');
            $leaveRequest->leave_days = $this->leaveRepo->calculateLeaveDays($request);
            $leaveRequest->save();

            send_web_notification('New Leave Request', 'leave type: '. $leaveRequest->leaveType->name, 1, route('leave-request.index'));
            return true;
        }catch (\Exception $e){
            return false;
        }
    }

    public function get($id)
    {
        $user = auth()->user();
        $editLeave = LeaveRequest::where('request_by', $user->id)
            ->where('id', $id)->first();
        $leaveRequest = LeaveRequest::where('request_by', $user->id)->paginate(10);
        $data['leave_requests'] = $leaveRequest;
        $data['editLeave'] = $editLeave;
        return $data;
    }
}
