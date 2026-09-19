<?php

namespace App\Http\Controllers\Report;

use App\Enums\AccountHeadType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Academic\ClassesRepository;
use App\Repositories\Academic\ClassSetupRepository;
use App\Repositories\Accounts\AccountHeadRepository;
use App\Repositories\StudentInfo\StudentRepository;
use App\Repositories\Examination\ExamAssignRepository;
use App\Repositories\Report\AccountRepository;
use App\Repositories\Report\FeesCollectionRepository;
use App\Repositories\Report\MeritListRepository;
use Illuminate\Support\Facades\Crypt;
use PDF;

class AccountController extends Controller
{
    private $repo;
    private $accountHeadRepo;

    function __construct(
        AccountRepository      $repo,
        AccountHeadRepository  $accountHeadRepo,
    )
    {
        $this->repo              = $repo;
        $this->accountHeadRepo   = $accountHeadRepo;
    }

    public function index()
    {
        $data['account_head'] = $this->accountHeadRepo->getIncomeHeads();
        return view('backend.report.account', compact('data'));
    }

    public function search(Request $request)
    {
        $data                 = $this->repo->search($request);
        $data['request']      = $request;

        if($data['request']->type == AccountHeadType::INCOME)
            $data['account_head'] = $this->accountHeadRepo->getIncomeHeads();
        else
            $data['account_head'] = $this->accountHeadRepo->getExpenseHeads();

        // dd($data);
        return view('backend.report.account', compact('data'));
    }

    public function getAccountTypes(Request $request){
        if($request->id == AccountHeadType::INCOME)
            return $this->accountHeadRepo->getIncomeHeads();
        else
            return $this->accountHeadRepo->getExpenseHeads();
    }

    public function generatePDF(Request $request)
    {
        $request = new Request([
            'type'         => $request->type,
            'head'         => $request->head,
            'dates'        => $request->dates,
        ]);

        $data                 = $this->repo->searchPDF($request);

        $pdf = PDF::loadView('backend.report.accountPDF', compact('data'));
        return $pdf->download('account'.'_'.date('d_m_Y').'.pdf');
    }
}
