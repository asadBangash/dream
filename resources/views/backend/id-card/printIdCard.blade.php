@include('backend.id-card.partials.dream-tuition-id-styles')

@php
    $isTeacher = idCardIsTeacher($data['idcard']);
    $studentRows = $data['students'] ?? collect();
    $staffRows = $data['staff_members'] ?? collect();
    $hasRows = $isTeacher ? $staffRows->isNotEmpty() : $studentRows->isNotEmpty();
@endphp

@if (! $hasRows)
    <div class="alert alert-warning mb-0">
        {{ $isTeacher ? ___('alert.no_staff_found') ?? 'No staff records found for this filter.' : ___('alert.no_students_found') ?? 'No students found for the selected class and section.' }}
    </div>
@else
    <div class="dream-id-print-grid">
        @if ($isTeacher)
            @foreach ($staffRows as $staff)
                @include('backend.id-card.partials.dream-teacher-id', [
                    'idCard' => $data['idcard'],
                    'idCardContext' => idCardTeacherContext($staff, $data['idcard']),
                ])
            @endforeach
        @else
            @foreach ($studentRows as $row)
                @include('backend.id-card.partials.dream-student-id', [
                    'idCard' => $data['idcard'],
                    'idCardContext' => idCardStudentContext($row, $data['idcard']),
                ])
            @endforeach
        @endif
    </div>
@endif
