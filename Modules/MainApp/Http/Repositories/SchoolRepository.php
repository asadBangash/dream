<?php

namespace Modules\MainApp\Http\Repositories;

use PDO;
use App\Enums\Status;
use App\Models\Tenant;
use App\Enums\Settings;
use Illuminate\Support\Str;
use App\Enums\PricingDuration;
use App\Enums\SubscriptionStatus;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use Modules\MainApp\Entities\School;
use Modules\MainApp\Entities\Package;
use Illuminate\Support\Facades\Session;
use Modules\MainApp\Jobs\SaasSchoolApproveJob;
use Modules\MainApp\Entities\Subscription;
use Modules\MainApp\Services\SaaSSchoolService;
use Modules\MainApp\Http\Interfaces\SchoolInterface;

class SchoolRepository implements SchoolInterface
{
    use ReturnFormatTrait;
    private $model;

    public function __construct(School $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model::all();
    }

    public function activeAll()
    {
        return $this->model::active()->get();
    }

    public function getAll()
    {
        return $this->model->latest()->paginate(Settings::PAGINATE);
    }

    public function store($request)
    {
        try {
            $source = $request->source ?? 'website';
            $request->merge(['package_id' => $request->package]);

            $school = $this->storeSchool($request, $source);
            $subscription = $this->storeSubscription($request, $school, $payment_method = null);

            if (($source == 'admin')) {
                SaasSchoolApproveJob::dispatch($subscription);
            }

            return $this->responseWithSuccess(___('alert.created_successfully_it_will_be_active_soon'), []);
        } catch (\Throwable $th) {
            // Log the error instead of using dd()
            \Log::error('School store error: ' . $th->getMessage());
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }


    protected function storeSchool($request, $source)
    {
        $school = School::where('sub_domain_key', $request['sub_domain_key'])->first();
        if (!$school) {
            $school                    = new School();
            $school->sub_domain_key     = $request['sub_domain_key'];
            $school->name               = $request['name'];
            $school->package_id         = $request['package_id'];
            $school->address            = $request['address'];
            $school->phone              = $request['phone'];
            $school->email              = $request['email'];
            $school->status             = Status::INACTIVE;
            $school->save();
        }
        return $school;

    }

    protected function storeSubscription($request, $school, $payment_method)
    {
        $features             = [];
        $featuresName         = [];
        $package              = Package::where('id', $request['package_id'])->first();
        $source = 'admin';
        $trx_id = Str::uuid();

        foreach (@$package->packageChilds ?? [] as $value) {
            $features[]       = @$value->feature->key;
            $featuresName[]   = @$value->feature->title;
        }


        if ($package->duration == PricingDuration::DAYS) {
            $expiryDate = date("Y-m-d", strtotime("+ " . $package->duration_number . " day"));
        } elseif ($package->duration == PricingDuration::MONTHLY) {
            $expiryDate = date("Y-m-d", strtotime("+ " . $package->duration_number . " month"));
        } elseif ($package->duration == PricingDuration::YEARLY) {
            $expiryDate = date("Y-m-d", strtotime("+ " . $package->duration_number . " year"));
        }

        $old_school = false;
        if (Subscription::where('school_id', $school->id)->first()) {
            $old_school = true;
        }

        $subscription                     = new Subscription();
        $subscription->package_id         = @$package->id;
        $subscription->price              = @$package->price;
        $subscription->student_limit      = @$package->student_limit;
        $subscription->staff_limit        = @$package->staff_limit;
        $subscription->expiry_date        = $expiryDate ? date('Y-m-d', strtotime($expiryDate)) : null;
        $subscription->features_name      = $featuresName;
        $subscription->features           = $features;
        $subscription->school_id          = @$school->id;

         $subscription->status             =  0;
        // $subscription->payment_status     = $source == 'website' ? 1 : 0;

        $subscription->trx_id             = @$trx_id;
        $subscription->method             = $payment_method;
        $subscription->save();
        return $subscription;
    }


    public function show($id)
    {
        return $this->model->find($id);
    }

    public function update($request, $id)
    {
        try {

            $row                 = $this->model->findOrfail($id);
            $row->name           = $request->name;
            $row->status         = $request->status;
            $row->save();

            return $this->responseWithSuccess(___('alert.updated_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $row = $this->model->find($id);
            $row->delete();

            $tenant = Tenant::where('id', $row->sub_domain_key)->first();
            $tenant->delete();

            $dbConnection = config('database.default'); // Get the default database connection name from config
            $dbConfig = config("database.connections.$dbConnection");

            $dbh = new PDO(
                "mysql:host={$dbConfig['host']};port={$dbConfig['port']}",
                $dbConfig['username'],
                $dbConfig['password']
            );

            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $dbName = $tenant->tenancy_db_name;

            $sql = "DROP DATABASE IF EXISTS $dbName"; // Add IF EXISTS to avoid errors if the database doesn't exist
            $result = $dbh->exec($sql);

            DB::beginTransaction();
            DB::commit();
            if ($result !== false) {
                return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
            } else {
                return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }
}
