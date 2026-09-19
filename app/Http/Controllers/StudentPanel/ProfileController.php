<?php

namespace App\Http\Controllers\StudentPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\StudentPanel\Profile\ProfileUpdateRequest;
use App\Http\Requests\StudentPanel\Profile\PasswordUpdateRequest;

class ProfileController extends Controller
{
    private $user;

    function __construct(UserInterface $userInterface)
    {

        if (!Schema::hasTable('settings') && !Schema::hasTable('users')  ) {
            abort(400);
        } 
        $this->user       = $userInterface;
    }

    public function profile()
    {
        $data['title'] = 'Profile';
        return view('student-panel.profile.profile',compact('data'));
    }

    public function edit()
    {
        $data['user']        = $this->user->show(Auth::user()->id);
        $data['title']       = "Profile Edit";
        return view('student-panel.profile.edit',compact('data'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        $result = $this->user->profileUpdate($request,Auth::user()->id);
        if($result){
            return redirect()->route('student-panel.profile')->with('success', ___('alert.profile_updated_successfully'));
        }
        return redirect()->route('student-panel.profile')->with('danger', ___('alert.something_went_wrong_please_try_again'));
    }


    public function passwordUpdate()
    {
        $data['title'] = 'Password Update';
        return view('student-panel.profile.update_password',compact('data'));
    }

    public function passwordUpdateStore(PasswordUpdateRequest $request)
    {
        if (Hash::check($request->current_password, Auth::user()->password)) {
            $result = $this->user->passwordUpdate($request,Auth::user()->id);
            if($result){
                return redirect()->route('student-panel.password-update')->with('success', ___('alert.password_updated_successfully'));
            }
            return redirect()->route('student-panel.password-update')->with('danger', ___('alert.something_went_wrong_please_try_again'));
        }else {
            return back()->with('danger','Current password is incorrect');
        }
    }
}
