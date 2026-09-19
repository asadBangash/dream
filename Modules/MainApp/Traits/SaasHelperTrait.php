<?php

namespace Modules\MainApp\Traits;

use App\Enums\Status;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

trait SaasHelperTrait
{

    protected $school;
    protected $subscription;
    protected $tenant_db_name;

    protected function subscriptionUpdateInTenant($subscription, $tenant_db)
    {
        try {
            $this->subscription           = $subscription;
            $this->tenant_db_name              = $tenant_db;

            // Switch to the main database connection
            config(['database.connections.mysql']);
            DB::reconnect('mysql');

            // // Define your dynamic database configuration
            $databaseConfig = [
                'driver' => 'mysql',
                'host' => 'localhost',
                'database' => $this->tenant_db_name,
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
        } catch (\Exception $e) {
            Log::info("message" . $e->getMessage());
            dd($e);
        }
    }
}
