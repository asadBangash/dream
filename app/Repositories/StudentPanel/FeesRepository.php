<?php

namespace App\Repositories\StudentPanel;

use App\Enums\Settings;
use App\Interfaces\StudentPanel\FeesInterface;
use App\Models\Fees\FeesAssignChildren;
use App\Models\StudentInfo\Student;
use Illuminate\Support\Facades\Auth;

class FeesRepository implements FeesInterface
{
    public function index()
    {
        try {
            $data['student'] = Student::where('user_id', Auth::user()->id)->first();

            $data['fees_assigned'] = FeesAssignChildren::withCount('feesCollect')->with('feesCollect')->where('student_id', $data['student']->id)
            ->whereHas('feesAssign', function ($query) {
                return $query->where('session_id', setting('session'));
            })
            ->paginate(Settings::PAGINATE);

            return $data;

        } catch (\Throwable $th) {
            return false;
        }
    }
}
