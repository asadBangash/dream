<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Http\Requests\Library\Book\BookStoreRequest;
use App\Http\Requests\Library\Book\BookUpdateRequest;
use App\Repositories\Library\BookCategoryRepository;
use App\Repositories\Library\BookRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class BookController extends Controller
{
    private $Repo, $categoryRepo;

    function __construct(BookRepository $Repo, BookCategoryRepository $categoryRepo)
    {
        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        } 
        $this->Repo                  = $Repo;
        $this->categoryRepo  = $categoryRepo;
    }

    public function index()
    {
        $data['book'] = $this->Repo->getAll();
        $data['title'] = ___('settings.Book');
        return view('backend.library.book.index', compact('data'));
    }

    public function indexStudent()
    {
        $data['book'] = $this->Repo->getAll();
        $data['title'] = ___('settings.Book');
        return view('student-panel.books', compact('data'));
    }
  
    public function indexParent()
    {
        $data['book'] = $this->Repo->getAll();
        $data['title'] = ___('settings.Book');
        return view('parent-panel.books', compact('data'));
    }

    public function create()
    {
        $data['title']       = ___('website.Create book');
        $data['categories']  = $this->categoryRepo->all();
        return view('backend.library.book.create', compact('data'));
    }

    public function store(BookStoreRequest $request)
    {
        $result = $this->Repo->store($request);
        if($result['status']){
            return redirect()->route('book.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['book']        = $this->Repo->show($id);
        $data['title']       = ___('website.Edit book');
        $data['categories']  = $this->categoryRepo->all();
        return view('backend.library.book.edit', compact('data'));
    }

    public function update(BookUpdateRequest $request, $id)
    {
        $result = $this->Repo->update($request, $id);
        if($result['status']){
            return redirect()->route('book.index')->with('success', $result['message']);
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
