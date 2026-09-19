<?php

namespace App\Repositories\Accounts;

use App\Enums\Settings;
use App\Models\Accounts\Expense;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Interfaces\Accounts\ExpenseInterface;

class ExpenseRepository implements ExpenseInterface
{
    use ReturnFormatTrait;
    use CommonHelperTrait;
    private $expense;

    public function __construct(Expense $expense)
    {
        $this->expense = $expense;
    }

    public function all()
    {
        return $this->expense->active()->where('session_id', setting('session'))->get();
    }

    public function getAll()
    {
        return $this->expense->latest()->where('session_id', setting('session'))->paginate(Settings::PAGINATE);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $expenseStore                   = new $this->expense;
            $expenseStore->session_id       = setting('session'); 
            $expenseStore->name             = $request->name;
            $expenseStore->expense_head     = $request->expense_head;
            $expenseStore->date             = $request->date;
            $expenseStore->amount           = $request->amount;
            $expenseStore->invoice_number   = $request->invoice_number;
            $expenseStore->upload_id        = $this->UploadImageCreate($request->document, 'backend/uploads/expenses');
            $expenseStore->description      = $request->description;
            $expenseStore->save();

            DB::commit();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function show($id)
    {
        return $this->expense->find($id);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $expenseUpdate                   = $this->expense->findOrfail($id);
            $expenseUpdate->session_id       = setting('session'); 
            $expenseUpdate->name             = $request->name;
            $expenseUpdate->expense_head     = $request->expense_head;
            $expenseUpdate->date             = $request->date;
            $expenseUpdate->amount           = $request->amount;
            $expenseUpdate->invoice_number   = $request->invoice_number;
            $expenseUpdate->upload_id        = $this->UploadImageUpdate($request->document, 'backend/uploads/expenses', $expenseUpdate->upload_id);
            $expenseUpdate->description      = $request->description;
            $expenseUpdate->save();

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
            $expenseDestroy = $this->expense->find($id);
            $this->UploadImageDelete($expenseDestroy->upload_id);
            $expenseDestroy->delete();

            DB::commit();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
