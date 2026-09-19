<?php

namespace App\Repositories\ParentPanel;

use App\Enums\Settings;
use App\Models\StudentInfo\Student;
use Illuminate\Support\Facades\Auth;
use App\Models\Fees\FeesAssignChildren;
use App\Models\StudentInfo\ParentGuardian;
use App\Interfaces\ParentPanel\FeesInterface;

class FeesRepository implements FeesInterface
{
    public function index($request)
    {
        try {
            $parent                 = ParentGuardian::where('user_id', Auth::user()->id)->first();
            $data['students']       = Student::where('parent_guardian_id', $parent->id)->get();
            $data['fees_assigned']  = [];

            if ($request->filled('student_id')) {
                $data['fees_assigned']  = FeesAssignChildren::withCount('feesCollect')->with('feesCollect')
                                        ->where('student_id', $request->student_id)
                                        ->whereHas('feesAssign', function ($query) {
                                            return $query->where('session_id', setting('session'));
                                        })
                                        ->paginate(Settings::PAGINATE);
            }

            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
