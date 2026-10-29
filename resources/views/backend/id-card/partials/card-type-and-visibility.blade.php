@php
    use App\Enums\IdCardType;
    $idCard = $idCard ?? null;
    $selectedType = old('card_type', $idCard->card_type ?? IdCardType::STUDENT);
    $isTeacherType = $selectedType === IdCardType::TEACHER;
@endphp

<div class="col-md-12 mb-3">
    <label class="form-label">{{ ___('common.type') }} <span class="fillable">*</span></label>
    <select name="card_type" id="idCardType" class="nice-select niceSelect bordered_style wide @error('card_type') is-invalid @enderror">
        <option value="{{ IdCardType::STUDENT }}" {{ $selectedType === IdCardType::STUDENT ? 'selected' : '' }}>
            {{ ___('common.student') }} — {{ ___('common.horizontal') ?? 'Horizontal' }}
        </option>
        <option value="{{ IdCardType::TEACHER }}" {{ $selectedType === IdCardType::TEACHER ? 'selected' : '' }}>
            {{ ___('common.teacher') }} — {{ ___('common.vertical') ?? 'Vertical' }}
        </option>
    </select>
    @error('card_type')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="col-md-12 mb-3">
    <label class="form-label" id="idCardVisibilityHeading">
        {{ $isTeacherType ? (___('common.teacher') ?? 'Teacher').' '.___('common.ID_Card_Visibility') : ___('common.student').' '.___('common.ID_Card_Visibility') }}
    </label>

    <div id="idCardVisibilityStudent" class="card_visibility_box" @if($isTeacherType) style="display:none" @endif>
        @foreach ([
            'student_name' => ___('common.student_name'),
            'admission_no' => ___('student_info.admission_no').' / '.(___('student_info.reg_no') ?? 'Reg. No'),
            'class_name' => ___('common.class_name').' / '.(___('common.course') ?? 'Course'),
            'roll_no' => ___('student_info.session') ?? 'Session / Academic year',
            'section_name' => ___('common.section_name'),
            'dob' => ___('common.date_of_birth'),
            'blood_group' => ___('common.blood_group'),
        ] as $field => $label)
            <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                <span class="card_visibility_box_item_title flex-fill">{{ $label }}</span>
                <div class="toggle-checkbox-wrapper">
                    <input class="toggle-checkbox id-card-vis-student" type="checkbox" name="{{ $field }}" id="vis_st_{{ $field }}"
                        @disabled($isTeacherType)
                        {{ old($field, $idCard ? (bool) $idCard->$field : true) ? 'checked' : '' }}>
                    <label class="slider-btn" for="vis_st_{{ $field }}"></label>
                </div>
            </div>
        @endforeach
    </div>

    <div id="idCardVisibilityTeacher" class="card_visibility_box" @if(! $isTeacherType) style="display:none" @endif>
        @foreach ([
            'student_name' => ___('common.teacher_name') ?? 'Teacher name',
            'admission_no' => ___('staff.employee_id') ?? 'Employee ID',
            'class_name' => ___('staff.designation') ?? 'Designation',
            'section_name' => ___('staff.department') ?? 'Department',
            'dob' => ___('staff.joining_date') ?? 'Joining date',
            'blood_group' => ___('common.contact_number') ?? 'Contact number',
        ] as $field => $label)
            <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                <span class="card_visibility_box_item_title flex-fill">{{ $label }}</span>
                <div class="toggle-checkbox-wrapper">
                    <input class="toggle-checkbox id-card-vis-teacher" type="checkbox" name="{{ $field }}" id="vis_tc_{{ $field }}"
                        @disabled(! $isTeacherType)
                        {{ old($field, $idCard ? (bool) $idCard->$field : true) ? 'checked' : '' }}>
                    <label class="slider-btn" for="vis_tc_{{ $field }}"></label>
                </div>
            </div>
        @endforeach
    </div>
</div>

@once
    @push('script')
    <script>
        window.syncIdCardTypeUi = function () {
            var $type = $('#idCardType');
            if (!$type.length) {
                return;
            }
            var isTeacher = $type.val() === '{{ IdCardType::TEACHER }}';

            $('#idCardVisibilityStudent').toggle(!isTeacher);
            $('#idCardVisibilityTeacher').toggle(isTeacher);

            $('.id-card-vis-student').prop('disabled', isTeacher);
            $('.id-card-vis-teacher').prop('disabled', !isTeacher);

            var heading = document.getElementById('idCardVisibilityHeading');
            if (heading) {
                heading.textContent = isTeacher
                    ? '{{ ___('common.teacher') }} {{ ___('common.ID_Card_Visibility') }}'
                    : '{{ ___('common.student') }} {{ ___('common.ID_Card_Visibility') }}';
            }

            var $prevStudent = $('#idCardFormatPreviewStudent');
            var $prevTeacher = $('#idCardFormatPreviewTeacher');
            if ($prevStudent.length && $prevTeacher.length) {
                $prevStudent.toggleClass('d-none', isTeacher).toggleClass('d-flex', !isTeacher);
                $prevTeacher.toggleClass('d-none', !isTeacher).toggleClass('d-flex', isTeacher);
            }
        };

        $(function () {
            syncIdCardTypeUi();
            $(document).on('change', '#idCardType', syncIdCardTypeUi);
            $(document).on('click', '.nice-select .option:not(.disabled)', function () {
                var $select = $(this).closest('.nice-select').prev('select#idCardType');
                if ($select.length) {
                    setTimeout(syncIdCardTypeUi, 0);
                }
            });
        });
    </script>
    @endpush
@endonce
