<?php

namespace App\Repositories\leave;

use App\Models\LeaveRequest;
use App\Traits\CommonHelperTrait;

class StudentLeaveRequestRepository
{

    use CommonHelperTrait;
    private $leaveRepo;

    public function __construct(LeaveRequestRepository $leaveRepo){
        $this->leaveRepo = $leaveRepo;
    }

    public function store($request)
    {
        try {
            $user = auth()->user();
            if ($request->editLeaveId != null){
                $leaveRequest = LeaveRequest::where('user_id', $user->id)
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
            $leaveRequest->user_id = $user->id;
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

    public function list()
    {
        $userId = auth()->user()->id;
        $leaveRequest = LeaveRequest::where('user_id', $userId)->paginate(10);
        return $leaveRequest;
    }
}
