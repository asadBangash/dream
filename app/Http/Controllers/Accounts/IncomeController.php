<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounts\Income\IncomeStoreRequest;
use App\Http\Requests\Accounts\Income\IncomeUpdateRequest;
use App\Repositories\Accounts\AccountHeadRepository;
use App\Repositories\Accounts\IncomeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class IncomeController extends Controller
{
    private $incomeRepo, $accountHeadRepository;

    function __construct(IncomeRepository $incomeRepo, AccountHeadRepository $accountHeadRepository)
    {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        }
        $this->incomeRepo                  = $incomeRepo;
        $this->accountHeadRepository       = $accountHeadRepository;
    }

    public function index()
    {
        $data['income'] = $this->incomeRepo->getAll();
        $data['title'] = ___('account.income');
        return view('backend.accounts.income.index', compact('data'));
    }

    public function create()
    {
        $data['title']       = ___('account.create_income');
        $data['heads']       = $this->accountHeadRepository->getIncomeHeads();
        return view('backend.accounts.income.create', compact('data'));
    }

    public function store(IncomeStoreRequest $request)
    {
        $result = $this->incomeRepo->store($request);
        if($result['status']){
            return redirect()->route('income.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['heads']       = $this->accountHeadRepository->getIncomeHeads();
        $data['income']      = $this->incomeRepo->show($id);
        $data['title']       = ___('account.edit_income');
        return view('backend.accounts.income.edit', compact('data'));
    }

    public function update(IncomeUpdateRequest $request, $id)
    {
        $result = $this->incomeRepo->update($request, $id);
        if($result['status']){
            return redirect()->route('income.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        $result = $this->incomeRepo->destroy($id);
        if($result['status']):
            $success[0] = $result['message'];
            $success[1] = 'success';
            $success[2] = ___('alert.deleted');
            $success[3] = ___('alert.OK');
            return response()->json($success);
        else:
            $success[0] = $result['message'];
            $success[1] = 'error';
            $success[2] = ___('alert.oops');
            return response()->json($success);
        endif;
    }
}
