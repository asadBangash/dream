<?php

namespace App\Repositories\StudentInfo;

use App\Models\Role;
use App\Models\SiblingFeesDiscount;
use App\Models\User;
use App\Enums\Settings;
use App\Models\Session;
use App\Enums\ApiStatus;
use Illuminate\Support\Str;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Models\StudentInfo\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use App\Models\StudentInfo\SessionClassStudent;
use App\Interfaces\StudentInfo\StudentInterface;

class StudentRepository implements StudentInterface
{
    use ReturnFormatTrait;
    use CommonHelperTrait;

    private $model;

    public function __construct(Student $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->active()->get();
    }

    public function getStudents($request)
    {
        return  SessionClassStudent::query()
            ->where('session_id', setting('session'))
            ->where('classes_id', $request->class)
            ->where('section_id', $request->section)
            ->when(request()->filled('gender'), function ($q) use ($request) {
                $q->whereHas('student', fn($q) => $q->where('gender_id', $request->gender));
            })
            ->with('student')
            ->get();
    }


    public function getPaginateAll()
    {
        return SessionClassStudent::whereHas('student')->where('session_id', setting('session'))->latest()->with('student')->paginate(Settings::PAGINATE);
    }
    public function getSessionStudent($id)
    {
        return SessionClassStudent::where('id', $id)->first();
    }


