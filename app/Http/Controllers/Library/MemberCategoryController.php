<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Http\Requests\Library\MemberCategory\MemberCategoryStoreRequest;
use App\Http\Requests\Library\MemberCategory\MemberCategoryUpdateRequest;
use App\Repositories\Library\MemberCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class MemberCategoryController extends Controller
{
    private $Repo;

    function __construct(MemberCategoryRepository $Repo)
    {
        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        } 
        $this->Repo                  = $Repo;
    }

    public function index()
    {
        $data['member_category'] = $this->Repo->getAll();
        $data['title'] = ___('settings.member_category');
        return view('backend.library.member-category.index', compact('data'));
    }

    public function create()
    {
        $data['title']       = ___('website.Create member Category');
        return view('backend.library.member-category.create', compact('data'));
    }

    public function store(MemberCategoryStoreRequest $request)
    {
        $result = $this->Repo->store($request);
        if($result['status']){
            return redirect()->route('member-category.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['member_category']      = $this->Repo->show($id);
        $data['title']       = ___('website.Edit member Category');
        return view('backend.library.member-category.edit', compact('data'));
    }

    public function update(MemberCategoryUpdateRequest $request, $id)
    {
        $result = $this->Repo->update($request, $id);
        if($result['status']){
            return redirect()->route('member-category.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        $result = $this->Repo->destroy($id);
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
