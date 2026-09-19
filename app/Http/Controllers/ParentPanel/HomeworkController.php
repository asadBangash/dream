<?php

namespace App\Http\Controllers\ParentPanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ParentPanel\Homework\HomeworkInterface;

class HomeworkController extends Controller
{
    private $repo;

    function __construct(HomeworkInterface $repo)
    { 
        $this->repo = $repo;
    }
    public function index(){
        $data = $this->repo->indexParent();
        return view('parent-panel.homework-list', compact('data'));
    }

    public function search(Request $request)
    {
        $data = $this->repo->search($request);
        return view('parent-panel.homework-list', compact('data'));
    }
}
