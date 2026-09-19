<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounts\Head\AccountHeadStoreRequest;
use App\Http\Requests\Accounts\Head\AccountHeadUpdateRequest;
use App\Repositories\Accounts\AccountHeadRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AccountHeadController extends Controller
{
    private $headRepo;

    function __construct(AccountHeadRepository $headRepo)
    {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        } 
        $this->headRepo       = $headRepo; 
    }

    public function index()
    {
        $data['account_head'] = $this->headRepo->getAll();
        $data['title'] = ___('account.account_head');
        return view('backend.accounts.head.index', compact('data'));
    }

    public function create()
    {
        $data['title']       = ___('account.create_account_head');
        return view('backend.accounts.head.create', compact('data'));
    }

    public function store(AccountHeadStoreRequest $request)
    {
        $result = $this->headRepo->store($request);
        if($result['status']){
            return redirect()->route('account_head.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['account_head']        = $this->headRepo->show($id);
        $data['title']       = ___('account.edit_account_head');
        return view('backend.accounts.head.edit', compact('data'));
    }

    public function update(AccountHeadUpdateRequest $request, $id)
    {
        $result = $this->headRepo->update($request, $id);
        if($result['status']){
            return redirect()->route('account_head.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        $result = $this->headRepo->destroy($id);
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
