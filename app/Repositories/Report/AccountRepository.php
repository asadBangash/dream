<?php

namespace App\Repositories\Report;

use App\Enums\AccountHeadType;
use App\Models\Accounts\Income;
use App\Models\Fees\FeesCollect;
use App\Models\ExaminationResult;
use App\Traits\ReturnFormatTrait;
use App\Models\Fees\FeesAssignChildren;
use App\Interfaces\Report\AccountInterface;
use App\Interfaces\Report\MeritListInterface;
use App\Interfaces\Report\FeesCollectionInterface;
use App\Models\Accounts\Expense;

class AccountRepository implements AccountInterface
{
    use ReturnFormatTrait;

    public function search($request)
    {
        if ($request->type == AccountHeadType::INCOME)
            $result = Income::where('session_id', setting('session'));
        else
            $result = Expense::where('session_id', setting('session'));
        
        if($request->head != "" && $request->type == AccountHeadType::INCOME)
            $result = $result->where('income_head', $request->head);
        if($request->head != "" && $request->type == AccountHeadType::EXPENSE)
            $result = $result->where('expense_head', $request->head);

        if($request->dates != ""){
            $result = $result->whereBetween('date', [
                date('Y-m-d', strtotime(substr($request->dates, 0,10))), // start date
                date('Y-m-d', strtotime(substr($request->dates, 13,23))) // end date
            ]);
        }
        
        $data['sum']    = $result->sum('amount');
        $data['result'] = $result->paginate(10);
        
        return $data;
    }

    public function searchPDF($request)
    {
        if ($request->type == AccountHeadType::INCOME)
            $result = Income::where('session_id', setting('session'));
        else
            $result = Expense::where('session_id', setting('session'));
        
        if($request->head != "" && $request->type == AccountHeadType::INCOME)
            $result = $result->where('income_head', $request->head);
        if($request->head != "" && $request->type == AccountHeadType::EXPENSE)
            $result = $result->where('expense_head', $request->head);

        if($request->dates != ""){
            $result = $result->whereBetween('date', [
                date('Y-m-d', strtotime(substr($request->dates, 0,10))), // start date
                date('Y-m-d', strtotime(substr($request->dates, 13,23))) // end date
            ]);
        }
        
        $data['sum']    = $result->sum('amount');
        $data['result'] = $result->get();
        
        return $data;
    }
}
