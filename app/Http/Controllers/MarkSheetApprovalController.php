<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarkSheetApprovalRequest;
use App\Models\MarkSheetApproval;
use App\Models\StudentInfo\Student;
use Illuminate\Http\Request;

class MarkSheetApprovalController extends Controller
{
    public function approveOrReject(MarkSheetApprovalRequest $request)
    {

        $student = Student::with('sessionStudentDetails')->find($request->student_id);

        if (!$student || !$student->sessionStudentDetails) {
            return redirect()->back()->with('danger', 'Invalid student or session details.');
        }

        $classId = $student->sessionStudentDetails->classes_id;
        $sessionId = $student->sessionStudentDetails->session_id;
        $sectionId = $student->sessionStudentDetails->section_id;

        try {
            $markSheetApproval = MarkSheetApproval::where([
                'student_id' => $request->student_id,
                'session_id' => $sessionId,
                'classes_id' => $classId,
                'section_id' => $sectionId,
                'exam_type_id' => $request->exam_type,
            ])->first();

            if ($markSheetApproval) {
                $markSheetApproval->status = $request->status;
                $markSheetApproval->remarks = $request->remarks;
                $markSheetApproval->save();
            } else {
                MarkSheetApproval::create([
                    'student_id' => $request->student_id,
                    'session_id' => $sessionId,
                    'classes_id' => $classId,
                    'section_id' => $sectionId,
                    'status' => $request->status,
                    'remarks' => $request->remarks,
                    'exam_type_id' => $request->exam_type,
                ]);
            }

            return redirect()->back()->with('success', 'Marksheet approval updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('danger', 'Something went wrong. Please try again.');
        }
    }

}
