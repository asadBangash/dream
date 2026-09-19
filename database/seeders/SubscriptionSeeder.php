<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Subscription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $row                = new Subscription();
        $row->payment_type  = Session::get('payment_type') ?? 'prepaid';
        $row->name          = Session::get('plan_name');
        $row->price         = Session::get('price');
        $row->student_limit = Session::get('student_limit');
        $row->staff_limit   = Session::get('staff_limit');
        $row->expiry_date   = Session::get('expiry_date');
        $row->features_name = Session::get('features_name');
        $row->features      = Session::get('features');
        $row->trx_id        = Session::get('trx_id');
        $row->method        = Session::get('method');
        $row->status        = Status::ACTIVE;
        $row->save();
    }
}
