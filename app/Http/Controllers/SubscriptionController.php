<?php

namespace App\Http\Controllers;

use App\Enums\Settings;
use App\Models\StudentInfo\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\MainApp\Entities\School;
use Illuminate\Support\Facades\Config;
use Modules\MainApp\Entities\Subscription;

class SubscriptionController extends Controller
{
    public function index(){
        // Switch to the main database connection
        // config(['database.connections.mysql']);
        // DB::reconnect('mysql');


        // // // Define your dynamic database configuration
        // $databaseConfig = [
        //     'driver' => 'mysql',
        //     'host' => 'localhost',
        //     'database' => 'school_db',
        //     'username' => 'root',
        //     'password' => 'password',
        // ];

        // // Set the configuration for the new connection
        // Config::set('database.connections.dynamic_connection', $databaseConfig);



        // $dynamicDB = Subscription::on('dynamic_connection')->get();
        // // $dynamicDB = Subscription::get();
        // dd($dynamicDB);


        $data['title']              = ___('common.Subscription');
        $data['subscriptions']      = Subscription::orderBy('id', 'desc')->paginate(Settings::PAGINATE);
        $data['activeSubscription'] = Subscription::where('status', 1)->first();
        $data['totalStudents']      = Student::count();
        // dd($data['subscriptions']);
        return view('backend.subscriptions', compact('data'));
    }
}
