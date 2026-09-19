<?php

namespace App\Repositories;

use App\Enums\AttendanceType;
use App\Interfaces\DashboardInterface;
use App\Models\Academic\Classes;
use App\Models\Academic\ClassSetup;
use App\Models\Accounts\Expense;
use App\Models\Accounts\Income;
use App\Models\Attendance\Attendance;
use App\Models\Event;
use App\Models\Fees\FeesCollect;
use App\Models\Role;
use App\Models\Session;
use App\Models\Staff\Staff;
use App\Models\StudentInfo\ParentGuardian;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;

class DashboardRepository implements DashboardInterface
{

    public function index()
    {
        $data['student'] = SessionClassStudent::where('session_id', setting('session'))->count();
        $data['parent']  = ParentGuardian::count();
        $data['teacher'] = Staff::where('role_id',5)->count();
        $data['session'] = Session::count();

        $data['events']  = Event::where('session_id', setting('session'))->active()->where('date', '>=', date('Y-m-d'))->orderBy('date')->take(5)->get();

        $data['income']  = Income::where('session_id', setting('session'))->sum('amount');
        $data['expense'] = Expense::where('session_id', setting('session'))->sum('amount');
        $data['balance'] = $data['income'] - $data['expense'];
        return $data;
    }

    public function feesCollectionYearly() {
        $data = [];
        for($i = 1; $i <= 12; $i++) {
            $data[] = FeesCollect::where('session_id', setting('session'))->whereMonth('date', $i)->sum('amount');
        }
        return $data;
    }

    public function revenueYearly() {
        $data['income']  = [];
        $data['expense'] = [];
        $data['revenue'] = [];

        $n = 0;
        for($i = 1; $i <= date('m'); $i++) {
            $data['income'][]  = Income::where('session_id', setting('session'))->whereMonth('date', $i)->sum('amount');
            $data['expense'][] = Expense::where('session_id', setting('session'))->whereMonth('date', $i)->sum('amount');
            $data['revenue'][] = $data['income'][$n] - $data['expense'][$n];
            $n++;
        }
        return $data;
    }

    public function feesCollection() {
        for ($i = 1; $i <=  date('t'); $i++) {
            $data['collection'][] = FeesCollect::where('session_id', setting('session'))->whereMonth('date', date('m'))->whereDay('date', $i)->sum('amount');
            $data['dates'][]      = str_pad($i, 2, '0', STR_PAD_LEFT);
        }
        return response()->json($data, 200);
    }

    public function incomeExpense() {
        for ($i = 1; $i <=  date('t'); $i++) {
            $data['incomes'][]  = Income::where('session_id', setting('session'))->whereMonth('date', date('m'))->whereDay('date', $i)->sum('amount');
            $data['expenses'][] = Expense::where('session_id', setting('session'))->whereMonth('date', date('m'))->whereDay('date', $i)->sum('amount');
            $data['dates'][]    = str_pad($i, 2, '0', STR_PAD_LEFT);
        }
        return response()->json($data, 200);
    }

    public function attendance() {
        $items = ClassSetup::active()->where('session_id', setting('session'))->get();

        $data['classes'] = [];
        $data['present'] = [];
        $data['absent']  = [];

        $data['classes'] = [];
        foreach ($items as $key => $value) {
            $data['classes'][] = $value->class->name;
            $data['present'][] = Attendance::where('session_id', setting('session'))
                                ->where('classes_id', $value->classes_id)
                                ->whereDay('date', date('d'))
                                ->whereIn('attendance', [AttendanceType::PRESENT, AttendanceType::LATE, AttendanceType::HALFDAY])
                                ->count();
            $data['absent'][]  = Attendance::where('session_id', setting('session'))
                                ->where('classes_id', $value->classes_id)
                                ->whereDay('date', date('d'))
                                ->where('attendance', AttendanceType::ABSENT)
                                ->count();
        }
        return $data;
    }

    public function eventsCurrentMonth() {
        $events = Event::where('session_id', setting('session'))->active()->whereMonth('date', date('m'))->orderBy('date')->get();
        $data = [];
        foreach ($events as $key => $value) {
            $data[] = [
                'title' => $value->title,
                'start' => $value->date.'T'.$value->start_time,
                'end'   => $value->date.'T'.$value->end_time,
            ];
        }
        return response()->json($data, 200);
    }

}
