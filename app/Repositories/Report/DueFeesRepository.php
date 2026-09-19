<?php

namespace App\Repositories\Report;

use App\Models\Fees\FeesMaster;
use App\Models\ExaminationResult;
use App\Traits\ReturnFormatTrait;
use App\Models\Fees\FeesAssignChildren;
use App\Interfaces\Report\DueFeesInterface;
use App\Interfaces\Report\MeritListInterface;

class DueFeesRepository implements DueFeesInterface
{
    use ReturnFormatTrait;


    public function assignedFeesTypes() 
    {
        $fees_masters = FeesAssignChildren::query();

        $fees_masters = $fees_masters->whereHas('feesAssign', function ($query) {
            return $query->where('session_id', setting('session'));
        });

        $fees_masters = $fees_masters->distinct()->pluck('fees_master_id');

        $fees_masters = FeesMaster::whereIn('id', $fees_masters)->get();

        return $fees_masters;

        // $groups = $groups->get();



    }

    public function search($request)
    {
        $groups = FeesAssignChildren::withCount('feesCollect')->with('feesCollect')->having('fees_collect_count', '=', 0);

        $groups = $groups->whereHas('feesMaster', function ($query) use($request) {
            return $query->where('due_date', '<', date('Y-m-d'));
        });

        if ($request->fees_master != '') {

            $groups = $groups->where('fees_master_id', $request->fees_master);
  
        }

        $groups = $groups->whereHas('feesAssign', function ($query) use($request) {
            return $query->where('session_id', setting('session'));
        });

        if($request->class != "") {
            $groups = $groups->whereHas('student', function ($query) use($request) {
                $query->whereHas('sessionStudentDetails', function ($query) use($request) {
                    $query->where('classes_id', $request->class);
                });
            });
        }

        if($request->section != "") {
            $groups = $groups->whereHas('student', function ($query) use($request) {
                $query->whereHas('sessionStudentDetails', function ($query) use($request) {
                    $query->where('section_id', $request->section);
                });
            });
        }
        
        return $groups->paginate(10);
    }

    public function searchPDF($request)
    {
        $groups = FeesAssignChildren::withCount('feesCollect')->with('feesCollect')->having('fees_collect_count', '=', 0);

        $groups = $groups->whereHas('feesMaster', function ($query) use($request) {
            return $query->where('due_date', '<', date('Y-m-d'));
        });

        if ($request->fees_master != '') {

            $groups = $groups->where('fees_master_id', $request->fees_master);
  
        }

        $groups = $groups->whereHas('feesAssign', function ($query) use($request) {
            return $query->where('session_id', setting('session'));
        });

        if($request->class != "") {
            $groups = $groups->whereHas('student', function ($query) use($request) {
                $query->whereHas('sessionStudentDetails', function ($query) use($request) {
                    $query->where('classes_id', $request->class);
                });
            });
        }

        if($request->section != "") {
            $groups = $groups->whereHas('student', function ($query) use($request) {
                $query->whereHas('sessionStudentDetails', function ($query) use($request) {
                    $query->where('section_id', $request->section);
                });
            });
        }
        
        return $groups->get();
    }
}
