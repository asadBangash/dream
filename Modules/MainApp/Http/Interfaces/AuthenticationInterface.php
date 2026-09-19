<?php

namespace Modules\MainApp\Http\Interfaces;

interface AuthenticationInterface
{
    public function login($request);

    public function logout();
}
