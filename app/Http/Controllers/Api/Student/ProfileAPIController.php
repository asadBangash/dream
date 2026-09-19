<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\User;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Models\StudentInfo\Student;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\API\ProfileUpdateRequest;
use App\Http\Resources\Student\StudentProfileResource;

class ProfileAPIController extends Controller
{
    use CommonHelperTrait, ReturnFormatTrait;

    public function profile()
    {
        try {
            if (Auth::user()->role_id == 6) {
                if (!sessionClassStudent()) {
                    return $this->responseWithError(___('alert.user_not_found'));
                }

                $profile = Student::where('id', @sessionClassStudent()->student_id)->first();
            } else {
                $profile = Auth::user();
            }

            $profile = new StudentProfileResource($profile);

            return $this->responseWithSuccess(___('alert.success'), $profile);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), [$th->getMessage()]);
        }
    }

    public function update(ProfileUpdateRequest $request)
    {
        try {
            $user = User::whereHas('student', fn ($q) => $q->where('id', @sessionClassStudent()->student_id))->first();

            if (!$user) {
                return $this->responseWithError(___('alert.User Not Found'));
            }

            DB::transaction(function () use ($request, $user) {
                $user->update([
                    'name'          => $request->first_name . ' ' . $request->last_name,
                    'date_of_birth' => date('Y-m-d', strtotime($request->date_of_birth)),
                    'phone'         => $request->phone,
                    'upload_id'     => $this->UploadImageUpdate($request->image, 'backend/uploads/users', @$user->upload_id)
                ]);

                $user = $user->refresh();

                Student::where('user_id', $user->id)->update([
                    'first_name'    => $request->first_name,
                    'last_name'     => $request->last_name,
                    'mobile'        => $user->phone,
                    'dob'           => $user->date_of_birth,
                    'image_id'      => $user->upload_id
                ]);
            });

            $profile    = StudentProfileResource::collection(
                            Student::query()
                            ->where('id', @sessionClassStudent()->student_id)
                            ->take(1)
                            ->get()
                        );

            $profile    = @$profile[0];

            return $this->responseWithSuccess(___('alert.profile_has_been_updated_successfully'), $profile);

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), [$th->getMessage()]);
        }
    }
}
