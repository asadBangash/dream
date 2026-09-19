<?php

namespace App\Http\Controllers\ParentPanel;

use App\Models\EarlyPaymentDiscount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Fees\FeesAssignChildren;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Repositories\Fees\FeesCollectRepository;
use App\Repositories\ParentPanel\FeesRepository;

class FeesController extends Controller
{
    private $repo;
    private $feesCollectRepository;

    function __construct(FeesRepository $repo, FeesCollectRepository $feesCollectRepository)
    {
        $this->repo = $repo;
        $this->feesCollectRepository = $feesCollectRepository;
    }

    public function index(Request $request){
        $data = $this->repo->index($request);
        return view('parent-panel.fees', compact('data'));
    }


    public function payModal(Request $request)
    {
        $now = date('Y-m-d');
        $discount = EarlyPaymentDiscount::whereDate('start_date', '<=', $now)
            ->whereDate('end_date', '>=', $now)
            ->first();

        return view('common.fee-pay.fee-pay-modal', [
            'discount' => $discount,
            'feeAssignChildren' => FeesAssignChildren::with('feesMaster')->where('id', $request->fees_assigned_children_id)->first(),
            'formRoute' => route('parent-panel-fees.pay-with-stripe'),
            'paypalRoute' => route('parent-panel-fees.pay-with-paypal'),
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
        $data       = $this->feesCollectRepository->paypalOrderData(uniqid(), route('parent-panel-fees.payment.success'), route('parent-panel-fees.payment.cancel'));
        $response   = $provider->setExpressCheckout($data);

        return redirect($response['paypal_link']);
    }





    public function paymentSuccess(Request $request)
    {
        loadPayPalCredentials();

        try {
            $provider   = new ExpressCheckout;
            $token      = $request->token;
            $PayerID    = $request->PayerID;
            $response   = $provider->getExpressCheckoutDetails($token);

            $invoiceID  = $response['INVNUM'] ?? uniqid();
            $data       = $this->feesCollectRepository->paypalOrderData($invoiceID, route('parent-panel-fees.payment.success'), route('parent-panel-fees.payment.cancel'));
            $response   = $provider->doExpressCheckoutPayment($data, $token, $PayerID);

            $feesAssignChildren = optional(FeesAssignChildren::with('feesMaster')->where('id', session()->get('FeesAssignChildrenID'))->first());

            if ($feesAssignChildren && $response['PAYMENTINFO_0_TRANSACTIONID']) {
                $this->feesCollectRepository->feeCollectStoreByPaypal($response, $feesAssignChildren);
            }

            session()->forget('FeesAssignChildrenID');

            return redirect()->route('parent-panel-fees.index', ['student_id' => $feesAssignChildren->student_id])->with('success', ___('alert.Fee has been paid successfully'));

        } catch (\Throwable $th) {

            return redirect()->route('parent-panel-fees.index')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }





    public function paymentCancel()
    {
        return redirect()->route('parent-panel-fees.index')->with('danger', ___('alert.Payment cancelled!'));
    }
}
