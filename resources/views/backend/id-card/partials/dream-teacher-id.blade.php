@php
    $ctx = $idCardContext ?? [];
    $idCard = $idCard ?? null;
    $bgUrl = idCardTemplateImageUrl($idCard);
    $showField = function (string $flag) use ($idCard): bool {
        if (! $idCard) {
            return true;
        }

        return (bool) data_get($idCard, $flag, true);
    };
@endphp
<div class="dream-id-scale dream-id-scale--teacher">
    <div class="dream-id dream-id--teacher">
        <img class="dream-id__bg" src="{{ $bgUrl }}" alt="">

        <div class="dream-id__teacher-body">
            <div class="dream-id__teacher-layout">
                <div class="dream-id__teacher-photo-col">
                    <div class="dream-id__photo-frame">
                        @if (! empty($ctx['photo_url']))
                            <img src="{{ $ctx['photo_url'] }}" alt="">
                        @endif
                    </div>
                    @if ($showField('dob'))
                        <div class="dream-id__field dream-id__field--join">
                            <span class="dream-id__label">Joining date</span>
                            <span class="dream-id__line-value">{{ idCardFieldValue($ctx['joining_date'] ?? '') }}</span>
                        </div>
                    @endif
                </div>

                <div class="dream-id__teacher-fields">
                    @if ($showField('student_name'))
                        <div class="dream-id__field dream-id__field--name">
                            <span class="dream-id__label">Teacher name</span>
                            <span class="dream-id__line-value">{{ idCardFieldValue($ctx['teacher_name'] ?? '') }}</span>
                        </div>
                    @endif
                    @if ($showField('admission_no'))
                        <div class="dream-id__field">
                            <span class="dream-id__label">Employee ID</span>
                            <span class="dream-id__line-value">{{ idCardFieldValue($ctx['employee_id'] ?? '') }}</span>
                        </div>
                    @endif
                    @if ($showField('class_name'))
                        <div class="dream-id__field">
                            <span class="dream-id__label">Designation</span>
                            <span class="dream-id__line-value">{{ idCardFieldValue($ctx['designation'] ?? '') }}</span>
                        </div>
                    @endif
                    @if ($showField('section_name'))
                        <div class="dream-id__field">
                            <span class="dream-id__label">Department</span>
                            <span class="dream-id__line-value">{{ idCardFieldValue($ctx['department'] ?? '') }}</span>
                        </div>
                    @endif
                    @if ($showField('blood_group'))
                        <div class="dream-id__field">
                            <span class="dream-id__label">Contact number</span>
                            <span class="dream-id__line-value">{{ idCardFieldValue($ctx['contact'] ?? '') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if (! empty($ctx['qr_url']))
            <div class="dream-id__qr dream-id__qr--custom">
                <img src="{{ $ctx['qr_url'] }}" alt="QR">
            </div>
        @endif
    </div>
</div>
