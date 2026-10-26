@php
    $fp = $fieldPrefix ?? '';
@endphp
<div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label">{{ ___('student_info.father_name') }}</label>
        <input class="form-control ot-input" name="father_name" type="text"
            placeholder="{{ ___('student_info.enter_father_name') }}" value="{{ old('father_name') }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">{{ ___('student_info.father_mobile') }}</label>
        <input class="form-control ot-input" name="father_mobile" type="text"
            placeholder="{{ ___('student_info.enter_father_mobile') }}" value="{{ old('father_mobile') }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">{{ ___('student_info.father_profession') }}</label>
        <input class="form-control ot-input" name="father_profession" type="text"
            placeholder="{{ ___('student_info.enter_father_profession') }}" value="{{ old('father_profession') }}">
    </div>
</div>
<div class="row">
    <div class="col-md-3 mb-3">
        <label class="form-label">{{ ___('student_info.guardian_name') }} <span class="fillable">*</span></label>
        <input class="form-control ot-input @error('guardian_name') is-invalid @enderror" name="guardian_name"
            type="text" placeholder="{{ ___('student_info.enter_guardian_name') }}"
            value="{{ old('guardian_name') }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">{{ ___('student_info.guardian_mobile') }} <span class="fillable">*</span></label>
        <input class="form-control ot-input @error('guardian_mobile') is-invalid @enderror" name="guardian_mobile"
            type="text" placeholder="{{ ___('student_info.enter_guardian_mobile') }}"
            value="{{ old('guardian_mobile') }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">{{ ___('student_info.guardian_profession') }}</label>
        <input class="form-control ot-input" name="guardian_profession" type="text"
            value="{{ old('guardian_profession') }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">{{ ___('student_info.guardian_image') }} {{ ___('common.(95 x 95 px)') }}</label>
        <div class="ot_fileUploader left-side mb-3">
            <input class="form-control" type="text" placeholder="{{ ___('student_info.guardian_image') }}" readonly
                id="{{ $fp }}guardian_image_placeholder">
            <button class="primary-btn-small-input" type="button">
                <label class="btn btn-lg ot-btn-primary"
                    for="{{ $fp }}guardian_image_file">{{ ___('common.browse') }}</label>
                <input type="file" class="d-none form-control" name="guardian_image"
                    id="{{ $fp }}guardian_image_file" accept="image/*">
            </button>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">{{ ___('student_info.guardian_email') }}</label>
        <input class="form-control ot-input" name="guardian_email" type="email"
            value="{{ old('guardian_email') }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">{{ ___('student_info.guardian_address') }}</label>
        <input class="form-control ot-input" name="guardian_address" type="text"
            value="{{ old('guardian_address') }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">{{ ___('student_info.guardian_relation') }}</label>
        <input class="form-control ot-input" name="guardian_relation" type="text"
            value="{{ old('guardian_relation') }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">{{ ___('frontend.Father_Nationality') }}</label>
        <input name="father_nationality" class="form-control ot-input" type="text"
            value="{{ old('father_nationality') }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">{{ ___('frontend.Father_ID') }}</label>
        <input name="father_id" class="form-control ot-input" type="text" value="{{ old('father_id') }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">{{ ___('student_info.status') }} <span class="fillable">*</span></label>
        <select class="nice-select niceSelect bordered_style wide" name="status" id="{{ $fp }}parent_status">
            <option value="{{ App\Enums\Status::ACTIVE }}">{{ ___('common.active') }}</option>
            <option value="{{ App\Enums\Status::INACTIVE }}">{{ ___('common.inactive') }}</option>
        </select>
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">{{ ___('student_info.Position') }}</label>
        <input class="form-control ot-input" name="guardian_position" type="text"
            value="{{ old('guardian_position') }}">
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">{{ ___('student_info.Place of Work') }}</label>
        <input class="form-control ot-input" name="guardian_place_of_work" type="text"
            value="{{ old('guardian_place_of_work') }}">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">{{ ___('frontend.Username') }}</label>
        <input name="username" class="form-control ot-input" type="text" value="{{ old('username') }}">
    </div>
    @if ($showPasswordOptions ?? false)
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label class="form-label">{{ ___('frontend.Password') }}</label><br>
                <input type="radio" name="password_type" value="default" checked>
                <span class="me-4">{{ ___('frontend.Default Password') }} (123456)</span>
                <input type="radio" name="password_type" value="custom">
                <span>{{ ___('frontend.Custom Password') }}</span>
            </div>
        </div>
        <div id="{{ $fp }}SelectionDiv" class="col-md-3 d-none">
            <label class="form-label">{{ ___('frontend.Password') }}</label>
            <input type="text" name="password" class="form-control ot-input" autocomplete="off">
        </div>
    @endif
</div>
