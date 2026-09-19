<?php

namespace App\Http\Controllers\Api\Student;

use Illuminate\Http\Request;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Student\HomeworkResource;
use App\Repositories\StudentPanel\Homework\HomeworkInterface;

class HomeworkAPIController extends Controller
{
    use CommonHelperTrait, ReturnFormatTrait;

    private $repo;

    function __construct(HomeworkInterface $repo)
    { 
        $this->repo = $repo;
    }

    public function index()
    {
        try {
            if (!sessionClassStudent()) {
                return $this->responseWithError(___('alert.Student not found'));
            }
            $data['homework'] = HomeworkResource::collection($this->repo->index());
            return $this->responseWithSuccess(___('alert.success'), $data);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }

    public function submit(Request $request)
    {
        try {
            if (!sessionClassStudent()) {
                return $this->responseWithError(___('alert.Student not found'));
            }
            $data = Validator::make($request->all(),[
                'homework'     => 'required',
            ]);
            if ($data->fails()) {
                return $this->responseWithError(___('alert.validation_error'), $data->errors());
            }
            $result = $this->repo->submit($request);
            return $this->responseWithSuccess(___('alert.submitted_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }

    
}
