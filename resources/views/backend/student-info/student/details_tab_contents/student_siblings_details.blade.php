<div class="p-3">
    <div class="row g-4">
        @if (!empty($siblings) && count($siblings) > 0)
            <div class="form-item p-3">
                <h4 class="title mb-3">{{ ___('student_info.Siblings') }}</h4>
                <hr>

                <div class="row">
                    @foreach ($siblings as $sibling)
                        <div class="col-4">
                            <div class="card mb-3">
                                <div class="card-body p-3 d-flex align-items-center">
                                    {{-- Profile image --}}
                                    <div class="me-3">
                                        <img src="{{ @globalAsset(@$sibling->user->upload->path, '40X40.webp') }}"
                                            alt="{{ @$sibling->user->full_name }}" class="rounded-circle" width="60"
                                            height="60" style="object-fit: cover;">
                                    </div>

                                    {{-- Info --}}
                                    <div>
                                        <h5 class="mb-1">
                                            <a target="_blank" href="{{ route('student.show', $sibling->id) }}">
                                                {{ $sibling->first_name }} {{ $sibling->last_name }}
                                            </a>
                                        </h5>
                                        <p class="mb-0">
                                            <strong>{{ ___('student_info.admission_no') }}:</strong>
                                            {{ $sibling->admission_no }}
                                        </p>
                                        <p class="mb-0">
                                            <strong>{{ ___('student_info.roll_no') }}:</strong>
                                            {{ $sibling->roll_no }}
                                        </p>
                                        <p class="mb-0">
                                            <strong>{{ ___('student_info.class') }}:</strong>
                                            {{ @$sibling->session_class_student->class->name }} -
                                            ({{ @$sibling->session_class_student->section->name }})
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
