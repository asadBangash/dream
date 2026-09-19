<?php

namespace App\Repositories\Examination;

use App\Models\Academic\Classes;
use App\Models\Academic\Section;
use App\Models\Academic\Subject;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Models\Examination\ExamType;
use Illuminate\Support\Facades\Auth;
use App\Models\Academic\SubjectAssign;
use App\Models\Examination\ExamAssign;
use App\Models\Examination\MarksRegister;
use App\Models\Academic\SubjectAssignChildren;
use App\Models\Examination\ExamAssignChildren;
use App\Interfaces\Examination\ExamAssignInterface;

class ExamAssignRepository implements ExamAssignInterface
{
    use ReturnFormatTrait;

    private $model;

    public function __construct(ExamAssign $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->active()->where('session_id', setting('session'))->get();
    }

    public function assignedExamType()
    {
        return $this->model->select('exam_type_id')->where('session_id', setting('session'))->distinct()->get();
    }

    public function getExamType($request)
    {
        return $this->model
        ->where('session_id', setting('session'))
        ->where('classes_id',$request->class)
        ->where('section_id',$request->section)
        ->select('exam_type_id')
        ->distinct()
        ->with('exam_type')
        ->get();
    }

    public function getExamAssign($request)
    {
        return $this->model
        ->where('session_id',setting('session'))
        ->where('classes_id',$request->class)
        ->where('section_id',$request->section)
        ->where('exam_type_id',$request->exam_type)
        ->where('subject_id',$request->subject)
        ->first();
    }

    public function getPaginateAll()
    {
        return $this->model::latest()->where('session_id', setting('session'))->whereIn('subject_id', teacherSubjects())->paginate(10);
    }

