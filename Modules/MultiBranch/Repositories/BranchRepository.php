<?php

namespace Modules\MultiBranch\Repositories;

use App\Enums\RoleEnum;
use App\Models\Role;
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
            $branch->status = $request->status ?? \App\Enums\Status::ACTIVE;
            $branch->country_id = 1;
            $branch->save();

            $this->assignBranchAdmin($branch->id, $request);
        });

        return true;
    }

    public function update($request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $branch = $this->model->findOrFail($id);
            $branch->name = $request->name;
            $branch->phone = $request->phone;
            $branch->email = $request->email;
            $branch->address = $request->address;
            $branch->lat = $request->lat;
            $branch->long = $request->long;
            if ($request->filled('status')) {
                $branch->status = $request->status;
            }
            $branch->country_id = 1;
            $branch->save();

            if ($request->filled('branch_admin_user_id') || $request->filled('user.email')) {
                $this->assignBranchAdmin((int) $id, $request);
            }
        });

        return true;
    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function delete($id)
    {
        try {
            if ((int) $id === 1 && $this->model->count() <= 1) {
                return $this->responseWithError(___('branch.cannot_delete_last_branch'), []);
            }

            $row = $this->model->find($id);
            if (! $row) {
                return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
            }

            $row->delete();

            return $this->responseWithSuccess(___('alert.deleted_successfully'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    public function bulkDelete(array $ids): array
    {
        $ids = array_values(array_unique(array_map('intval', $ids)));
        $ids = array_filter($ids, fn ($id) => $id > 0);

        if ($ids === []) {
            return $this->responseWithError(___('branch.no_branches_selected'), []);
        }

        $remaining = $this->model->whereNotIn('id', $ids)->count();
        if ($remaining < 1) {
            return $this->responseWithError(___('branch.cannot_delete_last_branch'), []);
        }

        try {
            DB::transaction(function () use ($ids) {
                $this->model->whereIn('id', $ids)->delete();
            });

            return $this->responseWithSuccess(___('alert.deleted_successfully'), ['deleted' => count($ids)]);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong_please_try_again'), []);
        }
    }

    protected function assignBranchAdmin(int $branchId, $request): void
    {
        $adminPermissions = Role::find(RoleEnum::ADMIN)?->permissions ?? [];
        $staffPermissions = Role::find(RoleEnum::STAFF)?->permissions ?? [];

        if ($request->filled('branch_admin_user_id')) {
            $newAdminId = (int) $request->branch_admin_user_id;

            User::query()
                ->where('branch_id', $branchId)
                ->where('role_id', RoleEnum::ADMIN)
                ->where('id', '!=', $newAdminId)
                ->update([
                    'role_id' => RoleEnum::STAFF,
                    'permissions' => $staffPermissions,
                ]);

            $user = $this->userModel->findOrFail($newAdminId);
            $user->role_id = RoleEnum::ADMIN;
            $user->branch_id = $branchId;
            $user->permissions = $adminPermissions;
            $user->email_verified_at = $user->email_verified_at ?? now();
            $user->save();

            return;
        }

        if (! empty($request->user['email'])) {
            User::query()
                ->where('branch_id', $branchId)
                ->where('role_id', RoleEnum::ADMIN)
                ->update([
                    'role_id' => RoleEnum::STAFF,
                    'permissions' => $staffPermissions,
                ]);

            $user = new $this->userModel;
            $user->name = $request->user['name'];
            $user->email = $request->user['email'];
            $user->role_id = RoleEnum::ADMIN;
            $user->branch_id = $branchId;
            $user->permissions = $adminPermissions;
            $user->email_verified_at = now();
            $user->password = Hash::make($request->user['password']);
            $user->save();
        }
    }
}
