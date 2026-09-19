<?php

namespace App\Http\Controllers\Api\Student;

use Illuminate\Http\Request;
use App\Traits\ReturnFormatTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\Student\BookResource;
use App\Repositories\Library\BookRepository;

class BookAPIController extends Controller
{
    use ReturnFormatTrait;

    private $Repo, $categoryRepo;

    function __construct(BookRepository $Repo)
    {
        $this->Repo                  = $Repo;
    }

    public function index()
    {
        try {
            if (!sessionClassStudent()) {
                return $this->responseWithError(___('alert.Student not found'));
            }
            $data['books'] = BookResource::collection($this->Repo->getAll());
            return $this->responseWithSuccess(___('alert.success'), $data);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }

    }
}
