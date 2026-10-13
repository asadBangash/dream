<?php

namespace App\Repositories;

use App\Enums\Settings;
use App\Enums\TalentTestApplicationStatus;
use App\Models\WebsiteSetup\TalentTestApplication;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Str;

class TalentTestApplicationRepository
{
    use ReturnFormatTrait;

    public function __construct(
        protected TalentTestApplication $model
    ) {}

    public function paginate()
    {
        return $this->model->newQuery()->latest('id')->paginate(Settings::PAGINATE);
    }

    public function search($request)
    {
        $query = $this->model->newQuery();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('student_name', 'like', "%{$keyword}%")
                    ->orWhere('father_name', 'like', "%{$keyword}%")
                    ->orWhere('contact_number', 'like', "%{$keyword}%")
                    ->orWhere('reference_no', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('status') && $request->status !== '') {
            $query->where('status', (int) $request->status);
        }

        return $query->latest('id')->paginate(Settings::PAGINATE);
    }

    public function find($id)
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function storeFromFrontend($request)
    {
        try {
            $row = new $this->model;
            $row->reference_no = strtoupper(Str::random(8));
            $row->student_name = $request->student_name;
            $row->father_name = $request->father_name;
            $row->dob = $request->dob;
            $row->gender = (int) $request->gender;
            $row->contact_number = $request->contact_number;
            $row->guardian_contact = $request->guardian_contact;
            $row->home_address = $request->home_address;
            $row->current_class = $request->current_class;
            $row->school_name = $request->school_name;
            $row->last_exam_marks = $request->last_exam_marks;
            $row->total_marks = $request->total_marks;
            $row->status = TalentTestApplicationStatus::PENDING;
            $row->save();

            return $row;
        } catch (\Throwable $th) {
            report($th);

            return null;
        }
    }

    public function updateStatus($request, $id)
    {
        try {
            $row = $this->find($id);
            $row->status = (int) $request->status;
            $row->admin_remarks = $request->admin_remarks;
            $row->save();

            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        try {
            $this->find($id)->delete();

            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
