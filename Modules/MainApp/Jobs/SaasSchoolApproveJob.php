<?php

namespace Modules\MainApp\Jobs;

use App\Enums\Status;
use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use App\Enums\SubscriptionStatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SaasSchoolApproveJob implements ShouldQueue
{
    // Queueable,
    //implements ShouldQueue
    use Dispatchable, InteractsWithQueue,SerializesModels,Queueable;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
         \Log::info("TestJob ran successfully 2.");
        $this->data = $data;
        \Log::info("TestJob Data");
         \Log::info([$this->data]);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
          \Log::info("TestJob ran successfully 3.");
        if (!defined('STDIN')) {
            define('STDIN', fopen('php://stdin', 'r'));
        }
        try {
            Artisan::call('optimize:clear');
            $subscription = $this->data;
            $school = $subscription->school;

            if (isset($school) && isset($subscription)) {
                $tenant_key = $subscription->school->sub_domain_key;
                $this->storeDataInInputSession($subscription);

                $tenant = Tenant::create(['id' => $tenant_key]);
                $tenant->domains()->create(['domain' => $tenant_key . '.' . env('APP_MAIN_APP_URL', 'school-management.test')]);


                // Artisan::call('tenants:seed', [
                //     '--tenants' => [$tenant_key],
                // ]);

                // $seedOutput = Artisan::output();
                 // Log it
                // Log::info("Tenant Seeder Output for Tenant ID $tenant_key:\n" . $seedOutput);

                $subscription->status = SubscriptionStatus::APPROVED;
                $subscription->save();

                $school->status = Status::ACTIVE;
                $school->save();
                
                $this->removeDataInInputSession();
            }
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }

    public function storeDataInInputSession($subscription)
    {
        info('storeDataInInputSession');
        info('application info', [
            'application_name' => $subscription->school->name,
            'address' => $subscription->school->address,
            'admin_phone' => $subscription->school->phone,
        ]);
         info('END storeDataInInputSession');

        Session::put('school_name', $subscription->school->name);
        Session::put('admin_phone', $subscription->school->phone);
        Session::put('admin_email', $subscription->school->email);
        Session::put('address', $subscription->school->address);
        Session::put('payment_type', 'prepaid');
        Session::put('plan_name', @$subscription->package->name);
        Session::put('price', $subscription->price);
        Session::put('student_limit', $subscription->student_limit);
        Session::put('staff_limit', $subscription->staff_limit);
        Session::put('expiry_date', $subscription->expiry_date);
        Session::put('features_name', $subscription->features_name);
        Session::put('features', $subscription->features);
        Session::put('trx_id', $subscription->trx_id);
        Session::put('method', $subscription->method);
    }


    public function removeDataInInputSession()
        {
            info('removeDataInInputSession');
            Session::forget('school_name');
            Session::forget('admin_phone');
            Session::forget('admin_email');
            Session::forget('address',);
            Session::forget('payment_type');
            Session::forget('plan_name');
            Session::forget('price');
            Session::forget('student_limit');
            Session::forget('staff_limit');
            Session::forget('expiry_date');
            Session::forget('features_name');
            Session::forget('features');
            Session::forget('trx_id');
            Session::forget('method');
        }
}
