<?php

namespace App\Http\Requests\StudentInfo\ParentGuardian;

use App\Rules\BranchUnique;
use Illuminate\Foundation\Http\FormRequest;

class ParentGuardianStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $branchId = $this->input('branch_id');

        if (hasModule('MultiBranch') && branchIdMeansAllBranches($branchId)) {
            $resolved = superAdminActiveBranchId();
            if ($resolved) {
                $this->merge(['branch_id' => (string) $resolved]);
            } else {
                $this->merge(['branch_id' => '']);
            }
        }

        if (! $this->filled('guardian_name') && $this->filled('father_name')) {
            $this->merge(['guardian_name' => $this->input('father_name')]);
        }

        if (! $this->filled('guardian_mobile') && $this->filled('father_mobile')) {
            $this->merge(['guardian_mobile' => $this->input('father_mobile')]);
        }

        if ($this->filled('guardian_name') && ! $this->filled('guardian_profession') && $this->filled('father_profession')) {
            $this->merge(['guardian_profession' => $this->input('father_profession')]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return array_merge(branchIdValidationRules(), [
            'guardian_mobile'        => ['required', 'max:255', new BranchUnique('users', 'phone')],
            'guardian_name'          => 'required|max:255',
            'status'                 => 'required|max:255',
            'father_name'            => 'max:255',
            'father_mobile'          => 'max:255',
            'father_profession'      => 'max:255',
            'mother_name'            => 'max:255',
            'mother_mobile'          => 'max:255',
            'mother_profession'      => 'max:255',
            'guardian_profession'    => 'max:255',
            'guardian_email'         => 'max:255',
            'guardian_address'       => 'max:255',
            'guardian_relation'      => 'max:255',
            'username'       => ['nullable', new BranchUnique('users', 'username')],
            'password'       => 'min:6',
        ]);
    }
}
