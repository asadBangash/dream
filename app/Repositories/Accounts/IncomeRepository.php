<?php

namespace App\Repositories\Accounts;

use App\Enums\Settings;
use App\Models\Accounts\Income;
use App\Traits\CommonHelperTrait;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Interfaces\Accounts\IncomeInterface;

class IncomeRepository implements IncomeInterface
{
    use ReturnFormatTrait;
    use CommonHelperTrait;
    private $income;

    public function __construct(Income $income)
    {
        $this->income = $income;
    }

    public function all()
    {
        return $this->income->active()->where('session_id', setting('session'))->get();
    }

    public function getAll()
    {
        return $this->income->latest()->where('session_id', setting('session'))->paginate(Settings::PAGINATE);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $incomeStore                   = new $this->income;
            $incomeStore->session_id       = setting('session'); 
            $incomeStore->name             = $request->name;
            $incomeStore->income_head      = $request->income_head;
            $incomeStore->date             = $request->date;
            $incomeStore->amount           = $request->amount;
            $incomeStore->invoice_number   = $request->invoice_number;
            $incomeStore->upload_id        = $this->UploadImageCreate($request->document, 'backend/uploads/incomes');
            $incomeStore->description      = $request->description;
            $incomeStore->save();

            DB::commit();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function show($id)
    {
        return $this->income->find($id);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $incomeUpdate                   = $this->income->findOrfail($id);
            $incomeUpdate->session_id       = setting('session'); 
            $incomeUpdate->name             = $request->name;
            $incomeUpdate->income_head      = $request->income_head;
            $incomeUpdate->date             = $request->date;
            $incomeUpdate->amount           = $request->amount;
            $incomeUpdate->invoice_number   = $request->invoice_number;
            $incomeUpdate->upload_id        = $this->UploadImageUpdate($request->document, 'backend/uploads/incomes', $incomeUpdate->upload_id);
            $incomeUpdate->description      = $request->description;
            $incomeUpdate->save();

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
            $incomeDestroy = $this->income->find($id);
            $this->UploadImageDelete($incomeDestroy->upload_id);
            $incomeDestroy->delete();

            DB::commit();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
