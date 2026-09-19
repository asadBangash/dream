<?php

namespace Modules\MainApp\Http\Repositories;

use App\Models\User;
use App\Traits\CommonHelperTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\MainApp\Http\Interfaces\UserInterface;

class UserRepository implements UserInterface
{
    use CommonHelperTrait;
    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function profileUpdate($request, $id)
    {
        try {
            $userUpdate                 = $this->model->findOrfail($id);
            $userUpdate->name           = $request->name;
            $userUpdate->phone          = $request->phone;
            if(Auth::user()->role_id != 7)
                $userUpdate->date_of_birth = $request->date_of_birth;
            $userUpdate->upload_id      = $this->UploadImageUpdate($request->image, 'backend/uploads/users', $userUpdate->upload_id);
            $userUpdate->save();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function passwordUpdate($request, $id)
    {
        try {
            $userUpdate             = $this->model->findOrfail($id);
            $userUpdate->password   = Hash::make($request->password);
            $userUpdate->save();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
