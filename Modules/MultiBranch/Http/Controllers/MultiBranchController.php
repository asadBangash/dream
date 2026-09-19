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
            $user = auth()->user();
            $user->branch_id = $request->branch_id;
            $user->save();
            return redirect()->back()->with('success', ___('alert.branch changed successfully'));
        }catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back();
        }
    }
}
