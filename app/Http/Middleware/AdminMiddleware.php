<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ((auth()->check()) && (auth()->user()->role_id == RoleEnum::ADMIN || auth()->user()->role_id == RoleEnum::SUPERADMIN || auth()->user()->role_id == RoleEnum::STAFF)) {
            return $next($request);
        } else if ((auth()->check()) && (auth()->user()->role_id == RoleEnum::TEACHER)) {
            return redirect('instructor/dashboard')->with('error', ___('alert.You are not authorized to access this page'));
        } else if ((auth()->check()) && (auth()->user()->role_id == RoleEnum::STUDENT)) {
            return redirect('student/dashboard')->with('error', ___('alert.You are not authorized to access this page'));
        } else if ((auth()->check()) && (auth()->user()->role_id == RoleEnum::GUARDIAN)) {
            return redirect('organization/dashboard')->with('error', ___('alert.You are not authorized to access this page'));
        }
        return redirect('/login');
    }
}
