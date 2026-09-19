<?php

namespace Modules\MainApp\Http\Repositories;

use Stripe\Charge;
use Stripe\Stripe;
use App\Enums\Status;
use App\Enums\Settings;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\MainApp\Entities\School;
use Modules\MainApp\Entities\Contact;
use Modules\MainApp\Entities\Package;
use Illuminate\Support\Facades\Session;
use Modules\MainApp\Entities\Subscribe;
use Modules\MainApp\Entities\Subscription;
use Modules\MainApp\Jobs\SaasSchoolApproveJob;
use Modules\MainApp\Services\SaaSSchoolService;
use Modules\MainApp\Http\Interfaces\MainAppInterface;

class MainAppRepository implements MainAppInterface
{
    protected $saasSchool;

    public function __construct()
    {
        $this->saasSchool = new SaaSSchoolService;
    }

    public function getContacts()
    {
        return Contact::paginate(Settings::PAGINATE);
    }
    public function getSubscribes()
    {
        return Subscribe::paginate(Settings::PAGINATE);
    }

    public function contact($request)
    {
        try {
            $row           = new Contact();
            $row->phone    = $request->phone;
            $row->email    = $request->email;
            $row->message  = $request->message;
            $row->save();
            return response()->json([___('frontend.Success'), ___('frontend.send_successfully'), 'success', ___('frontend.OK')]);
        } catch (\Throwable $th) {
            return response()->json([___('frontend.Error'), ___('frontend.something_went_wrong'), 'error', ___('frontend.OK')]);
        }
    }

    public function subscribe($request)
    {
        try {
            if ($request->email == '')
                return response()->json([___('frontend.Attention'), ___('frontend.This email field is required'), 'warning', ___('frontend.OK')]);

            $row          = Subscribe::where('email', $request->email)->first();
            if ($row)
                return response()->json([___('frontend.Attention'), ___('frontend.already_subscribed'), 'warning', ___('frontend.OK')]);

            $row          = new Subscribe();
            $row->email   = $request->email;
            $row->save();

            return response()->json([___('frontend.Success'), ___('frontend.Subscribed'), 'success', ___('frontend.OK')]);
        } catch (\Throwable $th) {
            return response()->json([___('frontend.Error'), ___('frontend.something_went_wrong'), 'error', ___('frontend.OK')]);
        }
    }

    public function checkSubDomain($request)
    {
        try {

            $row = School::where('sub_domain_key', $request->sub_domain_key)->first() ?? Subscription::where('sub_domain_key', $request->sub_domain_key)->first();
            if ($row != null)
                return response()->json([___('frontend.Attention'), ___('frontend.Subdomain key not available.'), 'error', ___('frontend.OK')]);
            else
                return response()->json([___('frontend.Success'), ___('frontend.Continue'), 'success', ___('frontend.OK')]);

        } catch (\Throwable $th) {
            return response()->json([___('frontend.Error'), ___('frontend.something_went_wrong'), 'error', ___('frontend.OK')]);
        }
    }

    public function subscriptionStore($request)
    {
        DB::beginTransaction();

        try {
            $trx_id = $this->stripePayment($request);
            $subscription = $this->saasSchool->store($request, 'website', $trx_id, $request->payment_method);
            DB::commit();
            return $subscription;
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
            return false;
        }
    }

    public function paypalOrderData($invoice_no, $success_route, $cancel_route, $successAmount, $previousDue)
    {
        $package = optional(Package::where('id', session()->get('packageId'))->first());
        $amount  = $successAmount > 0 ? $successAmount : $package->price + $previousDue;
        $description = 'Pay ' . $amount . ' for ' . $package->name;

        $data                           = [];
        $data['items']                  = [];
        $data['invoice_id']             = $invoice_no;
        $data['invoice_description']    = $description;
        $data['return_url']             = $success_route;
        $data['cancel_url']             = $cancel_route;
        $data['total']                  = $amount;

        return $data;
    }

    public function feeCollectStoreByPaypal($request, $trx_id)
    {
        try {
            return $this->saasSchool->store($request, 'website', $trx_id, 'PayPal');
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return null;
        }
    }

    protected function stripePayment($request)
    {
        if (Str::lower($request->payment_type) == 'prepaid') {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $description = 'Pay ' . $request->package_amount . ' for "' . $request->package_name . '" fee by ' . $request->name;

            $charge = Charge::create([
                "amount"        => $request->package_amount * 100,
                "currency"      => "usd",
                "source"        => $request->stripeToken,
                "description"   => $description
            ]);

            return @$charge->balance_transaction;
        }

        return null;
    }
}
