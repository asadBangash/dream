<?php

namespace Modules\MultiBranch\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class MultiBranchController extends Controller
{
    public function switchBranch(Request $request)
    {
        try {
            if (! isSuperAdmin()) {
                abort(403, 'Only Super Admin can switch branches.');
            }

            $branchId = $request->input('branch_id');

            if ($branchId === null || $branchId === '' || $branchId === 'all' || (int) $branchId === 0) {
                session()->forget('active_branch_id');
            } else {
                session(['active_branch_id' => (int) $branchId]);
            }

            return redirect()->back()->with('success', ___('alert.branch changed successfully'));
        }catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back();
        }
    }
}