    public function searchExamAssign($request)
    {
        // dd($request->all());
        // return $this->model::latest()->where('session_id', setting('session'))->paginate(10);
        $rows = $this->model::query();
        $rows = $rows->where('session_id', setting('session'));
        if($request->class != "") {
            $rows = $rows->where('classes_id', $request->class);
        }
        if($request->section != "") {
            $rows = $rows->where('section_id', $request->section);
        }
        if($request->exam_type != "") {
            $rows = $rows->where('exam_type_id', $request->exam_type);
        }
        if($request->subject != "") {
            $rows = $rows->where('subject_id', $request->subject);
        }
        return $rows->paginate(10);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {

            foreach ($request->exam_types as $exam_type) {
                foreach ($request->sections as $section) {
                    foreach ($request->subjects as $key=>$subject) {

                        // if($this->model->where('session_id',setting('session'))->where('classes_id',$request->class)->where('section_id',$section)->where('exam_type_id',$exam_type)->where('subject_id',$subject)->first())
                        //     return $this->responseWithError(___('alert.There is already assign for this session.'), []);

                        $row                         = new $this->model;
                        $row->session_id             = setting('session');
                        $row->classes_id               = $request->class;
                        $row->section_id             = $section;
                        $row->exam_type_id           = $exam_type;
                        $row->subject_id             = $subject;
                        // $row->total_mark             = $request->total_marks[$subject];
                        $row->save();

                        $total_mark                  = 0;
                        foreach ($request->marks_distribution[$subject]['titles'] as $itemKey=>$title) { // 2+1
                            $examAssign                 = new ExamAssignChildren();
                            $examAssign->exam_assign_id = $row->id;
                            $examAssign->title          = $title;
                            $examAssign->mark           = $request->marks_distribution[$subject]['marks'][$itemKey];
                            $examAssign->save();

                            $total_mark += $request->marks_distribution[$subject]['marks'][$itemKey];
                        }

                        $row->total_mark             = $total_mark;
                        $row->save();

                    }
                }
            }
            DB::commit();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function show($id)
    {
        $row = $this->model->find($id);

        $result = MarksRegister::where('session_id',$row->session_id)
        ->where('classes_id',$row->classes_id)
        ->where('section_id',$row->section_id)
        ->where('exam_type_id',$row->exam_type_id)
        ->where('subject_id',$row->subject_id)
        ->first();

        if(@$result)
            return null;
        else
            return @$row;
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {

            if($this->model->where('session_id', setting('session'))->where('classes_id',$request->class)->where('section_id',$request->sections)->where('exam_type_id',$request->exam_types)->where('subject_id',$request->subjects)->where('id', '!=', $id)->first())
                return $this->responseWithError(___('alert.There is already assign for this session.'), []);

            $row                         = $this->model->find($id);
            $row->session_id             = setting('session');
            $row->classes_id               = $request->class;
            $row->section_id             = $request->sections;
            $row->exam_type_id           = $request->exam_types;
            $row->subject_id             = $request->subjects;
            // $row->total_mark             = $request->total_marks[$request->subjects];
            $row->save();

            ExamAssignChildren::where('exam_assign_id', $row->id)->delete();
            $total_mark                  = 0;
            foreach ($request->marks_distribution[$request->subjects]['titles'] as $itemKey=>$title) {
                $examAssign                 = new ExamAssignChildren();
                $examAssign->exam_assign_id = $row->id;
                $examAssign->title          = $title;
                $examAssign->mark           = $request->marks_distribution[$request->subjects]['marks'][$itemKey];
                $examAssign->save();
                
                $total_mark += $request->marks_distribution[$request->subjects]['marks'][$itemKey];
            }

            $row->total_mark             = $total_mark;
            $row->save();
 
            DB::commit();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function checkMarkRegister($id){
        $row = $this->model->find($id);

        $result = MarksRegister::where('session_id',$row->session_id)
            ->where('classes_id',$row->classes_id)
            ->where('section_id',$row->section_id)
            ->where('exam_type_id',$row->exam_type_id)
            ->where('subject_id',$row->subject_id)
            ->first();
        if($result)
            return true;
        else
            return false;
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $row = $this->model->find($id);

            MarksRegister::where('session_id',$row->session_id)
            ->where('classes_id',$row->classes_id)
            ->where('section_id',$row->section_id)
            ->where('exam_type_id',$row->exam_type_id)
            ->where('subject_id',$row->subject_id)
            ->delete();

            ExamAssignChildren::where('exam_assign_id', $row->id)->delete();
            $row->delete();

            DB::commit();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function getSubjects($request)
    {

        $sections = $request->sections;

        if ($sections == "") {
            $sections  = [];
        }

        $data = [];


        if($request->form_type == "update") {
            $result = SubjectAssign::active()->where('session_id', setting('session'))->where('classes_id', $request->classes_id)->where('section_id', $request->section_id)->first();



            $current_subjects = SubjectAssignChildren::with('subject')
                                                        ->where('subject_assign_id', @$result->id)
                                                        ->when(Auth::user()->role_id == 5, function ($query) {
                                                            return $query->where('staff_id', Auth::user()->staff->id);
                                                        })
                                                        ->select('subject_id')
                                                        ->get();

            $data['subjects']             = $current_subjects;
            $data['loop_status']          = true;
            $data['section_status']       = true;
            $data['message']              = '';
            return $data;
        }
        // if very first checked then works it.
        if($request->section_id != "" && count($sections) == 1) {

            $result           = SubjectAssign::active()->where('session_id', setting('session'))->where('classes_id', $request->classes_id)->where('section_id', $request->section_id)->first();
            $current_subjects = SubjectAssignChildren::with('subject')
                                                        ->where('subject_assign_id', @$result->id)
                                                        ->when(Auth::user()->role_id == 5, function ($query) {
                                                            return $query->where('staff_id', Auth::user()->staff->id);
                                                        })
                                                        ->select('subject_id')
                                                        ->get();

            if(count($current_subjects) == 0) {

                $data['subjects']         = $current_subjects;
                $data['loop_status']      = false;
                $data['section_status']   = false;
                $data['message']          = ___('alert.there_are_no_subjects_assigned_to_this_section');


            } else {

                $data['subjects']         = $current_subjects;
                $data['loop_status']      = true;
                $data['section_status']   = true;
                $data['message']          = '';
            }


        // 2nd section select then works it
        } elseif ($request->section_id != "" && count($sections) > 1) {

            foreach ($sections as $section) {
                if ($request->section_id != $section) {
                    $old_section = $section;
                }
            }


            $old_result   = SubjectAssign::active()->where('session_id', setting('session'))->where('classes_id', $request->classes_id)->where('section_id', $old_section)->first();
            $old_subjects = SubjectAssignChildren::where('subject_assign_id', @$old_result->id)
                                                    ->when(Auth::user()->role_id == 5, function ($query) {
                                                        return $query->where('staff_id', Auth::user()->staff->id);
                                                    })
                                                    ->pluck('subject_id')
                                                    ->toArray();

            $current_result   = SubjectAssign::active()->where('session_id', setting('session'))->where('classes_id', $request->classes_id)->where('section_id', $request->section_id)->first();
            $current_subjects = SubjectAssignChildren::where('subject_assign_id', @$current_result->id)
                                                        ->when(Auth::user()->role_id == 5, function ($query) {
                                                            return $query->where('staff_id', Auth::user()->staff->id);
                                                        })
                                                        ->pluck('subject_id')
                                                        ->toArray();

            array_multisort($old_subjects);
            array_multisort($current_subjects);


            if(count($current_subjects) == 0) {

                $data['subjects']         = $current_subjects;
                $data['loop_status']      = false;
                $data['section_status']   = false;
                $data['message']          = ___('alert.there_are_no_subjects_assigned_to_this_section');


            } elseif (serialize($old_subjects) === serialize($current_subjects)) {
                $data['subjects']         = $current_subjects;
                $data['loop_status']      = false;
                $data['section_status']   = true;
                return $data;
            } else {

                $data['subjects']         = $current_subjects;
                $data['loop_status']      = false;
                $data['section_status']   = false;

                $data['message']          = ___('alert.checked_section_needs_the_same_subject');

            }

        } elseif ($request->section_id == "" && count($sections) > 0) {
            $data['subjects']         = [];
            $data['loop_status']      = false;
            $data['section_status']   = true;
            $data['message']          = '';

        } elseif($request->section_id == "" && count($sections) == 0) {
            $data['subjects']         = [];
            $data['loop_status']      = true;
            $data['section_status']   = true;
            $data['message']          = '';
        }

        return $data;
    }

    public function checkSubmit($request)
    {
        foreach ($request->exam_types as $exam_type) {
            foreach ($request->sections as $section) {
                foreach ($request->subjects as $key=>$subject) {

                    $subject_name   = Subject::find($subject)->name;
                    $exam_type_name = ExamType::find($exam_type)->name;
                    $section_name   = Section::find($section)->name;
                    $class_name     = Classes::find($request->class)->name;

                    if($this->model->where('session_id',setting('session'))->where('classes_id',$request->class)->where('section_id',$section)->where('exam_type_id',$exam_type)->where('subject_id',$subject)->first()) {
                        return $this->responseWithError(___('alert.There is already assign for this session, the subject is: '). $exam_type_name.'->'.$class_name.'->'.$section_name.'->'.$subject_name, []);
                    }
                }
            }
        }

        return $this->responseWithSuccess(___('alert.no assigned data found.'), []);



    }
}
