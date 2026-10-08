@if ($showDropdown)
    <div class="col-lg-3 col-md-6 mb-3">
        <label for="branch_id" class="form-label">{{ ___('branch.branch') }} <span class="fillable">*</span></label>
        <select name="branch_id" id="branch_id"
            class="nice-select niceSelect bordered_style wide @error('branch_id') is-invalid @enderror">
            <option value="">{{ ___('branch.select_branch') }}</option>
            @foreach ($branches as $id => $name)
                <option value="{{ $id }}" @selected((string) $selected === (string) $id)>{{ $name }}</option>
            @endforeach
        </select>
        @error('branch_id')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
@elseif ($showLocked)
    <div class="col-lg-3 col-md-6 mb-3">
        <label class="form-label">{{ ___('branch.branch') }}</label>
        <input type="text" class="form-control ot-input" value="{{ $lockedBranch->name }}" readonly>
        <input type="hidden" name="branch_id" value="{{ $lockedBranch->id }}">
    </div>
@endif
