<?php

namespace App\Repositories\Fees;

use App\Models\AssignFeesDiscount;
use App\Models\EarlyPaymentDiscount;
use App\Models\Setting;
use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Accounts\Income;
use App\Models\Fees\FeesCollect;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Fees\FeesAssignChildren;
use App\Interfaces\Fees\FeesMasterInterface;
use App\Interfaces\Fees\FeesCollectInterface;
use App\Models\Accounts\AccountHead;
use App\Models\StudentInfo\SessionClassStudent;

class FeesCollectRepository implements FeesCollectInterface
{
    use ReturnFormatTrait;

    private $model;
    private $feesMasterRepo;

    public function __construct(FeesCollect $model, FeesMasterInterface $feesMasterRepo)
    {
        $this->model          = $model;
        $this->feesMasterRepo = $feesMasterRepo;
    }

    public function all()
    {
        return $this->model->active()->get();
    }

    public function getPaginateAll()
    {
        return $this->model::latest()->paginate(10);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            foreach ($request->fees_assign_childrens as $key=>$item) {
                $row                   = new $this->model;
                $row->date             = $request->date;
                $row->payment_method   = $request->payment_method;
                $row->fees_assign_children_id   = $item;
                $row->amount           = $request->amounts[$key] + $request->fine_amounts[$key] ?? 0;
                $row->fine_amount      = $request->fine_amounts[$key];
                $row->fees_collect_by  = Auth::user()->id;
                $row->student_id       = $request->student_id;
                $row->session_id       = setting('session');
                $row->save();

               $ac_head =  AccountHead::where('type', 1)->where('status', 1)->first();


               if($ac_head){
                    $incomeStore                   = new Income();
                    $incomeStore->fees_collect_id  = $row->id;
                    $incomeStore->name             = $item;
                    $incomeStore->session_id       = setting('session');
                    $incomeStore->income_head      = $ac_head->id; // Because, Fees id 1.
                    $incomeStore->date             = $request->date;
                    $incomeStore->amount           = $row->amount;
                    $incomeStore->invoice_number   = 'fees_collect_'.$item;
                    $incomeStore->save();
               }

                $tax = calculateTax($row->amount);
                $settings = Setting::whereIn('name', ['tax_income_head'])->pluck('value', 'name');
                $accountHead = AccountHead::where('name', $settings['tax_income_head'])->first();
                if ($tax > 0 && $settings) {
                    $incomeStore = new Income();
                    $incomeStore->name = "Fees-Tax";
                    $incomeStore->session_id = setting('session');
                    $incomeStore->income_head = $accountHead->id;
                    $incomeStore->date = $request->date;
                    $incomeStore->amount = $tax;
                    $incomeStore->save();
                }

                if ($request->early_payment_percentage > 0){
                    $feesDiscount = new AssignFeesDiscount();
                    $feesDiscount->fees_assign_children_id = $item;
                    $feesDiscount->title = 'Early Payment Fees Discount';
                    $feesDiscount->discount_amount = calculateDiscount($row->amount, $request->early_payment_percentage);
                    $feesDiscount->discount_percentage = $request->early_payment_percentage;
                    $feesDiscount->discount_source = 'Early Payment Fees Discount';
                    $feesDiscount->save();
                }



            }

            DB::commit();
            return $this->responseWithSuccess(___('alert.created_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function feesAssigned($id) // student id
    {

        $groups = FeesAssignChildren::withCount('feesCollect')->with(['feesCollect', 'feesDiscount'])->where('student_id', $id);
        $groups = $groups->whereHas('feesAssign', function ($query) {
            return $query->where('session_id', setting('session'));
        });

        return $groups->get();
    }

    public function update($request, $id)
    {
        try {
            $row                = $this->model->findOrfail($id);
            $row->name          = $request->name;
            $row->code          = $request->code;
            $row->description   = $request->description;
            $row->status        = $request->status;
            $row->save();
            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $row = $this->model->find($id);
            $row->delete();

            $income = Income::where('invoice_number', 'fees_collect_'.$row->fees_assign_children_id)->first();
            if($income){
                $income->delete();
            }
            DB::commit();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function getFeesAssignStudents($request)
    {
        $students = SessionClassStudent::query();
        $students = $students->where('session_id', setting('session'));
        if($request->class != "") {

            $students = $students->where('classes_id', $request->class);
        }

        if($request->section != "") {

            $students = $students->where('section_id', $request->section);
        }

        if($request->name != "") {
            $students = $students->whereHas('student', function ($query) use ($request) {
                return $query->where('first_name', $request->name)->orWhere('last_name', $request->name);
            });
        }

        if($request->student != "") {
            $students = $students->where('student_id', $request->student);
        }

        return $students->paginate(10);
    }

    public function feesShow($request)
    {
        $data['fees_assign_children'] = $this->feesAssigned($request->student_id)->whereIn('id', $request->fees_assign_childrens);

        $data['student_id']           = $request->student_id;
        $data['discount_amount']      = $request->discount_amount;
        return $data;
    }

    public function payWithStripeStore($request)
    {
        DB::transaction(function () use ($request) {
            Stripe::setApiKey(Setting('stripe_secret'));
            $feesAssignChildren = optional(FeesAssignChildren::with('feesMaster')->where('id', $request->fees_assign_children_id)->first());
            $description = 'Pay ' . ($request->amount + $request->fine_amount) . ' for ' . $feesAssignChildren->feesMaster?->type?->name . ' of ' . env('APP_NAME');

            $amount = ($request->amount + $request->fine_amount) * 100;
            $amount += calculateTax($amount);
            $now = date('Y-m-d');
            $discount = EarlyPaymentDiscount::whereDate('start_date', '<=', $now)
                ->whereDate('end_date', '>=', $now)
                ->first();

            if ($discount) {
                $amount -= calculateDiscount($amount, $discount->discount_percentage);
            }
            $amount = (int)round($amount);

            $charge = Charge::create([
                "amount" => $amount,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => $description
            ]);

            $this->feeCollectStoreByStripe($request, @$charge->balance_transaction);
        });
    }

    protected function feeCollectStoreByStripe($request, $transaction_id)
    {
        $feesCollect = FeesCollect::create([
            'date'                      => $request->date,
            'payment_method'            => 2,
            'payment_gateway'           => 'Stripe',
            'transaction_id'            => $transaction_id,
            'fees_assign_children_id'   => $request->fees_assign_children_id,
            'amount'                    => $request->amount + $request->fine_amount ?? 0,
            'fine_amount'               => $request->fine_amount,
            'fees_collect_by'           => 1, // Because student/parent can not be collect so that's why we use first admin user id.
            'student_id'                => $request->student_id,
            'session_id'                => setting('session')
        ]);

            $ac_head =  AccountHead::where('type', 1)->where('status', 1)->first();

            if($ac_head){
                $incomeStore                   = new Income();
                $incomeStore->fees_collect_id  = $feesCollect->id;
                $incomeStore->name             = env('APP_NAME').'_'.$request->fees_assign_children_id;
                $incomeStore->session_id       = setting('session');
                $incomeStore->income_head      = $ac_head->id; // Because, Fees id 1.
                $incomeStore->date             = $request->date;
                $incomeStore->amount           = $feesCollect->amount;
                $incomeStore->save();
            }
    }




    public function paypalOrderData($invoice_no, $success_route, $cancel_route)
    {
        $feesAssignChildren = optional(FeesAssignChildren::with('feesMaster')->where('id', session()->get('FeesAssignChildrenID'))->first());

        $total = $feesAssignChildren->feesMaster?->amount;
        $now = date('Y-m-d');
        $discount = EarlyPaymentDiscount::whereDate('start_date', '<=', $now)
            ->whereDate('end_date', '>=', $now)
            ->first();

        $total += calculateTax($total);

        if ($discount) {
            $total -= calculateDiscount($total, $discount->discount_percentage);
        }

        if (date('Y-m-d') > $feesAssignChildren->feesMaster?->due_date && $feesAssignChildren->fees_collect_count == 0) {
            $total += $feesAssignChildren->feesMaster?->fine_amount;
        }

        $description = 'Pay ' . $total . ' for ' . $feesAssignChildren->feesMaster?->type?->name;

        $data                           = [];
        $data['items']                  = [];
        $data['invoice_id']             = $invoice_no;
        $data['invoice_description']    = $description;
        $data['return_url']             = $success_route;
        $data['cancel_url']             = $cancel_route;
        $data['total']                  = $total;

        return $data;
    }





    public function feeCollectStoreByPaypal($response, $feesAssignChildren)
    {
        DB::transaction(function () use ($response, $feesAssignChildren) {

            $amount = $feesAssignChildren->feesMaster?->amount;
            $fine_amount = 0;

            if (date('Y-m-d') > $feesAssignChildren->feesMaster?->due_date && $feesAssignChildren->fees_collect_count == 0) {
                $fine_amount = $feesAssignChildren->feesMaster?->fine_amount;
                $amount += $fine_amount;
            }

            $date = date('Y-m-d', strtotime($response['PAYMENTINFO_0_ORDERTIME']));

            $feesCollect = FeesCollect::create([
                'date'                      => $date,
                'payment_method'            => 2,
                'payment_gateway'           => 'PayPal',
                'transaction_id'            => $response['PAYMENTINFO_0_TRANSACTIONID'],
                'fees_assign_children_id'   => $feesAssignChildren->id,
                'amount'                    => $amount,
                'fine_amount'               => $fine_amount,
                'fees_collect_by'           => 1, // Because student/parent can not be collect so that's why we use first admin user id.
                'student_id'                => $feesAssignChildren->student_id,
                'session_id'                => setting('session')
            ]);

            Income::create([
                'fees_collect_id'           => $feesCollect->id,
                'name'                      => $feesAssignChildren->id,
                'session_id'                => setting('session'),
                'income_head'               => 1, // Because, Fees id 1.
                'date'                      => $date,
                'amount'                    => $amount
            ]);
        });
    }
}
