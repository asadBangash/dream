<?php

namespace Modules\MainApp\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\MainApp\Entities\School;
use Modules\MainApp\Entities\Package;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Modules\MainApp\Entities\Subscription;
use Modules\MainApp\Enums\PackagePaymentType;
use Srmklive\PayPal\Services\ExpressCheckout;
use Modules\MainApp\Http\Repositories\FAQRepository;
use Modules\MainApp\Http\Requests\SubscriptionRequest;
use Modules\MainApp\Http\Repositories\FeatureRepository;
use Modules\MainApp\Http\Repositories\MainAppRepository;
use Modules\MainApp\Http\Repositories\PackageRepository;
use Modules\MainApp\Http\Repositories\TestimonialRepository;

class MainAppController extends Controller
{
    private $repo;
    private $featureRepo;
    private $testimonialRepo;
    private $packageRepo;
    private $faqRepo;

    function __construct(
        MainAppRepository $repo,
        FeatureRepository $featureRepo,
        TestimonialRepository $testimonialRepo,
        PackageRepository $packageRepo,
        FAQRepository $faqRepo,
    )
    {
        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        }
        $this->repo            = $repo;
        $this->featureRepo     = $featureRepo;
        $this->testimonialRepo = $testimonialRepo;
        $this->packageRepo     = $packageRepo;
        $this->faqRepo         = $faqRepo;
    }

    public function index()
    {
        session()->put('subdomainForPackageUpgrade', request('school_subdomain') ?? session()->get('subdomainForPackageUpgrade'));
        session()->put('subdomainTotalStudent', request('total_student') ?? session()->get('subdomainTotalStudent'));

        $data['features']     = $this->featureRepo->all();
        $data['testimonials'] = $this->testimonialRepo->all();
        $data['packages']     = $this->packageRepo->all();
        $data['faqs']         = $this->faqRepo->all();
        return view('mainapp::index', compact('data'));
    }

    public function getContacts()
    {
        $data['title']    = 'Contacts';
        $data['contacts'] = $this->repo->getContacts();
        return view('mainapp::contact.index', compact('data'));
    }
    public function getSubscribes()
    {
        $data['title']      = 'Subscription';
        $data['subscribes'] = $this->repo->getSubscribes();
        return view('mainapp::subscribe.index', compact('data'));
    }

    public function storeContact(Request $request)
    {
        return $this->repo->contact($request);
    }

    public function storeSubscribe(Request $request)
    {
        return $this->repo->subscribe($request);
    }

    public function checkSubDomain(Request $request)
    {
        return $this->repo->checkSubDomain($request);
    }

    public function subscription($id)
    {
        $data['package']         = $this->packageRepo->show($id);
        $data['subdomain_name']  = null;
        return view('mainapp::subscription', compact('data'));
    }

    public function upgradeSubscription($plan_id, $subdomain_name)
    {
        $data['package']        = $this->packageRepo->show($plan_id);
        $data['subdomain_name'] = $subdomain_name;
        $data['school_info']    = School::where('sub_domain_key', $subdomain_name)->first();

        $previousPackageID      = Subscription::active()->where('school_id', @$data['school_info']->id)->latest('id')->first()?->package_id;
        $previousPackage        = Package::where(['id' => $previousPackageID, 'payment_type' => PackagePaymentType::POSTPAID])->first();
        $data['previousDue']    = $previousPackage ? $previousPackage->per_student_price * session()->get('subdomainTotalStudent') : 0;

        session()->put('previousDue', $data['previousDue']);

        return view('mainapp::subscription', compact('data'));
    }



    public function upgradeSubscriptionStore(Request $request){
        try {
            dd($request->all());
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function subscriptionStore(Request $request)
    {
        $result = $this->repo->subscriptionStore($request);
        if ($result) {
            return redirect()->route('purchase-invoice')->with('success', ___('alert.Payment successful'));
        } else {
            return redirect()->back()->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function payWithPaypal(Request $request)
    {
        Session::put('packageId', $request->package_id);
        Session::put('request', $request->all());

        $provider   = new ExpressCheckout;
        $data       = $this->repo->paypalOrderData(uniqid(), route('payment.success'), route('payment.cancel'), 0, session()->get('previousDue'));
        $response   = $provider->setExpressCheckout($data);

        return redirect($response['paypal_link']);
    }

    public function paymentSuccess(Request $request)
    {
        try {
            $provider   = new ExpressCheckout;
            $token      = $request->token;
            $PayerID    = $request->PayerID;
            $response   = $provider->getExpressCheckoutDetails($token);

            $invoiceID  = $response['INVNUM'] ?? uniqid();
            $data       = $this->repo->paypalOrderData($invoiceID, route('payment.success'), route('payment.cancel'), $response['AMT'], 0);
            $response   = $provider->doExpressCheckoutPayment($data, $token, $PayerID);

            $package = optional(Package::where('id', session()->get('packageId'))->first());
            $request = session()->get('request');

            if ($response['PAYMENTINFO_0_TRANSACTIONID']) {
                $subscription_id = $this->repo->feeCollectStoreByPaypal($request, $response['PAYMENTINFO_0_TRANSACTIONID']);
            }

            session()->forget('packageId');
            session()->forget('request');

            if(@$request['subdomain_name']){
                $school = School::where('sub_domain_key', $request['subdomain_name'])->first();

                $data['to_name']                 = $school->name;
                $data['to_email']                = $school->email;
                $data['to_phone']                = $school->phone;
                $data['payment_method']          = $school->payment_method;
            }
            else{
                $data['to_name']                 = $request['name'];
                $data['to_email']                = $request['email'];
                $data['to_phone']                = $request['phone'];
                $data['payment_method']          = $request['payment_method'];
            }

            $data['invoice_no']              = $subscription_id;
            $data['package_name']            = $package->name;
            $data['package_duration']        = $package->duration;
            $data['package_duration_number'] = $package->duration_number;
            $data['package_amount']          = $package->price;
            $data['previous_due']            = session()->get('previousDue');

            Session::put('data', $data);
            return redirect()->route('purchase-invoice')->with('success', ___('alert.Payment successful'));
        } catch (\Throwable $th) {
            return redirect()->route('Home')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }
    }

    public function paymentCancel()
    {
        return redirect()->route('Home')->with('danger', ___('alert.Payment cancelled!'));
    }

    public function purchaseInvoice()
    {
        session()->forget('subdomainForPackageUpgrade');
        session()->forget('subdomainTotalStudent');
        session()->forget('previousDue');

        return view('mainapp::pay_invoice');
    }

    public function downloadInvoice()
    {

        $data = session()->get('data');

        $pdf = PDF::loadView('mainapp::invoice', compact('data'));
        // dd($pdf);
        return $pdf->download('pay_invoice'.'_'.date('d_m_Y').'.pdf');
    }
}
