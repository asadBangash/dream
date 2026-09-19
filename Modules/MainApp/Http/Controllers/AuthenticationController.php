<?php

namespace Modules\MainApp\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
use Modules\MainApp\Entities\User;
use Modules\MainApp\Http\Requests\LoginRequest;
use Modules\MainApp\Http\Repositories\AuthenticationRepository;

class AuthenticationController extends Controller
{
    private $repo;

    public function __construct(AuthenticationRepository $repo)
    {
        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            Artisan::call('migrate:fresh', ['--force' => true ]);
            Artisan::call('db:seed', ['--force' => true ]);
        } 
        $this->repo = $repo;
    }

    public function loginPage()
    {
        $data['title'] = 'Login';
        return view('mainapp::login', compact('data'));
    }

    public function login(LoginRequest $request)
    {
        $email      = $request->safe()->only(['email']);
        $password   = $request->safe()['password'];
        $user       = User::query()->firstWhere('email', $email);
        if(!$user)
            $user   = User::query()->firstWhere('phone', $email);
        
        if (!$user) {
            return back()->withErrors([
                'email' =>  ___('users_roles.the_provided_email_do_not_match_our_records')
            ]);
        }

        if (!Hash::check($password, $user->password)) {
            return back()->withErrors([
                'password' => ___('users_roles.the_provided_password_does_not_match_our_records')
            ]);
        }

        if($this->repo->login($request->all())) {
            return redirect()->route('dashboard');
        }
        return back()->with('danger', ___('users_roles.something_went_wrong_please_try_again'));
    }

    public function logout(Request $request)
    {
        $this->repo->logout();
        return redirect()->route('login');
    }
}
