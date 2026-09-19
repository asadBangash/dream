<?php

namespace App\Services;

use App\Traits\CommonHelperTrait;
use App\Traits\ApiReturnFormatTrait;
use App\Models\Fees\FeesAssignChildren;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Repositories\Fees\FeesCollectRepository;

class StudentFeesService
{
    use CommonHelperTrait;
    use ApiReturnFormatTrait;
    private $feesCollectRepository;

    function __construct(FeesCollectRepository $feesCollectRepository)
    { 
        $this->feesCollectRepository = $feesCollectRepository; 
    }

    public function payPalPaymentSuccess($request, $success_url, $cancel_url)
    {
        loadPayPalCredentials();
        
        try {
            $provider   = new ExpressCheckout;
            $token      = $request->token;
            $PayerID    = $request->PayerID;
            $response   = $provider->getExpressCheckoutDetails($token);

            $invoiceID  = $response['INVNUM'] ?? uniqid();
            $data       = $this->feesCollectRepository->paypalOrderData($invoiceID, $success_url, $cancel_url);
            $response   = $provider->doExpressCheckoutPayment($data, $token, $PayerID);

            $feesAssignChildren = optional(FeesAssignChildren::with('feesMaster')->where('id', session()->get('FeesAssignChildrenID'))->first());

            if ($feesAssignChildren && $response['PAYMENTINFO_0_TRANSACTIONID']) {
                $this->feesCollectRepository->feeCollectStoreByPaypal($response, $feesAssignChildren);
            }

            session()->forget('FeesAssignChildrenID');

            return true;

        } catch (\Throwable $th) {
            return false;
        }
    }
}
