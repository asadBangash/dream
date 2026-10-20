<?php

namespace App\Repositories;

use App\Enums\LectureType;
use App\Models\TeacherLecture;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherLectureRepository
{
    use CommonHelperTrait;
    use ReturnFormatTrait;

    public function __construct(private TeacherLecture $model) {}

    public function getPaginateAll()
    {
        $query = $this->model::with(['class', 'section', 'subject', 'upload'])
            ->latest()
            ->where('session_id', setting('session'));

        if (Auth::user()->role_id == 5) {
            $subjectIds = teacherSubjects();
            $query->whereIn('subject_id', $subjectIds ?: [0]);
        }

        return $query->paginate(10);
    }

    public function forStudent(int $classesId, int $sectionId)
    {
        return $this->model::with(['subject', 'upload', 'staff'])
            ->active()
            ->where('session_id', setting('session'))
            ->where('classes_id', $classesId)
            ->where('section_id', $sectionId)
            ->latest()
            ->get();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $row = new $this->model;
            $row->session_id = setting('session');
            $row->classes_id = $request->class;
            $row->section_id = $request->section;
            $row->subject_id = $request->subject;
            $row->staff_id = authStaffId();
            $row->title = $request->title;
            $row->description = $request->description;
            $row->lecture_type = $request->lecture_type ?? LectureType::PDF;
            $row->video_url = $request->video_url;
            $row->status = $request->status ?? 1;
            $row->created_by = Auth::id();

            if ($request->file('document')) {
                $row->upload_id = $this->UploadImageCreate($request->document, 'backend/uploads/lectures');
            }

            $row->save();
            DB::commit();

            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $row = $this->model->findOrFail($id);
            $row->classes_id = $request->class;
            $row->section_id = $request->section;
            $row->subject_id = $request->subject;
            $row->title = $request->title;
            $row->description = $request->description;
            $row->lecture_type = $request->lecture_type ?? $row->lecture_type;
            $row->video_url = $request->video_url;
            $row->status = $request->status ?? 1;

            if ($request->file('document')) {
                $row->upload_id = $this->UploadImageUpdate(
                    $request->document,
                    'backend/uploads/lectures',
                    $row->upload_id
                );
            }

            $row->save();
            DB::commit();

            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();

            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        try {
            $this->model->findOrFail($id)->delete();

            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
