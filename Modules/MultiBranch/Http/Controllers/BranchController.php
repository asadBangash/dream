<?php

namespace Modules\MultiBranch\Http\Controllers;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\MultiBranch\Http\Requests\BranchStoreRequest;
use Modules\MultiBranch\Http\Requests\BranchUpdateRequest;
use Modules\MultiBranch\Interfaces\BranchInterface;

class BranchController extends Controller
{
    protected $branch;

    public function __construct(BranchInterface $branchInterface)
    {
        $this->branch = $branchInterface;
    }

    public function index()
    {
        $data['title'] = ___('multibranch.branches');
        $data['branches'] = $this->branch->paginate(10);
        $branchIds = $data['branches']->pluck('id');
        $data['branchAdmins'] = User::query()
            ->where('role_id', RoleEnum::ADMIN)
            ->whereIn('branch_id', $branchIds)
            ->get()
            ->keyBy('branch_id');

        return view('multibranch::branch.index')->with($data);
    }

    public function create()
    {
        $data['title'] = ___('multibranch.create branch');
        $data['countries'] = [];
        $data['branchAdminCandidates'] = $this->branchAdminCandidates();
        $data['currentBranchAdmin'] = null;

        return view('multibranch::branch.create')->with($data);
    }

    public function store(BranchStoreRequest $request)
    {
        try {
            $this->branch->store($request);

            return redirect()->route('branch.index')->with('success', ___('alert.successfully created'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('danger', ___('alert.something went wrong'));
        }
    }

    public function edit($id)
    {
        $data['title'] = ___('branch.edit_branch');
        $data['branch'] = $this->branch->show($id);
        $data['branchAdminCandidates'] = $this->branchAdminCandidates();
        $data['currentBranchAdmin'] = User::query()
            ->where('role_id', RoleEnum::ADMIN)
            ->where('branch_id', $id)
            ->first();

        return view('multibranch::branch.edit')->with($data);
    }

    public function update(BranchUpdateRequest $request, $id): RedirectResponse
    {
        try {
            $this->branch->update($request, $id);

            return redirect()->route('branch.index')->with('success', ___('alert.successfully updated'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return back()->with('danger', ___('alert.something went wrong'));
        }
    }

    public function destroy($id)
    {
        $result = $this->branch->delete($id);
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

    public function bulkDestroy(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
        ]);

        $result = $this->branch->bulkDelete($request->input('ids', []));

        if ($result['status']) {
            return response()->json([
                $result['message'],
                'success',
                ___('alert.deleted'),
                ___('alert.OK'),
            ]);
        }

        return response()->json([
            $result['message'],
            'error',
            ___('alert.oops'),
            ___('alert.OK'),
        ]);
    }

    protected function branchAdminCandidates()
    {
        return User::query()
            ->whereIn('role_id', [RoleEnum::ADMIN, RoleEnum::STAFF, RoleEnum::TEACHER])
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'branch_id', 'role_id']);
    }
}
