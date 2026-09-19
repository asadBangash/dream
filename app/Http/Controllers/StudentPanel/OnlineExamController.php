<?php

namespace App\Http\Controllers\StudentPanel;

use App\Http\Controllers\Controller;
use App\Repositories\StudentPanel\OnlineExaminationRepository;
use Illuminate\Http\Request;

class OnlineExamController extends Controller
{
    private $repo;

    function __construct(
        OnlineExaminationRepository $repo, 
    ) 
    { 
        $this->repo = $repo;
    }

    public function index()
    {
        $data = $this->repo->index();
        return view('student-panel.online-exam-list', compact('data'));
    }
    public function view($id)
    {
        $data = $this->repo->view($id);
        return view('student-panel.online-exam-view', compact('data'));
    }
    public function resultView($id)
    {
        $data = $this->repo->resultView($id);
        return view('student-panel.online-exam-result-view', compact('data'));
    }
    public function answerSubmit(Request $request)
    {
        $result = $this->repo->answerSubmit($request);
        if($result['status']){
            return redirect()->route('student-panel-online-examination.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }
}
