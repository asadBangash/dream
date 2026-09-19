<?php

namespace App\Http\Controllers\Api\Teacher;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Traits\ReturnFormatTrait;
use App\Http\Controllers\Controller;
use App\Models\Academic\ExamRoutine;
use App\Models\Examination\ExamType;
use App\Models\Academic\ExamRoutineChildren;
use App\Models\Academic\ClassRoutineChildren;
use App\Http\Resources\TeacherExamRoutineResource;
use App\Http\Resources\TeacherClassRoutineResource;

class TeacherRoutineController extends Controller
{
    use ReturnFormatTrait;

    public function classRoutines()
    {
        request()->merge(array_map(function ($value) {
                    return $value === 'null' ? null : $value;
                }, request()->all()));

        $dayNum                 = getDayNum(request('date') ?? Carbon::now()->format('Y-m-d'));

        $dateFormat = request('date')
            ? Carbon::parse(request('date'))->translatedFormat('l d F')
            : Carbon::now()->translatedFormat('l d F');

         

        $subjectAssigns = auth()->user()->staff->subjectAssigns;
        $class_ids = (request('class_id')) ? (array) request('class_id') : $subjectAssigns->pluck('classes_id')->unique();
        $section_ids = (request('section_id')) ? (array) request('section_id') : $subjectAssigns->pluck('section_id')->unique();

        $routines               = ClassRoutineChildren::query()
            ->whereHas('classRoutine', function ($q) use ($class_ids, $section_ids, $dayNum) {
                $q->whereIn('classes_id', $class_ids)
                    ->whereIn('section_id',  $section_ids)
                    ->where('session_id', setting('session'))
                    ->where('day', $dayNum);
            })
            ->with(['classRoutine' => function ($q) use ($class_ids, $section_ids, $dayNum) {
                $q->whereIn('classes_id', $class_ids)
                    ->whereIn('section_id',  $section_ids)
                    ->where('session_id', setting('session_id'))
                    ->where('day', $dayNum);
            }])
            ->whereHas('timeSchedule', fn($q) => $q->class()->active())
            ->with(['timeSchedule' => fn($q) => $q->class()->active()])
            ->whereHas('subject', fn($q) => $q->active())
            ->with(['subject' => fn($q) => $q->active()])
            ->whereHas('classRoom', fn($q) => $q->active())
            ->with(['classRoom' => fn($q) => $q->active(), 'classRoutine'])
            ->get();

        if (!$routines->count()) {
            return $this->responseWithError(___('alert.No class routine found'));
        }


        $data                   = TeacherClassRoutineResource::collection($routines);

        return $this->responseWithSuccess($dateFormat . ' Class Routines', $data);
    }


    public function examRoutines()
    {
        try {

            request()->merge(array_map(function ($value) {
                    return $value === 'null' ? null : $value;
                }, request()->all()));

            if (!request('exam_type')) {
                return $this->responseWithError(___('alert.You must select an exam type'));
            }

            $subjectAssigns = auth()->user()->staff->subjectAssigns;
            $class_ids = (request('class_id')) ? (array) request('class_id') : $subjectAssigns->pluck('classes_id')->unique();
            $section_ids = (request('section_id')) ? (array) request('section_id') : $subjectAssigns->pluck('section_id')->unique();
            $exam_routine_ids = ExamRoutine::whereIn('classes_id', $class_ids)
                ->whereIn('section_id', $section_ids)->where('session_id', setting('session'))
                ->when(request('class'), fn($q) => $q->where('classes_id', request('class')))
                ->when(request('section'), fn($q) => $q->where('section_id', request('section')))
                ->when(request('exam_type'), fn($q) => $q->where('type_id', request('exam_type')))
                ->pluck('id')->toArray();

            $exam_routine_schedules = ExamRoutineChildren::whereIn('exam_routine_id', $exam_routine_ids)
                ->whereHas('timeSchedule', fn($q) => $q->class()->active())
                ->with(['timeSchedule' => fn($q) => $q->class()->active()])
                ->whereHas('subject', fn($q) => $q->active())
                ->with(['subject' => fn($q) => $q->active()])
                ->whereHas('classRoom', fn($q) => $q->active())
                ->with(['classRoom' => fn($q) => $q->active()])
                ->with(['class', 'section', 'exam_type'])
                ->get();

            if (!$exam_routine_schedules->count()) {
                return $this->responseWithError(___('alert.No exam routine found'));
            }

            $data                   = TeacherExamRoutineResource::collection($exam_routine_schedules);


            return $this->responseWithSuccess(___('alert.success'), $data);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }
}
