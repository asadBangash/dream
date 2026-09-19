<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Http\Requests\Library\BookCategory\BookCategoryStoreRequest;
use App\Http\Requests\Library\BookCategory\BookCategoryUpdateRequest;
use App\Repositories\Library\BookCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class BookCategoryController extends Controller
{
    private $Repo;

    function __construct(BookCategoryRepository $Repo)
    {
        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        } 
        $this->Repo                  = $Repo;
    }

    public function index()
    {
        $data['book_category'] = $this->Repo->getAll();
        $data['title'] = ___('settings.book_category');
        return view('backend.library.book-category.index', compact('data'));
    }

    public function create()
    {
        $data['title']       = ___('website.Create book Category');
        return view('backend.library.book-category.create', compact('data'));
    }

    public function store(BookCategoryStoreRequest $request)
    {
        $result = $this->Repo->store($request);
        if($result['status']){
            return redirect()->route('book-category.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['book_category']      = $this->Repo->show($id);
        $data['title']       = ___('website.Edit book Category');
        return view('backend.library.book-category.edit', compact('data'));
    }

    public function update(BookCategoryUpdateRequest $request, $id)
    {
        $result = $this->Repo->update($request, $id);
        if($result['status']){
            return redirect()->route('book-category.index')->with('success', $result['message']);
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
