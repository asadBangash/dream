<?php

namespace App\Repositories\StudentPanel;

use App\Models\Academic\Subject;
use App\Models\Academic\ClassRoom;
use App\Models\Academic\TimeSchedule;
use App\Models\Academic\ClassRoutineChildren;
use App\Models\Academic\SubjectAssignChildren;
use App\Interfaces\StudentPanel\ClassRoutineInterface;
use App\Models\Academic\Classes;
use App\Models\Academic\Section;

class ClassRoutineRepository implements ClassRoutineInterface
{
    public function index()
    {
        try {
            $sessionClassStudent    = sessionClassStudent();
            $data['timeSchedules']  = TimeSchedule::query()
                                    ->active()
                                    ->class()
                                    ->whereHas('classRoutineChildren', function ($q) use ($sessionClassStudent) {
                                        $q->whereHas('classRoutine', function ($q) use ($sessionClassStudent) {
                                            $q->where('classes_id', @$sessionClassStudent->classes_id)
                                            ->where('section_id', @$sessionClassStudent->section_id)
                                            ->where('session_id', @$sessionClassStudent->session_id);
                                        })
                                        ->whereHas('subject', fn ($q) => $q->active())
                                        ->whereHas('classRoom', fn ($q) => $q->active());
                                    })
                                    ->get(['id', 'start_time', 'end_time']);

            $data['className']      = Classes::where('id', @$sessionClassStudent->classes_id)->first()?->name;
            $data['sectionName']    = Section::where('id', @$sessionClassStudent->section_id)->first()?->name;

                                    
            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function getSubjectTeacherRoomNo($time_schedule_id, $dayNum)
    {
        $sessionClassStudent    = sessionClassStudent();
        $classRoutineChildren   = ClassRoutineChildren::query()
                                ->where('time_schedule_id', $time_schedule_id)
                                ->whereHas('classRoutine', function ($q) use ($sessionClassStudent, $dayNum) {
                                    $q->where('classes_id', $sessionClassStudent->classes_id)
                                    ->where('section_id', $sessionClassStudent->section_id)
                                    ->where('session_id', $sessionClassStudent->session_id)
                                    ->where('day', $dayNum);
                                })
                                ->with(['classRoutine' => function ($q) use ($sessionClassStudent, $dayNum) {
                                    $q->where('classes_id', $sessionClassStudent->classes_id)
                                    ->where('section_id', $sessionClassStudent->section_id)
                                    ->where('session_id', $sessionClassStudent->session_id)
                                    ->where('day', $dayNum);
                                }])
                                ->first();

        if (!$classRoutineChildren) {
            return false;
        } 

        $subjectAssignChildren  = SubjectAssignChildren::query()
                                ->whereHas('subjectAssign', function ($q) use ($sessionClassStudent) {
                                    $q->active()
                                    ->where('session_id', $sessionClassStudent->session_id)
                                    ->where('classes_id', $sessionClassStudent->classes_id)
                                    ->where('section_id', $sessionClassStudent->section_id);
                                })
                                ->whereHas('subject', fn ($q) => $q->active()->where('id', @$classRoutineChildren->subject_id))
                                ->first();

        $subject                = Subject::active()->where('id', @$classRoutineChildren->subject_id)->first()?->name;
        $roomNo                 = ClassRoom::active()->where('id', @$classRoutineChildren->class_room_id)->first()?->room_no;

        return [
            'subject'           => $subject,
            'teacher'           => @$subjectAssignChildren->teacher->first_name . ' ' . @$subjectAssignChildren->teacher->last_name,
            'roomNo'            => $roomNo
        ];
    }
}