    public function searchStudents($request)
    {
        $students = SessionClassStudent::query();
        $students = $students->where('session_id', setting('session'));

        if ($request->class != "") {
            $students = $students->where('classes_id', $request->class);
        }
        if ($request->section != "") {
            $students = $students->where('section_id', $request->section);
        }
        if ($request->keyword != "") {
            $students = $students->whereHas('student', function ($query) use ($request) {
                $query->where('admission_no', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('first_name', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('last_name', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('roll_no', 'LIKE', "%{$request->keyword}%")
                    ->orWhere('dob', 'LIKE', "%{$request->keyword}%");
            });
        }

        return $students->paginate(Settings::PAGINATE);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            // if($this->model->count() >= setting('student_limit'))
            if ($this->model->count() >= activeSubscriptionStudentLimit() && env('APP_SAAS'))
                return $this->responseWithError(___('alert.Student limit is over.'), []);

            $role                     = Role::find(6); // student role id 6

            $user                    = new User();
            $user->name              = $request->first_name . ' ' . $request->last_name;
            $user->email             = $request->email  != "" ? $request->email :  NULL;
            $user->phone             = $request->mobile != "" ? $request->mobile :  NULL;
            $user->admission_no      = $request->admission_no;
            $user->password          = $request->password_type == 'default' ? Hash::make('123456') : Hash::make($request->password);
            $user->email_verified_at = now();
            $user->role_id           = $role->id;
            $user->permissions       = $role->permissions;
            $user->date_of_birth     = $request->date_of_birth;
            $user->username          = $request->username;
            $user->upload_id         = $this->UploadImageCreate($request->image, 'backend/uploads/students');
            $user->uuid              = Str::uuid();
            $user->save();

            $row                       = new $this->model;
            $row->user_id              = $user->id;
            $row->first_name           = $request->first_name;
            $row->last_name            = $request->last_name;
            $row->admission_no         = $request->admission_no;
            $row->roll_no              = $request->roll_no != "" ? $request->roll_no :  NULL;
            $row->mobile               = $request->mobile;
            $row->image_id             = $user->upload_id;
            $row->email                = $request->email;
            $row->dob                  = $request->date_of_birth;
            $row->religion_id          = $request->religion != "" ? $request->religion :  NULL;
            $row->gender_id            = $request->gender != "" ? $request->gender :  NULL;
            $row->blood_group_id       = $request->blood != "" ? $request->blood :  NULL;
            $row->admission_date       = $request->admission_date;
            $row->parent_guardian_id   = $request->parent != "" ? $request->parent :  NULL;
            $row->student_category_id  = $request->category != "" ? $request->category :  NULL;

            $row->previous_school = $request->previous_school ?? 0;
            $row->previous_school_info = $request->previous_school_info;
            $row->previous_school_image_id = $this->UploadImageCreate($request->previous_school_image, 'backend/uploads/students');
            $row->place_of_birth = $request->place_of_birth;
            $row->nationality = $request->nationality;
            $row->cpr_no = $request->cpr_no;
            $row->spoken_lang_at_home = $request->spoken_lang_at_home;
            $row->residance_address = $request->residance_address;

            $row->status               = $request->status;
            $row->siblings_discount   = $request->siblings_discount;
            $row->upload_documents     = $this->uploadDocuments($request);
            $row->place_of_birth = $request->place_of_birth;
            $row->nationality = $request->nationality;

            $row->health_status = $request->health_status;
            $row->rank_in_family = !empty($request->rank_in_family) ? $request->rank_in_family : 0;
            $row->siblings = !empty($request->siblings) ? $request->siblings : 0;

            $row->cpr_no = $request->cpr_no;
            $row->spoken_lang_at_home = $request->spoken_lang_at_home;
            $row->residance_address = $request->residance_address;
            $row->department_id = $request->department_id;
            $row->save();

            $session_class                      = new SessionClassStudent();
            $session_class->session_id          = setting('session');
            $session_class->classes_id          = $request->class;
            $session_class->section_id          = $request->section != "" ? $request->section :  NULL;
            $session_class->shift_id            = $request->shift != "" ? $request->shift :  NULL;
            $session_class->student_id          = $row->id;
            $session_class->roll                = $request->roll_no;
            $session_class->save();

            DB::commit();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }




    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $row                      = $this->model->find($id);

            $user                     = User::where('id', $row->user_id)->first();

            $role                     = Role::find($user->role_id);

            $user->name               = $request->first_name . ' ' . $request->last_name;
            $user->email              = $request->email != "" ? $request->email :  NULL;
            $user->phone              = $request->mobile != "" ? $request->mobile :  NULL;
            $user->date_of_birth      = $request->date_of_birth;
            $user->admission_no       = $request->admission_no;
            $user->upload_id          = $this->UploadImageUpdate($request->image, 'backend/uploads/students', $user->upload_id);
            $user->permissions        = $role->permissions;
            $user->username          = $request->username;
            $user->save();

            $row->first_name           = $request->first_name;
            $row->last_name            = $request->last_name;
            $row->admission_no         = $request->admission_no;
            $row->roll_no              = $request->roll_no != "" ? $request->roll_no :  NULL;
            $row->mobile               = $request->mobile;
            $row->image_id             = $user->upload_id;
            $row->email                = $request->email;
            $row->dob                  = $request->date_of_birth;
            $row->religion_id          = $request->religion != "" ? $request->religion :  NULL;
            $row->gender_id            = $request->gender != "" ? $request->gender :  NULL;
            $row->blood_group_id       = $request->blood != "" ? $request->blood :  NULL;
            $row->admission_date       = $request->admission_date;
            $row->parent_guardian_id   = $request->parent != "" ? $request->parent :  NULL;
            $row->student_category_id  = $request->category != "" ? $request->category :  NULL;

            $row->previous_school = $request->previous_school ?? 0;
            $row->previous_school_info = $request->previous_school ? $request->previous_school_info : null;
            $row->previous_school_image_id = $request->previous_school ? $this->UploadImageCreate($request->previous_school_image, 'backend/uploads/students') : null;
            $row->place_of_birth = $request->place_of_birth;
            $row->nationality = $request->nationality;
            $row->cpr_no = $request->cpr_no;
            $row->spoken_lang_at_home = $request->spoken_lang_at_home;
            $row->residance_address = $request->residance_address;

            $row->health_status = $request->health_status;
            $row->rank_in_family = !empty($request->rank_in_family) ? $request->rank_in_family : 0;
            $row->siblings = !empty($request->siblings) ? $request->siblings : 0;

            $row->status               = $request->status;
            $row->upload_documents     = $row->upload_documents ?? $this->uploadDocuments($request, $row->upload_documents);
            $row->department_id        = $request->department_id;
            $row->save();

            $session_class                      = SessionClassStudent::where('session_id', setting('session'))->where('student_id', $row->id)->first();
            $session_class->classes_id          = $request->class;
            $session_class->section_id          = $request->section != "" ? $request->section :  NULL;
            $session_class->shift_id            = $request->shift != "" ? $request->shift :  NULL;
            $session_class->student_id          = $row->id;
            $session_class->roll                = $request->roll_no;
            $session_class->save();

            DB::commit();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $row  = $this->model->find($id);
            $user = User::find($row->user_id);
            if ($user) {
                $this->UploadImageDelete($user->upload_id);
                foreach ($row->upload_documents ?? [] as $doc) {
                    $this->UploadImageDelete($doc['file']);
                }
                $user->delete(); // when user delete auto delete student, session class student table's row
            }
            SessionClassStudent::where('student_id', $row->id)->delete();
            $row->delete();

            DB::commit();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function getSiblingsDiscount($parentId)
    {
        $students =  Student::select('id')
            ->where('parent_guardian_id', $parentId)
            ->get();

        $siblingsCount =  $students->count();
        return SiblingFeesDiscount::where('siblings_number', '<=', $siblingsCount)
            ->orderByDesc('siblings_number')
            ->first();
    }

    public function getStudentsByClass($class)
    {
        return SessionClassStudent::query()
            ->where('session_id', setting('session'))
            ->where('classes_id', $class)
            ->with('student')
            ->get();
    }
}
