<div class="p-3">
    <div class="row g-4">
        <!-- Overview Section -->
        <div class="col-12">
            <div class="card border shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">{{ ___('student.Result Overview') }}</h5>
                </div>
              <div class="card-body">
                    <div class="row text-center">

                        @forelse ($examTypeMarksSum as $exam_type => $total_sum)
                            <div class="col-md-4 col-6 mb-3">
                                <div class="fw-bold text-muted">{{ strtoupper($exam_type) }}</div>
                                <div class="h6 text-success"> {{ ___('student.Total Marks') }} :  {{ $total_sum }}</div>
                            </div>
                        @empty

                        @endforelse

                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        @foreach ($marks_registers as $exam_type => $marksheets)
            <div class="col-12">
                <div class="card border shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ strtoupper($exam_type) }}</h5>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="table-responsive">
                            <table class="table border_table mb-0">
                                <thead>
                                    <tr>
                                        <th class="marked_bg">{{ ___('report.subject_code') }}</th>
                                        <th class="marked_bg">{{ ___('report.subject_name') }}</th>
                                        <th class="marked_bg">{{ ___('report.Type') }}</th>

                                        <th class="marked_bg">{{ ___('report.Mark') }}</th>
                                        <th class="marked_bg">{{ ___('report.Grade') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $subjectGrouped = $marksheets->groupBy('subject_id');
                                    @endphp

                                    @forelse ($subjectGrouped as $subject_id => $subjectRegisters)
                                        @php
                                            $subject = $subjectRegisters->first()->subject;
                                            $totalMark = 0;

                                            foreach ($subjectRegisters as $register) {
                                                $totalMark += $register->marksRegisterChilds->sum('mark');
                                            }
                                        @endphp

                                        <tr>
                                            <td>
                                                <div class="classBox_wiz">
                                                    <h5>{{ $subject->code }}</h5>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="classBox_wiz">
                                                    <h5>{{ $subject->name }}</h5>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="classBox_wiz">
                                                    <h5>{{ $subject->type }}</h5>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="classBox_wiz">
                                                    <h5>{{ $totalMark }}</h5>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="classBox_wiz">
                                                    <h5>{{ markGrade($totalMark) }}</h5>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="td-text-center">
                                                @include('backend.includes.no-data')
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Modal Placeholder -->

    </div>
</div>
