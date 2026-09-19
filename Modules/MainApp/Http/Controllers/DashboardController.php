<?php

namespace Modules\MainApp\Http\Controllers;

use Illuminate\Support\Str;
use function Ramsey\Uuid\v1;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Modules\MainApp\Entities\Subscription;
use Modules\MainApp\Http\Repositories\FAQRepository;
use Modules\MainApp\Http\Repositories\SchoolRepository;
use Modules\MainApp\Http\Repositories\FeatureRepository;
use Modules\MainApp\Http\Repositories\PackageRepository;

class DashboardController extends Controller
{
    private $schoolRepo;
    private $featureRepo;
    private $packageRepo;
    private $faqRepo;

    function __construct(
        SchoolRepository  $schoolRepo,
        FeatureRepository $featureRepo,
        PackageRepository $packageRepo,
        FAQRepository     $faqRepo,
    )
    {
        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        } 
        $this->schoolRepo  = $schoolRepo;
        $this->featureRepo = $featureRepo;
        $this->packageRepo = $packageRepo;
        $this->faqRepo     = $faqRepo;
    }

    public function index(Request $request)
    {


        $now      = now(); // Get the current date and time
 
        $lastYear = now()->subYear(); // Calculate the date from 12 months ago

        $monthlySummations = Subscription::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(price) as total_amount')
        )
        ->whereBetween('created_at', [$lastYear, $now]) // Filter transactions for the last 12 months
        ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->where('payment_status', 1)
        ->get();

        $months  = [];
        $incomes = [];

        foreach ($monthlySummations as $month) {
            $months[]  = date('"M Y"', strtotime($month['year']. '-'.$month['month']));
            $incomes[] = $month['total_amount'];
        }

        $data['months']            = $months;
        $data['incomes']           = $incomes;
        $data['totalSchool']       = $this->schoolRepo->all()->count();
        $data['activeSchools']     = $this->schoolRepo->activeAll()->count();
        $data['inactiveSchools']   = $data['totalSchool'] - $data['activeSchools'];

        $data['totalFeature'] = $this->featureRepo->all()->count();
        $data['totalPackage'] = $this->packageRepo->all()->count();
        $data['totalFAQ']     = $this->faqRepo->all()->count();

        return view('mainapp::dashboard', compact('data'));
    }
}
