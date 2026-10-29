@include('backend.id-card.partials.dream-tuition-id-styles')
<div class="preview_box_wrapper">
    <div class="preview_box">
        <div class="preview_box_inner d-flex justify-content-center">
            @if (idCardIsTeacher($data['idcard']))
                @include('backend.id-card.partials.dream-teacher-id', [
                    'idCard' => $data['idcard'],
                    'idCardContext' => idCardTeacherContext(null, $data['idcard'], true),
                ])
            @else
                @include('backend.id-card.partials.dream-student-id', [
                    'idCard' => $data['idcard'],
                    'idCardContext' => idCardStudentContext(null, $data['idcard'], true),
                ])
            @endif
        </div>
    </div>
</div>
