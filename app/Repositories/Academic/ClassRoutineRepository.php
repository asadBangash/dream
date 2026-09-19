<?php

namespace App\Repositories\Academic;

use App\Enums\ApiStatus;
use App\Traits\ReturnFormatTrait;
use App\Models\Academic\ClassRoom;
use Illuminate\Support\Facades\DB;
use App\Models\Academic\ClassRoutine;
use App\Models\Academic\TimeSchedule;
use App\Models\Academic\ClassRoutineChildren;
use App\Interfaces\Academic\ClassRoutineInterface;

class ClassRoutineRepository implements ClassRoutineInterface
{
    use ReturnFormatTrait;

    private $model;

    public function __construct(ClassRoutine $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->active()->where('session_id', setting('session'))->get();
    }

    public function getPaginateAll()
    {
        return $this->model::latest()->where('session_id', setting('session'))->paginate(10);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {

            $class_routine             = new $this->model();
            $class_routine->classes_id   = $request->class;
            $class_routine->section_id = $request->section;
            $class_routine->session_id = setting('session');

            if($request->shift != "" ) {
                $class_routine->shift_id   = $request->shift;
            }

            $class_routine->day        = $request->day;
            $class_routine->save();

            foreach ($request->subjects ?? [] as $key => $subject) {
                $row                      = new ClassRoutineChildren;
                $row->class_routine_id    = $class_routine->id;
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
        return ClassRoutineChildren::with('subject')->where('class_routine_id', @$result->id)->select('subject_id')->get();
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
            $class_routine             = $this->model::find($id);
            $class_routine->classes_id   = $request->class;
            $class_routine->section_id = $request->section;
            $class_routine->session_id = setting('session');

            if($request->shift != "" ) {
                $class_routine->shift_id   = $request->shift;
            }

            $class_routine->day        = $request->day;
            $class_routine->save();

            $class_routine->classRoutineChildren()->delete();

            foreach ($request->subjects ?? [] as $key => $subject) {
                $row                      = new ClassRoutineChildren;
                $row->class_routine_id    = $class_routine->id;
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

    public function checkClassRoutine($request)
    {
        $data = [];
        $class_routine = $this->model->where('session_id', setting('session'))->where('classes_id', $request->class)->where('section_id', $request->section)->where('day', $request->day);
        if ($request->shift != "") {
            $class_routine->where('shift_id', $request->shift)->where('shift_id', '!=', '');
        } else {
            $class_routine->where('shift_id', '');
        }

        if($request->id != '') {
            $class_routine->where('id', '!=', $request->id);
        }
        $class_routine = $class_routine->first();

        if($class_routine) {
            $data['message'] = ___('academic.already_created_class_routine');
            $data['status']  = false;

            return $data;
        } 


        if(array_diff_assoc($request->time_schedules, array_unique($request->time_schedules))) {
            $data['message'] = ___('academic.you_cant_select_duplicate_time_schedule');
            $data['status']  = false;

            return $data;
        }

        foreach($request->time_schedules as $key=>$time) {
            $class_routine = $this->model->where('session_id', setting('session'))
                                        ->where('day', $request->day)
                                        ->join('class_routine_childrens', 'class_routines.id', '=', 'class_routine_childrens.class_routine_id')
                                        ->where('class_routine_childrens.time_schedule_id', $time)->where('class_routine_childrens.class_room_id', $request->class_rooms[$key]);


            if($request->id != '') {
                $class_routine->where('id', '!=', $request->id);
            } 
            
            $class_routine = $class_routine->first();
                                        

            if($class_routine) {
                $schedule = TimeSchedule::find($time);
                $room     = ClassRoom::find($request->class_rooms[$key]);
                $data['message'] = ___('academic.already_assigned_to_class_routine_for_this_schedule_room').'. Schedule:'.$schedule->start_time.'-'.$schedule->end_time.' Room:'.$room->room_no;
                $data['status']  = false;

                return $data;
            }
        }
        
        return $data;

    

    }
}
