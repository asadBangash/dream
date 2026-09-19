<?php

namespace App\Http\Controllers\StudentPanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentPanel\HomeworkSubmit;
use App\Repositories\StudentPanel\Homework\HomeworkInterface;

class HomeworkController extends Controller
{
    private $repo;

    function __construct(HomeworkInterface $repo)
    { 
        $this->repo = $repo;
    }
    
    public function index()
    {
        $data['homeworks'] = $this->repo->index();
        $data['title']     = 'homework';

        return view('student-panel.homeworks', compact('data'));
    }

    public function submit(HomeworkSubmit $request)
    {
        $result = $this->repo->submit($request);
        return response()->json($result);
    }
}
