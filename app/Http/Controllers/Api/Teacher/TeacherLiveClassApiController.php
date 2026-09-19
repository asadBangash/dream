<?php

namespace App\Http\Controllers\Api\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Gmeet\GmeetRepository;
use App\Http\Resources\Teacher\Api\LiveClassListResource;

class TeacherLiveClassApiController extends Controller
{

    use ApiReturnFormatTrait;

    private $live_repo;

    function __construct(GmeetRepository $live_repo)
    {
        $this->live_repo      = $live_repo;
    }

    public function gmeetLiveClass(){
        try {
            $data             = $this->live_repo->getPaginateClassBySubjectIds(teacherSubjects());
            LiveClassListResource::collection($data);
            return $this->responseWithSuccess('Gmeet Live Class List', $data , 200);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }


    public function gmeetLiveClassStore(Request $request){
        try {
            $validator = Validator::make($request->all(),  [
                'title' => 'required',
                'gmeet_link' => [
                    'required',
                    'regex:/^(https?:\/\/)?(meet\.google\.com\/[a-z0-9\-]+)$/i'
                ],
                'class' => 'required',
                'section' => 'required',
                'subject' => 'required',
                'start' => 'required|date',
                'end' => 'required|date',
            ]);

            if ($validator->fails()) {
                return $this->responseWithError('Validation error', $validator->errors(), 422);
            }

            $data = $this->live_repo->store($request);
            return $this->responseWithSuccess('Gmeet Live Class Store', $data , 200);
        } catch (\Throwable $th) {
            return $this->responseWithError($th->getMessage(), [], 400);
        }
    }
}
