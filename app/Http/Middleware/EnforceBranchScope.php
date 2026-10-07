<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnforceBranchScope
{
    public function handle(Request $request, Closure $next)
    {
        if (! hasModule('MultiBranch') || ! auth()->check()) {
            return $next($request);
        }

        if (isSuperAdmin()) {
            if (in_array($request->method(), ['POST', 'PUT', 'PATCH'], true)) {
                $active = superAdminActiveBranchId();
                if ($active && ! $request->filled('branch_id')) {
                    $request->merge(['branch_id' => $active]);
                }
            }

            return $next($request);
        }

        $branchId = (int) auth()->user()->branch_id;

        if ($branchId < 1) {
            abort(403, 'No branch assigned to this account.');
        }

        if ($request->has('branch_id') && (int) $request->input('branch_id') !== $branchId) {
            abort(403, 'Unauthorized branch access.');
        }

        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'], true)) {
            $request->merge(['branch_id' => $branchId]);
        }

        return $next($request);
    }
}
