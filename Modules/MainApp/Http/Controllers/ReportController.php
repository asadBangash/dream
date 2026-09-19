<?php

namespace Modules\MainApp\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Modules\MainApp\Http\Repositories\ReportRepository;

class ReportController extends Controller
{
    private $repo;

    function __construct(ReportRepository $repo)
    {
 
        $this->repo        = $repo; 
    }

    public function index()
    {
        $data['title'] = ___('settings.Payment Report');
        return view('mainapp::reports.payment-report', compact('data'));
    }

    public function search(Request $request)
    {
        $result = $this->repo->search($request);

        
        if($result['status']){

            $data['title'] = ___('settings.Payment Report');
            $data['subscriptions']          = $result['data']['subscriptions'];
            $data['dates']                  = $result['data']['dates'];
            $data['total']                  = $result['data']['total'];
            return view('mainapp::reports.payment-report', compact('data'));
        }
        return back()->with('danger', $result['message']);
    }


}
