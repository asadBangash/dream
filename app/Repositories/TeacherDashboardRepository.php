<?php

namespace App\Repositories;

use App\Models\Academic\SubjectAssignChildren;
use App\Models\Event;
use App\Models\Homework;
use App\Models\Staff\Staff;
use App\Models\TeacherLecture;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class TeacherDashboardRepository
{
    public function index(): array
    {
        $staff = Staff::withoutGlobalScopes()->with(['upload', 'designation', 'department'])
            ->where('user_id', Auth::id())
            ->first();

        $subjectIds = teacherSubjects();
        $staffId = authStaffId();

        $assignments = SubjectAssignChildren::with(['subject', 'subjectAssign.class', 'subjectAssign.section'])
            ->when($staffId, fn ($q) => $q->where('staff_id', $staffId))
            ->whereHas('subjectAssign', fn ($q) => $q->where('session_id', setting('session')))
            ->get();

        $classes = $assignments->map(fn ($row) => $row->subjectAssign?->class?->name)
            ->filter()
            ->unique()
            ->values();

        $today = date('Y-m-d');

        return [
            'staff'            => $staff,
            'assignments'      => $assignments,
            'classNames'       => $classes,
            'subjectCount'     => count(array_unique($subjectIds)),
            'homeworkCount'    => Homework::where('session_id', setting('session'))
                ->whereIn('subject_id', $subjectIds ?: [0])
                ->count(),
            'lectureCount'     => Schema::hasTable('teacher_lectures')
                ? TeacherLecture::where('session_id', setting('session'))
                    ->when($staffId, fn ($q) => $q->where('staff_id', $staffId))
                    ->count()
                : 0,
            'events'           => Event::query()
                ->where('session_id', setting('session'))
                ->active()
                ->where('date', '>=', $today)
                ->orderBy('date')
                ->take(5)
                ->get(),
        ];
    }
}
