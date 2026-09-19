<?php

namespace Modules\MainApp\Services;

use App\Enums\Status;
use App\Models\Tenant;
use App\Models\Setting;
use Illuminate\Support\Str;
use App\Enums\PricingDuration;
use App\Enums\SubscriptionStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Modules\MainApp\Entities\School;
use Illuminate\Support\Facades\Cache;
use Modules\MainApp\Entities\Package;
use Illuminate\Support\Facades\Artisan;
use Modules\MainApp\Entities\Subscription;
use Modules\MainApp\Traits\SaasHelperTrait;
use Modules\MainApp\Jobs\SaasSchoolApproveJob;

class SaaSSchoolService
{
    use SaasHelperTrait;
    protected $school;
    protected $subscription;
    protected $expiryDate;
    protected $package;
    protected $features;
    protected $featuresName;



    public function store($request, $source = 'website', $trx_id = null, $payment_method = null)
    {
        try {
             if (!defined('STDIN')) {
                define('STDIN', fopen('php://stdin', 'r'));
            }
            $this->storeSchool($request, $source);
            $this->subscription = $this->storeSubscription($request, $source, $trx_id, $payment_method);
            return @$this->subscription->id;
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            dd($th);
            return null;
        }
    }

    public function cacheForget()
    {
        cache()->forget('activeSubscriptionStudentLimit');
        cache()->forget('activeSubscriptionStaffLimit');
        cache()->forget('activeSubscriptionExpiryDate');
        cache()->forget('activeSubscriptionFeatures');
    }

    protected function storeSchool($request, $source)
    {
        $this->school = School::where('sub_domain_key', $request['sub_domain_key'])->first();

        if (!$this->school) {
            $this->school                     = new School();
            $this->school->sub_domain_key     = $request['sub_domain_key'];
            $this->school->name               = $request['name'];
            $this->school->package_id         = $request['package_id'];
            $this->school->address            = $request['address'];
            $this->school->phone              = $request['phone'];
            $this->school->email              = $request['email'];
            $this->school->status             = $source == 'admin' ? $request['status'] : Status::INACTIVE;
            $this->school->save();
        }

        return $this->school;
    }

    protected function storeSubscription($request, $source, $trx_id, $payment_method)
    {
        $this->features             = [];
        $this->featuresName         = [];
        $this->package              = Package::where('id', $request['package_id'])->first();

        foreach (@$this->package->packageChilds ?? [] as $value) {
            $this->features[]       = @$value->feature->key;
            $this->featuresName[]   = @$value->feature->title;
        }


        if ($this->package->duration == PricingDuration::DAYS) {
            $this->expiryDate = date("Y-m-d", strtotime("+ " . $this->package->duration_number . " day"));
        } elseif ($this->package->duration == PricingDuration::MONTHLY) {
            $this->expiryDate = date("Y-m-d", strtotime("+ " . $this->package->duration_number . " month"));
        } elseif ($this->package->duration == PricingDuration::YEARLY) {
            $this->expiryDate = date("Y-m-d", strtotime("+ " . $this->package->duration_number . " year"));
        }


        $old_school = false;
        if (Subscription::where('school_id', $this->school->id)->first()) {
            $old_school = true;
        }

        $this->subscription                     = new Subscription();
        $this->subscription->package_id         = @$this->package->id;
        $this->subscription->price              = @$this->package->price;
        $this->subscription->student_limit      = @$this->package->student_limit;
        $this->subscription->staff_limit        = @$this->package->staff_limit;
        $this->subscription->expiry_date        = $this->expiryDate ? date('Y-m-d', strtotime($this->expiryDate)) : null;
        $this->subscription->features_name      = $this->featuresName;
        $this->subscription->features           = $this->features;
        $this->subscription->school_id          = @$this->school->id;

        $this->subscription->status             = ($source == 'admin' || $old_school) ? SubscriptionStatus::APPROVED : SubscriptionStatus::PENDING;
        // $this->subscription->payment_status     = $source == 'website' ? 1 : 0;

        $this->subscription->trx_id             = $trx_id;
        $this->subscription->method             = $payment_method;

        $this->subscription->save();
        if ($old_school) {
            $tenant = Tenant::where('id', $this->school->sub_domain_key)->first();
            $this->subscriptionUpdateInTenant($this->subscription, $tenant?->tenancy_db_name);
        }
        $this->storeDataInSession($payment_method);
        return $this->subscription;
    }

    protected function storeDataInSession($payment_method)
    {
        $data                               = [];
        $data['to_name']                    = $this->school->name;
        $data['to_email']                   = $this->school->email;
        $data['to_phone']                   = $this->school->phone;
        $data['invoice_no']                 = uniqid();
        $data['package_name']               = $this->package->name;
        $data['package_duration']           = $this->package->duration;
        $data['package_duration_number']    = $this->package->duration_number;
        $data['package_amount']             = $this->package->price;
        $data['payment_method']             = Str::lower($payment_method) == 'stripe' ? 'Stripe' : null;
        $data['previous_due']               = session()->get('previousDue');

        session()->put('data', $data);
    }

    protected function addPackageInfoInSession()
    {
        session()->put('payment_type',   $this->package->payment_type);
        session()->put('name',           $this->package->name);
        session()->put('price',          $this->package->price);
        session()->put('student_limit',  $this->package->student_limit);
        session()->put('staff_limit',    $this->package->staff_limit);
        session()->put('expiry_date',    $this->expiryDate ? date('Y-m-d', strtotime($this->expiryDate)) : null);
        session()->put('features',       $this->features);
        session()->put('features_name',  $this->featuresName);

        $subscription_info = [];
        $subscription_info['payment_type'] =  $this->package->payment_type;
        $subscription_info['name'] =           $this->package->name;
        $subscription_info['price'] =          $this->package->price;
        $subscription_info['student_limit'] =  $this->package->student_limit;
        $subscription_info['staff_limit'] =    $this->package->staff_limit;
        $subscription_info['expiry_date'] =    $this->expiryDate ? date('Y-m-d', strtotime($this->expiryDate)) : null;
        $subscription_info['features'] =       $this->features;
        $subscription_info['features_name'] =  $this->featuresName;

        session()->put('subscription_info', $subscription_info);

    }

    protected function storeAdminUserInfoInSession($request)
    {
        session()->put('admin_name',  $request['name']);
        session()->put('admin_phone', $request['phone']);
        session()->put('admin_email', $request['email']);
    }

    protected function runTenant($request)
    {
        $tenant = Tenant::create(['id' => $request['sub_domain_key']]);
        $tenant->domains()->create(['domain' => $request['sub_domain_key'] . '.' . env('APP_MAIN_APP_URL', 'school-management.test')]);
    }






}
