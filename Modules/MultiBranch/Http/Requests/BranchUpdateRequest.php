<?php

namespace Modules\MultiBranch\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'phone' => 'nullable',
            'email' => 'nullable|email',
            'address' => 'nullable',
            'status' => 'nullable',
            'branch_admin_user_id' => 'nullable|exists:users,id',
            'user.name' => 'nullable|required_with:user.email,user.password',
            'user.email' => 'nullable|email|unique:users,email',
            'user.password' => 'nullable|min:6',
        ];
    }
}
