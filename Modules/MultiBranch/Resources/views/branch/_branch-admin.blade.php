<div class="col-lg-12 mb-3 mt-2">
    <h4>{{ ___('branch.branch_administrator') }}</h4>
    @if (!empty($currentBranchAdmin))
        <p class="text-muted mb-2">
            {{ ___('branch.current_branch_admin') }}:
            <strong>{{ $currentBranchAdmin->name }}</strong> ({{ $currentBranchAdmin->email }})
        </p>
    @else
        <p class="text-muted mb-2">{{ ___('branch.no_branch_admin_assigned') }}</p>
    @endif
    <p class="text-muted mb-0">{{ ___('branch.assign_admin_help') }}</p>
</div>

<div class="col-lg-12 col-md-12 mb-3">
    <label for="branch_admin_user_id" class="form-label">{{ ___('branch.assign_existing_user') }}</label>
    <select class="form-control ot-input nice-select niceSelect bordered_style wide @error('branch_admin_user_id') is-invalid @enderror"
            name="branch_admin_user_id" id="branch_admin_user_id">
        <option value="">{{ ___('branch.create_new_user_instead') }}</option>
        @foreach ($branchAdminCandidates ?? [] as $candidate)
            <option value="{{ $candidate->id }}"
                @selected(old('branch_admin_user_id', $currentBranchAdmin->id ?? null) == $candidate->id)>
                {{ $candidate->name }} ({{ $candidate->email }})
                @if ($candidate->branch_id && (int) $candidate->branch_id !== (int) ($branch->id ?? 0))
                    — {{ ___('branch.branch') }} #{{ $candidate->branch_id }}
                @endif
            </option>
        @endforeach
    </select>
    @error('branch_admin_user_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="col-lg-12 mb-3">
    <h5 class="mb-0">{{ ___('branch.new_branch_admin') }}</h5>
</div>
<div class="col-lg-4 col-md-6 mb-3">
    <label for="user_name" class="form-label">{{ ___('branch.Name') }}</label>
    <input class="form-control ot-input @error('user.name') is-invalid @enderror"
           name="user[name]" value="{{ old('user.name') }}" id="user_name" type="text"
           placeholder="{{ ___('branch.Enter name') }}">
    @error('user.name')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="col-lg-4 col-md-6 mb-3">
    <label for="user_email" class="form-label">{{ ___('branch.Email') }}</label>
    <input class="form-control ot-input @error('user.email') is-invalid @enderror"
           name="user[email]" value="{{ old('user.email') }}" id="user_email" type="email"
           placeholder="{{ ___('branch.Enter email') }}">
    @error('user.email')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="col-lg-4 col-md-6 mb-3">
    <label for="user_password" class="form-label">{{ ___('branch.Password') }}</label>
    <input class="form-control ot-input @error('user.password') is-invalid @enderror"
           name="user[password]" value="{{ old('user.password') }}" id="user_password" type="text"
           placeholder="{{ ___('branch.Enter password') }}">
    @error('user.password')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
