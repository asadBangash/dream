<?php

namespace App\Repositories\Academic;

use App\Enums\ApiStatus;
use App\Traits\ReturnFormatTrait;
use App\Models\Academic\ClassRoom;
use Illuminate\Support\Facades\DB;
use App\Models\Academic\ExamRoutine;
use App\Models\Academic\TimeSchedule;
use App\Models\Academic\ExamRoutineChildren;
use App\Interfaces\Academic\ExamRoutineInterface;

class ExamRoutineRepository implements ExamRoutineInterface
{
    use ReturnFormatTrait;

    private $model;

    public function __construct(ExamRoutine $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->active()->where('session_id', setting('session'))->get();
    }

    public function assignedExamType()
    {
        return $this->model->select('type_id')->where('session_id', setting('session'))->distinct()->get();
    }

    public function getPaginateAll()
    {
        return $this->model::latest()->orderBy('id','desc')->where('session_id', setting('session'))->paginate(10);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            if($this->model::where('session_id', setting('session'))->where('classes_id', $request->class)->where('section_id', $request->section)->where('date', $request->date)->where('type_id', $request->type)->first()) {
                return $this->responseWithError(___('alert.there_is_already_assigned'), []);
            }

            $exam_routine              = new $this->model();
            $exam_routine->classes_id  = $request->class;
            $exam_routine->section_id  = $request->section;
            $exam_routine->session_id  = setting('session');
            $exam_routine->type_id     = $request->type;
            $exam_routine->date        = $request->date;
            $exam_routine->save();

            foreach ($request->subjects ?? [] as $key => $subject) {
                $row                      = new ExamRoutineChildren;
                $row->exam_routine_id     = $exam_routine->id;
                $row->subject_id          = $subject;
                $row->time_schedule_id    = $request->time_schedules[$key];
                $row->class_room_id       = $request->class_rooms[$key];
                $row->save();
            }


            DB::commit();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function getSubjects($request)
    {
        $result = $this->model->active()->where('session_id', setting('session'))->where('classes_id', $request->classes_id)->where('section_id', $request->section_id)->first();
        return ExamRoutineChildren::with('subject')->where('exam_routine_id', @$result->id)->select('subject_id')->get();
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request, $id)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
                       
            $exam_routine             = $this->model::find($id);
            $exam_routine->classes_id = $request->class;
            $exam_routine->section_id = $request->section;
            $exam_routine->session_id = setting('session');
            $exam_routine->type_id    = $request->type;
            $exam_routine->date       = $request->date;
            $exam_routine->save();

            $exam_routine->examRoutineChildren()->delete();

            foreach ($request->subjects ?? [] as $key => $subject) {
                $row                      = new ExamRoutineChildren;
                $row->exam_routine_id    = $exam_routine->id;
                $row->subject_id          = $subject;
                $row->time_schedule_id    = $request->time_schedules[$key];
                $row->class_room_id       = $request->class_rooms[$key];
                $row->save();
            }

            DB::commit();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        try {
            $row = $this->model->find($id);
            $row->delete();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function checkExamRoutine($request)
    {
        $data = [];
        $exam_routine = $this->model->where('session_id', setting('session'))->where('classes_id', $request->class)->where('section_id', $request->section)->where('date', $request->date)->where('type_id', $request->type);
        
        if($request->id != '') {
            $exam_routine->where('id', '!=', $request->id);
        }
        $exam_routine = $exam_routine->first();

        if($exam_routine) {
            $data['message'] = ___('academic.already_created_exam_routine');
            $data['status']  = false;

            return $data;
        } 


        if(array_diff_assoc($request->time_schedules, array_unique($request->time_schedules))) {
            $data['message'] = ___('academic.you_cant_select_duplicate_time_schedule');
            $data['status']  = false;

            return $data;
        }

        foreach($request->time_schedules as $key=>$time) {
            $exam_routine = $this->model->where('session_id', setting('session'))
                                        ->where('date', $request->date)
                                        ->join('exam_routine_childrens', 'exam_routines.id', '=', 'exam_routine_childrens.exam_routine_id')
                                        ->where('exam_routine_childrens.time_schedule_id', $time)->where('exam_routine_childrens.class_room_id', $request->class_rooms[$key]);


            if($request->id != '') {
                $exam_routine->where('id', '!=', $request->id);
            } 
            
            $exam_routine = $exam_routine->first();
                                        

            if($exam_routine) {
                $schedule = TimeSchedule::find($time);
                $room     = ClassRoom::find($request->class_rooms[$key]);
                $data['message'] = ___('academic.already_assigned_to_exam_routine_for_this_schedule_room').'. Schedule:'.$schedule->start_time.'-'.$schedule->end_time.' Room:'.$room->room_no;
                $data['status']  = false;

                return $data;
            }
        }
        
        return $data;

    

    }
}
