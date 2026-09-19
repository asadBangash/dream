<div class="p-3">
    <div class="row g-4">
        <!-- Overview Section -->
        <div class="col-12">
            <div class="card border shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">{{ ___('student.Attendance Overview') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        @php $currency = setting('currency_symbol'); @endphp

                        <div class="col-md-2 col-6 mb-3">
                            <div class="fw-bold text-muted">{{ ___('student.Total') }}</div>
                            <div class="h6">{{ count($attendances['total_attendance']) }}</div>
                        </div>

                         <div class="col-md-2 col-6 mb-3">
                            <div class="fw-bold text-muted">{{ ___('student.Attended') }}</div>
                            <div class="h6 text-success">{{ $attendances['total_present'] }}</div>
                        </div>

                        <div class="col-md-2 col-6 mb-3">
                            <div class="fw-bold text-muted">{{ ___('student.Absent') }}</div>
                            <div class="h6 text-danger">{{$attendances['total_absent'] }}</div>
                        </div>

                         <div class="col-md-2 col-6 mb-3">
                            <div class="fw-bold text-muted">{{ ___('student.Late') }}</div>
                            <div class="h6 text-warning">{{$attendances['total_absent'] }}</div>
                        </div>

                        <div class="col-md-2 col-6 mb-3">
                            <div class="fw-bold text-muted">{{ ___('student.Half') }}</div>
                            <div class="h6 text-secondary">{{ count($attendances['total_attendance']->where('attendance', 4)) }}</div>
                        </div>

                        <div class="col-md-2 col-6 mb-3">
                            <div class="fw-bold text-muted">{{ ___('student.Leave') }}</div>
                            <div class="h6 text-info">{{ count($attendances['total_attendance']->where('attendance', 5)) }}</div>
                        </div>




                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="col-12">
            <div class="card border shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ ___('attendance.Monthly Attendance') }} - {{ \Carbon\Carbon::now()->format('F') }}, {{ \Carbon\Carbon::now()->format('Y') }}</h5>
                </div>
                <div class="card-body table-responsive">
                    {{-- attendDaysInMonth --}}
                    <table class="table border_table mb_30">
                        <thead>
                            <tr>
                                <th scope="col">{{ ___('common.Date') }}</th>
                                <th scope="col">{{ ___('common.Attendance') }}</th>
                                <th scope="col">{{ ___('common.Note') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attendDaysInMonth as $date=> $attendDay)
                                <tr>
                                    <td>{{ $date }}</td>
                                    <td>{{@$attendDay['type']}}</td>
                                    <td>{{@$attendDay['note']}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center gray-color">

                                        <p class="mb-0 text-center">{{ ___('common.no_data_available') }}</p>
                                        <p class="mb-0 text-center text-secondary font-size-90">
                                            {{ ___('common.please_add_new_entity_regarding_this_table') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Placeholder -->

    </div>
</div>
