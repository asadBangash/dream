<?php

namespace App\Http\Controllers\Api\Student;

use Illuminate\Http\Request;
use App\Models\Library\IssueBook;
use App\Traits\ReturnFormatTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Library\IssueBookRepository;
use App\Http\Resources\Student\IssuedBookResource;
use App\Enums\Settings;

class IssuedBookAPIController extends Controller
{
    use ReturnFormatTrait;

    private $Repo;

    function __construct(IssueBookRepository $Repo)
    {        
        $this->Repo                  = $Repo;
    }

    public function index()
    {
        try {
            if (!sessionClassStudent()) {
                return $this->responseWithError(___('alert.Student not found'));
            }
            $issue_book = IssueBook::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(Settings::PAGINATE);
            $data['issue_books'] = IssuedBookResource::collection($issue_book);
            return $this->responseWithSuccess(___('alert.success'), $data);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }

    }

}
