<?php

namespace App\Repositories\Report;

use App\Interfaces\Report\ClassRoutineInterface;
use App\Models\Academic\ClassRoutine;
use App\Models\Academic\ClassRoutineChildren;
use App\Traits\ReturnFormatTrait;

class ClassRoutineRepository implements ClassRoutineInterface
{
    use ReturnFormatTrait;

    public function search($request)
    {
        return ClassRoutine::where('classes_id', $request->class)->where('section_id', $request->section)->where('session_id', setting('session'))->orderBy('day')->get();
    }

    public function time($request)
    {
        return ClassRoutineChildren::whereHas('classRoutine', function($q) use($request){
            $q->where('classes_id', $request->class)->where('section_id', $request->section)->where('session_id', setting('session'));
        })
        ->orderBy('time_schedule_id')
        ->select('time_schedule_id')
        ->distinct()
        ->get();
    }
}
