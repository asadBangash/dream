<?php

namespace App\Repositories;

use App\Interfaces\AuthenticationRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Mail\EmailVerification;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthenticationRepository implements AuthenticationRepositoryInterface
{

    public function login($request)
    {
        $loginInput = $request['email'];

        if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
            // Login via email
            $authenticate = Auth::attempt([
                'email'    => $loginInput,
                'password' => data_get($request, 'password')
            ], data_get($request, 'rememberMe') ? true : false);
        } elseif (is_numeric($loginInput)) {
            // Login via phone
            $authenticate = Auth::attempt([
                'phone'    => $loginInput,
                'password' => data_get($request, 'password')
            ], data_get($request, 'rememberMe') ? true : false);
        } else {
            // Login via username
            $authenticate = Auth::attempt([
                'username' => $loginInput,
                'password' => data_get($request, 'password')
            ], data_get($request, 'rememberMe') ? true : false);
        }

        if ($authenticate) {
            return true;
        }

        return false;
    }


    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();
    }

    public function register($request)
    {
        DB::beginTransaction();
        try {
            $user                = new User();
            $user->name          = $request->name;
            $user->email         = $request->email;
            $user->phone         = $request->phone;
            $user->date_of_birth = date('yy-m-d', strtotime($request->date_of_birth));
            $user->gender        = $request->gender;
            $user->password      = Hash::make($request->password);
            $user->token         = Str::random(30);
            $user->role_id       = 4;
            $user->uuid          = Str::uuid();
            $user->save();

            \Config::set('mail.mailers.smtp.password', \Crypt::decrypt(\Config::get('mail.mailers.smtp.password')));
            Mail::to($user->email)->send(new EmailVerification($user));

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            return false;
        }
    }

    public function verifyEmail($email, $token)
    {
        try {
            $user = User::query()->firstWhere('email', $email);

            if (!$user) {
                return 'invalid_email';
            }

            if ($user->email_verified_at) {
                return 'already_verified';
            }

            if ($user->token != $token) {
                return 'invalid_token';
            }

            $user->email_verified_at = now();
            $user->token             = null;
            $user->save();
            return 'success';
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function forgotPassword($request)
    {
        try {
            $user = User::query()->firstWhere('email', $request->email);

            if (!$user) {
                return 'invalid_email';
            }

            $user->token             = Str::random(30);
            $user->save();

            // decrypt mail password

            \Config::set('mail.mailers.smtp.password', \Crypt::decrypt(setting('mail_password')));
            Mail::to($user->email)->send(new ResetPassword($user));

            return 'success';
        } catch (\Throwable $th) {
            info($th);
            return false;
        }
    }

    public function resetPasswordPage($email, $token)
    {
        try {
            $user = User::query()->firstWhere('email', $email);

            if (!$user) {
                return 'invalid_email';
            }

            if ($user->token != $token) {
                return 'invalid_token';
            }

            return 'success';
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function resetPassword($request)
    {
        try {
            $user = User::query()->firstWhere('email', $request->email);

            if (!$user) {
                return 'invalid_email';
            }

            if ($user->token != $request->token) {
                return 'invalid_token';
            }

            $user->password = Hash::make($request->password);
            $user->token    = null;
            $user->save();

            return 'success';
        } catch (\Throwable $th) {
            return false;
        }
    }
}
