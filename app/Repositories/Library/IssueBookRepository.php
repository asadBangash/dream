<?php

namespace App\Repositories\Library;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\Settings;
use App\Models\Library\Book;
use App\Models\Library\Member;
use App\Models\Library\IssueBook;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Enums\IssueBook as EnumsIssueBook;
use App\Interfaces\Library\IssueBookInterface;

class IssueBookRepository implements IssueBookInterface{

    use ReturnFormatTrait;
    use CommonHelperTrait;
    private $model;

    public function __construct(IssueBook $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->active()->get();
    }

    public function getAll()
    {
        return $this->model->orderBy('id', 'desc')->paginate(Settings::PAGINATE);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $bookQuantity = Book::find($request->book)?->quantity ?? 0;
            $totalIssued = IssueBook::where(['book_id' => $request->book, 'status' => EnumsIssueBook::ISSUED])->count();
            
            if ($totalIssued >= $bookQuantity) {
                return $this->responseWithError(___('alert.this_book_all_piece_has_been_issued'), []);
            }

            $row                   = new $this->model;
            $row->book_id          = $request->book;
            $row->user_id          = $request->member;
            $row->issue_date       = $request->issue_date;
            $row->return_date      = $request->return_date;
            $row->phone            = $request->phone;
            $row->status           = EnumsIssueBook::ISSUED;
            $row->description      = $request->description;
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
        return $this->model->find($id);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $bookQuantity = Book::find($request->book)?->quantity ?? 0;
            $totalIssued = IssueBook::where(['book_id' => $request->book, 'status' => EnumsIssueBook::ISSUED])->count();
            
            if (($totalIssued - 1) >= $bookQuantity) {
                return $this->responseWithError(___('alert.this_book_all_piece_has_been_issued'), []);
            }

            $row                   = $this->model->findOrfail($id);
            $row->book_id          = $request->book;
            $row->user_id          = $request->member;
            $row->issue_date       = $request->issue_date;
            $row->return_date      = $request->return_date;
            $row->phone            = $request->phone;
            $row->description      = $request->description;
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
        DB::beginTransaction();
        try {
            $row = $this->model->find($id);
            $row->delete();

            DB::commit();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }


    public function getMember($request)
    {
        $row = Member::query();

        $row = $row->whereHas('user', function ($query) use ($request) {
            return $query->where('name', 'like', '%' . $request->text . '%');
        });

        return $row->with('user')->get()->take(10);
    }
    public function getBooks($request)
    {
        return Book::where('name', 'like', '%' . $request->text . '%')->pluck('name','id')->take(10)->toArray();
    }

    
    public function getUser($id)
    {
        return User::where('id', $id)->pluck('name')->first();
    }
    public function getBook($id)
    {
        return Book::where('id', $id)->pluck('name')->first();
    }

    public function return($id)
    {
        DB::beginTransaction();
        try {
            $row                   = $this->model->findOrfail($id);
            $row->status           = EnumsIssueBook::RETURN;
            $row->save();

            DB::commit();
            return $this->responseWithSuccess(___('library.returned_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function searchResult($request)
    {
        return  $this->model::query()
                ->where(function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->whereHas('user', function ($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->keyword . '%');
                        })->orWhereHas('book', function ($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->keyword . '%');
                        });
                    })
                    ->orWhere('phone', 'like', '%' . $request->keyword . '%');

                    if (strtotime($request->keyword)) {
                        $query->orWhere('issue_date', Carbon::parse($request->keyword)->format('Y-m-d'))
                        ->orWhere('return_date', Carbon::parse($request->keyword)->format('Y-m-d'));
                    }

                    if (strtolower($request->keyword) == 'return') {
                        $query->orWhere('status', EnumsIssueBook::RETURN);
                    }

                    if (strtolower($request->keyword) == 'issued') {
                        $query->orWhere('status', EnumsIssueBook::ISSUED);
                    }
                })
                ->paginate(Settings::PAGINATE);
    }

    public function issueBook()
    {
        return $this->model->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(Settings::PAGINATE);
    }
}
