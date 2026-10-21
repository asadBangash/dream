<?php

namespace App\Http\Controllers\Backend;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Repositories\TeacherDashboardRepository;
use Illuminate\Support\Facades\Auth;

class TeacherDashboardController extends Controller
{
    public function __construct(private TeacherDashboardRepository $repo) {}

    public function index()
    {
        if (Auth::user()->role_id != RoleEnum::TEACHER) {
            return redirect()->route('dashboard');
        }

        $data = $this->repo->index();
        $data['title'] = 'Teacher Dashboard';

        return view('backend.teacher-dashboard', compact('data'));
    }
}
