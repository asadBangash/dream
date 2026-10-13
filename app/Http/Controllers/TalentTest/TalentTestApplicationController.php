<?php

namespace App\Http\Controllers\TalentTest;

use App\Http\Controllers\Controller;
use App\Http\Requests\TalentTest\TalentTestApplicationStatusRequest;
use App\Enums\TalentTestApplicationStatus;
use App\Repositories\TalentTestApplicationRepository;
use Illuminate\Http\Request;

class TalentTestApplicationController extends Controller
{
    public function __construct(
        protected TalentTestApplicationRepository $repo
    ) {}

    public function index()
    {
        $data['title'] = ___('settings.talent_test_applications');
        $data['applications'] = $this->repo->paginate();
        $data['statuses'] = TalentTestApplicationStatus::labels();

        return view('backend.talent-test.index', compact('data'));
    }

    public function search(Request $request)
    {
        $data['title'] = ___('settings.talent_test_applications');
        $data['applications'] = $this->repo->search($request);
        $data['statuses'] = TalentTestApplicationStatus::labels();
        $data['request'] = $request;

        return view('backend.talent-test.index', compact('data'));
    }

    public function show($id)
    {
        $data['title'] = ___('settings.talent_test_application');
        $data['application'] = $this->repo->find($id);
        $data['statuses'] = TalentTestApplicationStatus::labels();

        return view('backend.talent-test.show', compact('data'));
    }

    public function updateStatus(TalentTestApplicationStatusRequest $request, $id)
    {
        $result = $this->repo->updateStatus($request, $id);

        if ($result['status']) {
            return redirect()->route('talent-test-applications.show', $id)->with('success', $result['message']);
        }

        return back()->with('danger', $result['message']);
    }

    public function delete($id)
    {
        $result = $this->repo->destroy($id);

        if ($result['status']) {
            $success[0] = $result['message'];
            $success[1] = 'success';
            $success[2] = ___('alert.deleted');
            $success[3] = ___('alert.OK');

            return response()->json($success);
        }

        $success[0] = $result['message'];
        $success[1] = 'error';
        $success[2] = ___('alert.oops');

        return response()->json($success);
    }
}
