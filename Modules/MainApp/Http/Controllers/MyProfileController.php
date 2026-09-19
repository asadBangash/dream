<?php

namespace Modules\MainApp\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Modules\MainApp\Http\Repositories\UserRepository;
use Modules\MainApp\Http\Requests\Profile\PasswordUpdateRequest;
use Modules\MainApp\Http\Requests\Profile\ProfileUpdateRequest;

class MyProfileController extends Controller
{
    private $userRepo;

    function __construct(UserRepository $userRepo)
    {
        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        } 
        $this->userRepo       = $userRepo;
    }

    public function profile()
    {
        $data['title'] = 'My Profile';
        return view('mainapp::my-profile.profile',compact('data'));
    }

    public function edit()
    {
        $data['user']        = $this->userRepo->show(Auth::user()->id);
        $data['title']       = "My Profile Edit";
        return view('mainapp::my-profile.edit',compact('data'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        $result = $this->userRepo->profileUpdate($request,Auth::user()->id);
        if($result){
            return redirect()->route('profile')->with('success', ___('alert.profile_updated_successfully'));
        }
        return redirect()->route('profile')->with('danger', ___('alert.something_went_wrong_please_try_again'));
    }


    public function passwordUpdate()
    {
        $data['title'] = 'Password Update';
        return view('mainapp::my-profile.update_password',compact('data'));
    }

    public function passwordUpdateStore(PasswordUpdateRequest $request)
    {
        if (Hash::check($request->current_password, Auth::user()->password)) {
            $result = $this->userRepo->passwordUpdate($request,Auth::user()->id);
            if($result){
                return redirect()->route('password-update')->with('success', ___('alert.password_updated_successfully'));
            }
            return redirect()->route('password-update')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }else {
            return back()->with('danger','Current password is incorrect');
        }
    }
}
