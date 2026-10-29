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
<div class="dream-id-scale dream-id-scale--student">
    <div class="dream-id dream-id--student">
        <img class="dream-id__bg" src="{{ $bgUrl }}" alt="">

        <div class="dream-id__student-body">
            <div class="dream-id__student-layout">
                <div class="dream-id__photo-frame">
                    @if (! empty($ctx['photo_url']))
                        <img src="{{ $ctx['photo_url'] }}" alt="">
                    @endif
                </div>

                <div class="dream-id__student-fields">
                    @if ($showField('student_name'))
                        <div class="dream-id__field dream-id__field--name">
                            <span class="dream-id__label">{{ ___('common.student_name') }}</span>
                            <span class="dream-id__line-value">{{ idCardFieldValue($ctx['student_name'] ?? '') }}</span>
                        </div>
                    @endif

                    @if ($showField('admission_no') || $showField('class_name') || $showField('section_name'))
                        <div class="dream-id__field-row">
                            @if ($showField('admission_no'))
                                <div class="dream-id__field">
                                    <span class="dream-id__label">{{ ___('student_info.admission_no') }} / Reg. No</span>
                                    <span class="dream-id__line-value">{{ idCardFieldValue($ctx['admission_no'] ?? '') }}</span>
                                </div>
                            @endif
                            @if ($showField('class_name') || $showField('section_name'))
                                <div class="dream-id__field">
                                    <span class="dream-id__label">{{ ___('common.class_name') }} / Course</span>
                                    <span class="dream-id__line-value">{{ idCardFieldValue($ctx['class_course'] ?? '') }}</span>
                                </div>
                            @endif
                        </div>
                    @endif

                    @if ($showField('roll_no'))
                        <div class="dream-id__field">
                            <span class="dream-id__label">Session / Academic year</span>
                            <span class="dream-id__line-value">{{ idCardFieldValue($ctx['session_year'] ?? '') }}</span>
                        </div>
                    @endif

                    <div class="dream-id__field-row">
                        <div class="dream-id__field">
                            <span class="dream-id__label">Issue date</span>
                            <span class="dream-id__line-value">{{ idCardFieldValue($ctx['issue_date'] ?? '') }}</span>
                        </div>
                        <div class="dream-id__field">
                            <span class="dream-id__label">Expiry date</span>
                            <span class="dream-id__line-value">{{ idCardFieldValue($ctx['expiry_date'] ?? '') }}</span>
                        </div>
                    </div>
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
