<?php

namespace Modules\MainApp\Http\Repositories;

use App\Enums\Status;
use App\Models\Tenant;
use App\Enums\Settings;
use App\Enums\PricingDuration;
use App\Enums\SubscriptionStatus;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use Modules\MainApp\Entities\School;
use Modules\MainApp\Entities\Package;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Modules\MainApp\Entities\Subscription;
use Modules\MainApp\Traits\SaasHelperTrait;
use Modules\MainApp\Services\SaaSSchoolService;
use Modules\MainApp\Http\Interfaces\SubscriptionInterface;
use Modules\MainApp\Jobs\SaasSchoolApproveJob;

class SubscriptionRepository implements SubscriptionInterface
{
    use ReturnFormatTrait, SaasHelperTrait;
    private $model;
    protected $school;
    protected $subscription;
    protected $expiryDate;
    protected $package;
    protected $features;
    protected $featuresName;
    protected $saasSchool;

    public function __construct(Subscription $model)
    {
        $this->model = $model;
        $this->saasSchool = new SaaSSchoolService();
    }

    public function all()
    {
        return $this->model->active()->get();
    }

    public function getAll()
    {
        return $this->model->latest()->paginate(Settings::PAGINATE);
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function approved($request, $id)
    {


            $this->saasSchool->cacheForget();
            $subscription = $this->model->find($id);

            // $this->updateSchoolStatus($subscription->school_id, Status::ACTIVE);
            $tenant = Tenant::where('id', $this->school->sub_domain_key)->first();

            if ($tenant){
                $this->subscriptionUpdateInTenant($subscription, $tenant?->tenancy_db_name);
            } else {
                if($request->status == SubscriptionStatus::APPROVED) {
                     \Log::info("TestJob ran successfully 1.");
                     SaasSchoolApproveJob::dispatch($subscription);
                }
                else{
                    $this->subscription->status = $request->status;
                    $this->subscription->save();
                }
            }

        return $this->responseWithSuccess(___('alert.updated_successfully_it_takse_a_few_minutes'), []);
    }

    protected function updateSchoolStatus($school_id, $status)
    {
        $this->school               = School::find($school_id);
        $this->school->status       = $status;
        $this->school->save();
    }

    protected function storeAdminUserInfoInSession()
    {
        session()->put('admin_name',  @$this->school->name);
        session()->put('admin_phone', @$this->school->phone);
        session()->put('admin_email', @$this->school->email);
    }

    protected function featureInfo()
    {
        $this->features             = [];
        $this->featuresName         = [];
        $this->package              = Package::where('id', @$this->school->package_id)->first();

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
    }

    public function storeSubscriptionInfoInSession()
    {
        session()->put('payment_type',      $this->package->payment_type);
        session()->put('name',              $this->package->name);
        session()->put('price',             $this->package->price);
        session()->put('student_limit',     $this->package->student_limit);
        session()->put('staff_limit',       $this->package->staff_limit);
        session()->put('expiry_date',       $this->expiryDate ? date('Y-m-d', strtotime($this->expiryDate)) : null);
        session()->put('features',          $this->features);
        session()->put('features_name',     $this->featuresName);
        session()->put('trx_id',            $this->school->trx_id);
        session()->put('method',            $this->school->method);
    }

    protected function runTenant()
    {
        $tenant = Tenant::create(['id' => $this->school->sub_domain_key]);
        $tenant->domains()->create(['domain' => $this->school->sub_domain_key . '.' . env('APP_MAIN_APP_URL', 'school-management.test')]);
    }

    protected function subscriptionUpdateInTenant_old($subscription, $sub_domain_key)
    {
        $this->subscription           = $subscription;
        $this->school->sub_domain_key = $sub_domain_key;


        // Switch to the main database connection
        config(['database.connections.mysql']);
        DB::reconnect('mysql');

        $db = config('tenancy.database.prefix') . $this->school->sub_domain_key;

        // // Define your dynamic database configuration
        $databaseConfig = [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => $db,
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
        ];

        // Set the configuration for the new connection
        Config::set('database.connections.dynamic_connection', $databaseConfig);
        \App\Models\Subscription::on('dynamic_connection')->update(['status' => 0]);

        \App\Models\Subscription::on('dynamic_connection')->create([
            'payment_type'  => @$this->subscription->package->payment_type,
            'name'          => @$this->subscription->package->name,
            'price'         => $this->subscription->price,
            'student_limit' => $this->subscription->student_limit,
            'staff_limit'   => $this->subscription->staff_limit,
            'expiry_date'   => $this->subscription->expiry_date ? date('Y-m-d', strtotime($this->subscription->expiry_date)) : null,
            'features_name' => $this->subscription->features_name,
            'features'      => $this->subscription->features,
            'trx_id'        => $this->subscription->trx_id,
            'method'        => $this->subscription->method,
            'status'        => Status::ACTIVE,
        ]);
    }

    public function reject($id)
    {
        try {

            DB::transaction(function () use ($id) {
                $row         = $this->model->find($id);
                $row->status = SubscriptionStatus::REJECT;
                $row->save();

                $this->updateSchoolStatus($row->school_id, Status::INACTIVE);
            });

            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        try {
            $row = $this->model->find($id);
            $row->delete();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function store($request)
    {
        try {

            DB::beginTransaction();

            $this->saasSchool->cacheForget();
            $this->school        = School::find($request->school);
            $this->package       = Package::find($request->package);
            foreach ($this->package->packageChilds ?? [] as $value) {
                $this->features[]       = @$value->feature->key;
                $this->featuresName[]   = @$value->feature->title;
            }
            $this->subscription = new $this->model();
            $this->subscription->package_id         = @$this->package->id;
            $this->subscription->price              = @$this->package->price;
            $this->subscription->student_limit      = @$this->package->student_limit;
            $this->subscription->staff_limit        = @$this->package->staff_limit;
            $this->subscription->expiry_date        = $this->expiryDate ? date('Y-m-d', strtotime($this->expiryDate)) : null;
            $this->subscription->features_name      = $this->featuresName;
            $this->subscription->features           = $this->features;
            $this->subscription->school_id          = @$this->school->id;

            $this->subscription->status             = SubscriptionStatus::APPROVED;
            $this->subscription->payment_status     = 1;
            $this->subscription->trx_id             = $request->transaction_no;
            $this->subscription->method             = $request->payment_method;


            $this->updateSchoolStatus($this->subscription->school_id, Status::ACTIVE);
            $tenant = Tenant::find($this->school->sub_domain_key);
            $tenant_db_name = $tenant?->tenancy_db_name;

            $this->subscriptionUpdateInTenant($this->subscription, $tenant_db_name);

            $this->subscription->save();

            DB::commit();

            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }



    }
}
