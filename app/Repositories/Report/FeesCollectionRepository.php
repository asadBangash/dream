<?php

namespace App\Repositories\Report;

use App\Interfaces\Report\FeesCollectionInterface;
use App\Models\ExaminationResult;
use App\Traits\ReturnFormatTrait;
use App\Interfaces\Report\MeritListInterface;
use App\Models\Fees\FeesAssignChildren;
use App\Models\Fees\FeesCollect;

class FeesCollectionRepository implements FeesCollectionInterface
{
    use ReturnFormatTrait;

    public function search($request)
    {
        // dd($request->all());
        $groups = FeesAssignChildren::withCount('feesCollect')->with('feesCollect')->having('fees_collect_count', '=', 1);

        $groups = $groups->whereHas('feesAssign', function ($query) use ($request) {
            return $query->where('session_id', setting('session'));
        });

        if ($request->class != "") {
            $groups = $groups->whereHas('student', function ($query) use ($request) {
                $query->whereHas('sessionStudentDetails', function ($query) use ($request) {
                    $query->where('classes_id', $request->class);
                });
            });
        }

        if ($request->section != "") {
            $groups = $groups->whereHas('student', function ($query) use ($request) {
                $query->whereHas('sessionStudentDetails', function ($query) use ($request) {
                    $query->where('section_id', $request->section);
                });
            });
        }

        if ($request->dates != "") {
            $groups = $groups->whereHas('feesCollect', function ($query) use ($request) {
                return $query->whereBetween('date', [
                    date('Y-m-d', strtotime(substr($request->dates, 0, 10))), // start date
                    date('Y-m-d', strtotime(substr($request->dates, 13, 23))) // end date
                ]);
            });
        }

        return $groups->paginate(10);
    }

    public function searchPDF($request)
    {
        // dd($request->all());
        $groups = FeesAssignChildren::withCount('feesCollect')->with('feesCollect')->having('fees_collect_count', '=', 1);

        $groups = $groups->whereHas('feesAssign', function ($query) use ($request) {
            return $query->where('session_id', setting('session'));
        });

        if ($request->class != "") {
            $groups = $groups->whereHas('student', function ($query) use ($request) {
                $query->whereHas('sessionStudentDetails', function ($query) use ($request) {
                    $query->where('classes_id', $request->class);
                });
            });
        }

        if ($request->section != "") {
            $groups = $groups->whereHas('student', function ($query) use ($request) {
                $query->whereHas('sessionStudentDetails', function ($query) use ($request) {
                    $query->where('section_id', $request->section);
                });
            });
        }

        if ($request->dates != "") {
            $groups = $groups->whereHas('feesCollect', function ($query) use ($request) {
                return $query->whereBetween('date', [
                    date('Y-m-d', strtotime(substr($request->dates, 0, 10))), // start date
                    date('Y-m-d', strtotime(substr($request->dates, 13, 23))) // end date
                ]);
            });
        }

        return $groups->get();
    }
}
