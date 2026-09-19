<?php

namespace App\Http\Controllers\Fees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Fees\Collect\FeesCollectStoreRequest;
use App\Http\Requests\Fees\Collect\FeesCollectUpdateRequest;
use App\Interfaces\Fees\FeesCollectInterface;
use App\Models\EarlyPaymentDiscount;
use App\Models\Setting;
use App\Repositories\Academic\ClassesRepository;
use App\Repositories\Academic\SectionRepository;
use App\Repositories\Fees\FeesMasterRepository;
use App\Repositories\StudentInfo\StudentRepository;
use Illuminate\Http\Request;

class FeesCollectController extends Controller
{
    private $repo;
    private $classRepo;
    private $sectionRepo;
    private $studentRepo;
    private $feesMasterRepo;

    function __construct(
        FeesCollectInterface   $repo,
        ClassesRepository      $classRepo,
        SectionRepository      $sectionRepo,
        StudentRepository      $studentRepo,
        FeesMasterRepository   $feesMasterRepo,
        )
    {
        $this->repo              = $repo;
        $this->classRepo         = $classRepo;
        $this->sectionRepo       = $sectionRepo;
        $this->studentRepo       = $studentRepo;
        $this->feesMasterRepo    = $feesMasterRepo;
    }

    public function index()
    {
        $data['title']              = ___('fees.fees_collect');
        $data['fees_collects']      = $this->repo->getPaginateAll();
        $data['classes']            = $this->classRepo->assignedAll();
        $data['sections']           = $this->sectionRepo->all();

        return view('backend.fees.collect.index', compact('data'));
    }

    public function create()
    {
        $data['title']        = ___('fees.fees_collect');
        return view('backend.fees.collect.create', compact('data'));

    }

    public function collect($id)
    { // student id
        $data['title']          = ___('fees.fees_collect');
        $data['student']        = $this->studentRepo->show($id);
        $data['fees_assigned']  = $this->repo->feesAssigned($id);
        return view('backend.fees.collect.collect', compact('data'));
    }

    public function store(Request $request)
    {
        $result = $this->repo->store($request);
        if($result['status']){
            return back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $data['fees_collect']  = $this->repo->show($id);
        $data['title']         = ___('fees.fees_collect');
        return view('backend.fees.collect.edit', compact('data'));
    }

    public function update(FeesCollectUpdateRequest $request, $id)
    {
        $result = $this->repo->update($request, $id);
        if($result['status']){
            return redirect()->route('fees-collect.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {

        $result = $this->repo->destroy($id);
        if($result['status']):
            $success[0] = $result['message'];
            $success[1] = 'success';
            $success[2] = ___('alert.deleted');
            $success[3] = ___('alert.OK');
            return response()->json($success);
        else:
            $success[0] = $result['message'];
            $success[1] = 'error';
            $success[2] = ___('alert.oops');
            return response()->json($success);
        endif;
    }

    public function getFeesCollectStudents(Request $request)
    {
        $data['students'] = $this->repo->getFeesAssignStudents($request);
        $data['title']    = ___('fees.fees_collect');
        $data['classes']  = $this->classRepo->assignedAll();
        return view('backend.fees.collect.index', compact('data'));
    }

    public function feesShow(Request $request)
    {
        $data = $this->repo->feesShow($request);
        $data['is_siblings_discount'] = false;
        $isEnable = Setting::where('name', 'early_payment_discount_applicable')->first();
        if ($isEnable && $isEnable->value == 1){
            $now = date('Y-m-d');
            $discount = EarlyPaymentDiscount::whereDate('start_date', '<=', $now)
                ->whereDate('end_date', '>=', $now)
                ->first();
            if ($discount){
                $data['early_payment_discount_percentage'] = $discount->discount_percentage;
                $data['discount_name'] = $discount->name;
            }
        }
        $data['siblings_discount_percentage'] = null;
        $data['siblings_discount_name'] = null;
        $isSiblingsDiscountEnable = Setting::where('name', 'siblings_discount_applicable')->first();
        if ($isSiblingsDiscountEnable && $isSiblingsDiscountEnable->value == 1){
            $student        = $this->studentRepo->show($request->student_id);
            if ($student->siblings_discount == 1){
                $data['is_siblings_discount'] = true;
                $feesAssignChild = $data['fees_assign_children']->first();
                if ($feesAssignChild && $feesAssignChild->feesDiscount) {
                    $data['siblings_discount_percentage'] = $feesAssignChild->feesDiscount->discount_percentage;
                    $data['siblings_discount_name'] = $feesAssignChild->feesDiscount->title;
                }
            }
        }

        return view('backend.fees.collect.fees-show', compact('data'));
    }



}
