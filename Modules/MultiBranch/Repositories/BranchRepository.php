<?php


namespace Modules\MultiBranch\Repositories;


use App\Enums\RoleEnum;
use App\Models\User;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\MultiBranch\Entities\Branch;
use Modules\MultiBranch\Interfaces\BranchInterface;

class BranchRepository implements BranchInterface
{
    use ReturnFormatTrait;

    protected $model;
    protected $userModel;

    public function __construct(Branch $model, User $user)
    {
        $this->model = $model;
        $this->userModel = $user;
    }

    public function all()
    {
        return $this->model->all();
    }


    public function paginate($limit = 10)
    {
        return $this->model->latest('id')->paginate($limit);
    }


    public function store($request)
    {
        DB::transaction(function () use ($request) {
            $branch = new $this->model;
            $branch->name = $request->name;
            $branch->phone = $request->phone;
            $branch->email = $request->email;
            $branch->address = $request->address;
            $branch->lat = $request->lat;
            $branch->long = $request->long;
            $branch->country_id = 1;
            $branch->save();

            $user = new $this->userModel;
            $user->name = $request->user['name'];
            $user->email = $request->user['email'];
            $user->role_id = RoleEnum::ADMIN;
            $user->branch_id = $branch->id;
            $user->password = Hash::make($request->user['password']);
            $user->save();
        });

        return true;
    }

    public function update($request, $id)
    {
        $branch = $this->model->findOrFail($id);
        $branch->name = $request->name;
        $branch->phone = $request->phone;
        $branch->email = $request->email;
        $branch->address = $request->address;
        $branch->lat = $request->lat;
        $branch->long = $request->long;
        $branch->country_id = 1;
        $branch->save();
        return true;
    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function delete($id)
    {
        try {
            $row = $this->model->find($id);
            $row->delete();
            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

}
