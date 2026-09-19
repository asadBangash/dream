<?php

namespace App\Http\Controllers\Api\Student;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Fees\FeesGroup;
use App\Traits\ReturnFormatTrait;
use App\Http\Controllers\Controller;
use App\Models\Fees\FeesAssignChildren;
use App\Http\Resources\Student\StudentFeeResource;
use App\Http\Resources\Student\StudentFeeGroupResource;

class FeeAPIController extends Controller
{
    use ReturnFormatTrait;

    public function feeGroups()
    {
        try {
            
            if (!sessionClassStudent()) {
                return $this->responseWithError(___('alert.Student not found'));
            }

            $sessionClassStudent    = sessionClassStudent();

            $fees                   = FeesGroup::query()
                                    ->active()
                                    ->whereHas('feeMasters', fn ($q) => $q->active()->where('session_id', @$sessionClassStudent->session_id))
                                    ->with(['feeMasters' => fn ($q) => $q->active()->where('session_id', @$sessionClassStudent->session_id)])
                                    ->whereHas('feeAssigns', function ($q) use ($sessionClassStudent) {
                                        $q->where('session_id', @$sessionClassStudent->session_id)
                                        ->where('classes_id', @$sessionClassStudent->classes_id)
                                        ->where('section_id', @$sessionClassStudent->section_id);
                                    })
                                    ->get();
                                
            $data                   = StudentFeeGroupResource::collection($fees);

            return $this->responseWithSuccess(___('alert.success'), $data);

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }
    
    public function fees($fee_group_id)
    {
        try {
            
            if (!sessionClassStudent()) {
                return $this->responseWithError(___('alert.Student not found'));
            }

            $sessionClassStudent    = sessionClassStudent();

            $fees                   = FeesAssignChildren::query()
                                    ->where('student_id', @$sessionClassStudent->student_id)
                                    ->whereHas('feesMaster', function ($q) use ($sessionClassStudent, $fee_group_id) {
                                        $q->active()
                                        ->where('session_id', @$sessionClassStudent->session_id)
                                        ->where('fees_group_id', $fee_group_id);
                                    })
                                    ->with(['feesMaster' => function ($q) use ($sessionClassStudent, $fee_group_id) {
                                        $q->active()
                                        ->where('session_id', @$sessionClassStudent->session_id)
                                        ->where('fees_group_id', $fee_group_id);
                                    }])
                                    ->with(['feesMaster' => fn ($q) => $q->active()->where('session_id', @$sessionClassStudent->session_id)->where('fees_group_id', $fee_group_id)])
                                    ->whereHas('feesAssign', function ($q) use ($sessionClassStudent, $fee_group_id) {
                                        $q->where('fees_group_id', $fee_group_id)
                                        ->where('session_id', @$sessionClassStudent->session_id)
                                        ->where('classes_id', @$sessionClassStudent->classes_id)
                                        ->where('section_id', @$sessionClassStudent->section_id);
                                    })
                                    ->when(request()->filled('status') && Str::lower(request('status')) == 'paid', function ($q) {
                                        $q->whereHas('feesCollect');
                                    })
                                    ->when(request()->filled('status') && Str::lower(request('status')) == 'unpaid', function ($q) {
                                        $q->whereDoesntHave('feesCollect');
                                    })
                                    ->paginate(10);

            $data                   = StudentFeeResource::collection($fees)->response()->getData(true);

            return $this->responseWithSuccess(___('alert.success'), $data);

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }
    
    public function paymentGateways()
    {
        try {
            
            if (!sessionClassStudent()) {
                return $this->responseWithError(___('alert.Student not found'));
            }
            
            $data = [
                [
                    'icon'  => asset('images/paypal.png'), 
                    'name'  => 'PayPal',
                    'url'   => route('student-fees.pay-with-paypal', ['fee_assign_children_id' => request('fee_assign_children_id')])
                ],
                [
                    'icon'  => asset('images/stripe.png'), 
                    'name'  => 'Stripe',
                    'url'   => route('student-fees.pay-with-stripe', ['fee_assign_children_id' => request('fee_assign_children_id')])
                ],
            ];

            return $this->responseWithSuccess(___('alert.success'), $data);

        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), $th->getMessage());
        }
    }
}
