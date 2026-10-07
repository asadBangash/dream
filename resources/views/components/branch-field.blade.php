@if ($show && $branches->isNotEmpty())
    <div class="col-md-6 mb-3">
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
@endif
