<?php

namespace App\Http\Controllers\StudentPanel;

use App\Models\EarlyPaymentDiscount;
use Stripe\Charge;
use Stripe\Stripe;
use Illuminate\Http\Request;
use App\Models\Accounts\Income;
use App\Models\Fees\FeesCollect;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Fees\FeesAssignChildren;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Repositories\Fees\FeesCollectRepository;
use App\Repositories\StudentPanel\FeesRepository;
use App\Services\StudentFeesService;

class FeesController extends Controller
{
    private $repo;
    private $feesCollectRepository;
    private $studentFeesService;

    function __construct(FeesRepository $repo, FeesCollectRepository $feesCollectRepository, StudentFeesService $studentFeesService)
    {
        $this->repo = $repo;
        $this->feesCollectRepository = $feesCollectRepository;
        $this->studentFeesService = $studentFeesService;
    }


    public function index()
    {
        $data = $this->repo->index();
        return view('student-panel.fees', compact('data'));
    }


    public function payModal(Request $request)
    {
        $now = date('Y-m-d');
        $discount = EarlyPaymentDiscount::whereDate('start_date', '<=', $now)
            ->whereDate('end_date', '>=', $now)
            ->first();

        return view('common.fee-pay.fee-pay-modal', [
            'discount' => $discount,
            'feeAssignChildren' => FeesAssignChildren::with('feesMaster')
                ->where('id', $request->fees_assigned_children_id)
                ->first(),
            'formRoute' => route('student-panel-fees.pay-with-stripe'),
            'paypalRoute' => route('student-panel-fees.pay-with-paypal'),
        ]);

    }


    public function payWithStripe(Request $request)
    {
        try {
            $this->feesCollectRepository->payWithStripeStore($request);

            return back()->with('success', ___('alert.Fee has been paid successfully'));

        } catch (\Throwable $th) {
            return back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function payWithPaypal(Request $request)
    {
        loadPayPalCredentials();

        Session::put('FeesAssignChildrenID', $request->fees_assign_children_id);

        $provider   = new ExpressCheckout;
        $data       = $this->feesCollectRepository->paypalOrderData(uniqid(), route('student-panel-fees.payment.success'), route('student-panel-fees.payment.cancel'));
        $response   = $provider->setExpressCheckout($data);

        return redirect($response['paypal_link']);
    }


    public function paymentSuccess(Request $request)
    {
        $result = $this->studentFeesService->payPalPaymentSuccess($request, route('student-panel-fees.payment.success'), route('student-panel-fees.payment.cancel'));

        if ($result) {
            return redirect()->route('student-panel-fees.index')->with('success', ___('alert.Fee has been paid successfully'));
        } else {
            return redirect()->route('student-panel-fees.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }


    public function paymentCancel()
    {
        return redirect()->route('student-panel-fees.index')->with('danger', ___('alert.Payment cancelled!'));
    }


    public function studentFeesPayWithStripe($fee_assign_children_id)
    {
        $data['feeAssignChildren'] = FeesAssignChildren::with('feesMaster')->where('id', $fee_assign_children_id)->first();

        return view('student-panel.payment.stripe', $data);
    }


    public function studentFeesPayWithStripeStore(Request $request)
    {
        try {
            $this->feesCollectRepository->payWithStripeStore($request);

            return redirect()->route('student-fees.payment-success');

        } catch (\Throwable $th) {
            return redirect()->route('student-fees.payment-error');
        }
    }


    public function studentFeesPayWithPayPal($fee_assign_children_id)
    {
        loadPayPalCredentials();

        Session::put('FeesAssignChildrenID', $fee_assign_children_id);

        $provider   = new ExpressCheckout;
        $data       = $this->feesCollectRepository->paypalOrderData(uniqid(), route('student-fees.paypal-payment-success'), route('student-fees.payment-cancel'));
        $response   = $provider->setExpressCheckout($data);

        return redirect($response['paypal_link']);
    }


    public function studentFeesPayPalPaymentSuccess(Request $request)
    {
        $result = $this->studentFeesService->payPalPaymentSuccess($request, route('student-fees.paypal-payment-success'), route('student-fees.payment-cancel'));

        if ($result) {
            return redirect()->route('student-fees.payment-success');
        } else {
            return redirect()->route('student-fees.payment-error');
        }
    }


    public function studentFeesPaymentSuccess()
    {
        return view('student-panel.payment.success');
    }


    public function studentFeesPaymentCancel()
    {
        return view('student-panel.payment.cancel');
    }


    public function studentFeesPaymentError()
    {
        return view('student-panel.payment.error');
    }
}
