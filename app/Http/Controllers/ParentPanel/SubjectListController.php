<?php

namespace App\Http\Controllers\ParentPanel;

use App\Http\Controllers\Controller;
use App\Repositories\ParentPanel\SubjectListRepository;
use Illuminate\Http\Request;

class SubjectListController extends Controller
{
    private $repo;

    function __construct( SubjectListRepository $repo)
    { 
        $this->repo = $repo; 
    }
    public function index(){
        $data = $this->repo->index();
        return view('parent-panel.subject-list', compact('data'));
    }

    public function search(Request $request)
    {
        $data = $this->repo->search($request);
        return view('parent-panel.subject-list', compact('data'));
    }
}
