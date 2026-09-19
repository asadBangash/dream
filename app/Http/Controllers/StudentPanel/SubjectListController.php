<?php

namespace App\Http\Controllers\StudentPanel;

use App\Http\Controllers\Controller;
use App\Repositories\StudentPanel\SubjectListRepository;

class SubjectListController extends Controller
{
    private $repo;

    function __construct( SubjectListRepository $repo)
    { 
        $this->repo = $repo; 
    }
    public function index(){
        $subjectTeacher = $this->repo->index();
        return view('student-panel.subject-list', compact('subjectTeacher'));
    }
}
