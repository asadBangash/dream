<?php

namespace Modules\MainApp\Http\Controllers;

use Illuminate\Http\Request;
use App\Enums\SubscriptionStatus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Modules\MainApp\Http\Requests\SubscriptionRequest;
use Modules\MainApp\Http\Repositories\SchoolRepository;
use Modules\MainApp\Http\Repositories\PackageRepository;
use Modules\MainApp\Http\Repositories\SubscriptionRepository;

class SubscriptionController extends Controller
{
    private $repo;
    private $packageRepo;
    private $schoolRepo;

    function __construct(
        SubscriptionRepository $repo,
        PackageRepository $packageRepo,
        SchoolRepository $schoolRepo,
    )
    {
        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        }
        $this->repo        = $repo;
        $this->packageRepo = $packageRepo;
        $this->schoolRepo = $schoolRepo;
    }

    public function index()
    {
        $data['subscriptions'] = $this->repo->getAll();
        $data['title']         = ___('settings.Subscriptions');

        return view('mainapp::subscription.index', compact('data'));
    }


    public function create()
    {
        $data['schools'] = $this->schoolRepo->getAll();
        $data['title']         = ___('settings.Subscriptions');
        $data['packages']     = $this->packageRepo->all();
        return view('mainapp::subscription.create', compact('data'));
    }

    public function edit($id)
    {
        $data['subscription'] = $this->repo->show($id);
        $data['title']        = ___('settings.Approve subscription');
        $data['packages']     = $this->packageRepo->all();
        return view('mainapp::subscription.edit', compact('data'));
    }

    public function approved(Request $request, $id)
    {
        if ($request->status == SubscriptionStatus::APPROVED) {
            $result = $this->repo->approved($request, $id);

        } else {
            $result = $this->repo->reject($id);
        }

        if($result['status']){
            return redirect()->route('subscription.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function store(SubscriptionRequest $request)
    {
        $result = $this->repo->store($request);

        if($result['status']){
            return redirect()->route('subscription.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function reject($id)
    {
        $result = $this->repo->reject($id);
        if($result['status']){
            return redirect()->route('subscription.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        $result = $this->repo->destroy($id);
        if($result['status']):
            $success[0] = $result['message'];
            $success[1] = 'success';
            $success[2] = ___('alert.deleted');
            $success[3] = ___('alert.OK');
            return response()->json($success);
        else:
            $success[0] = $result['message'];
            $success[1] = 'error';
            $success[2] = ___('alert.oops');
            return response()->json($success);
        endif;
    }
}
