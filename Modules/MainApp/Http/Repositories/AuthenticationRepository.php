<?php

namespace Modules\MainApp\Http\Repositories;

use Illuminate\Support\Facades\Auth;
use Modules\MainApp\Http\Interfaces\AuthenticationInterface;

class AuthenticationRepository implements AuthenticationInterface
{

    public function login($request)
    {
        if (filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
            // email
            $authenticate  = Auth::attempt([
                'email'    => data_get($request, 'email'),
                'password' => data_get($request, 'password')
            ], data_get($request, 'rememberMe') ? true : false);
        } else {
            // phone
            $authenticate  = Auth::attempt([
                'phone'    => data_get($request, 'email'),
                'password' => data_get($request, 'password')
            ], data_get($request, 'rememberMe') ? true : false);
        }


        if($authenticate) {
            return true;
        }
        return false;
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();
        return true;
    }

}
