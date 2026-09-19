<?php

namespace App\Http\Controllers\ParentPanel;

use App\Http\Controllers\Controller;
use App\Repositories\ParentPanel\AttendanceRepository;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    private $repo;

    function __construct(  AttendanceRepository $repo) 
    { 
        $this->repo = $repo;
    }

    public function index()
    {
        $data['title']              = ___('common.Attendance');
        
        $data                       = $this->repo->index();
        $data['results']            = [];
        return view('parent-panel.attendance', compact('data'));
    }

    public function search(Request $request)
    {
        $data                 = $this->repo->search($request);
        $data['title']        = ___('common.Attendance');
        $data['request']      = $request;
        return view('parent-panel.attendance', compact('data'));
    }
}
