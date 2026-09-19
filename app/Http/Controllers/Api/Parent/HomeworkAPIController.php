<?php

namespace App\Http\Controllers\Api\Parent;

use Illuminate\Http\Request;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\Parent\HomeworkResource;
use App\Repositories\ParentPanel\Homework\HomeworkInterface;

class HomeworkAPIController extends Controller
{
    use CommonHelperTrait, ReturnFormatTrait;
    private $repo;

    function __construct(HomeworkInterface $repo)
    { 
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        try {
            if (!sessionClassStudent()) {
                return $this->responseWithError(___('alert.Student not found'));
            }
            $data['homework'] = HomeworkResource::collection($this->repo->index($request));
            return $this->responseWithSuccess(___('alert.success'), $data);
        } catch (\Throwable $th) {dd($th);
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }

    
}
