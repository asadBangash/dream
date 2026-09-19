<div class="p-3">
    <div class="row g-4">
        <!-- Overview Section -->
        <div class="col-12">
            <div class="card border shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">{{ ___('student.Leave Overview') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">


                        <div class="col-md-3 col-6 mb-3">
                            <div class="fw-bold text-muted">{{ ___('student.Total Request') }}</div>
                            <div class="h6">{{ count($leave_data['leave_requests']) }}</div>
                        </div>

                        <div class="col-md-3 col-6 mb-3">
                            <div class="fw-bold text-muted">{{ ___('student.Approved') }}</div>
                            <div class="h6 text-success">
                                {{ count($leave_data['leave_requests']->where('status', 'approved')) }}</div>
                        </div>

                        <div class="col-md-3 col-6 mb-3">
                            <div class="fw-bold text-muted">{{ ___('student.Pending') }}</div>
                            <div class="h6 text-warning">
                                {{ count($leave_data['leave_requests']->where('status', 'pending')) }}</div>
                        </div>

                        <div class="col-md-3 col-6 mb-3">
                            <div class="fw-bold text-muted">{{ ___('student.Rejected') }}</div>
                            <div class="h6 text-danger">
                                {{ count($leave_data['leave_requests']->where('status', 'rejected')) }}</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="col-12">
            <div class="card border shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ ___('student.Leave Request Log') }}</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table border_table mb_30">
                        <thead>
                            <tr>
                                <th scope="col">{{ ___('common.Date') }}</th>
                                <th scope="col">{{ ___('common.Type') }}</th>
                                <th scope="col">{{ ___('common.Days') }}</th>
                                <th scope="col">{{ ___('common.Status') }}</th>
                                <th scope="col">{{ ___('common.Request By') }}</th>
                                <th scope="col">{{ ___('common.Approved By') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leave_data['leave_requests'] as  $leave_request)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($leave_request->start_date)->format('l j F') }} - {{ \Carbon\Carbon::parse($leave_request->end_date)->format('l j F') }}</td>
                                    <td>{{ @$leave_request->leaveType->name }}</td>
                                    <td>{{ @$leave_request->leave_days }}</td>
                                    <td>{{ strtoupper($leave_request->approval_status) }}</td>
                                    <td>{{ @$leave_request->requestedBy->name }}</td>
                                    <td>{{ @$leave_request->approvedBy->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center gray-color">

                                        <p class="mb-0 text-center">{{ ___('common.no_data_available') }}</p>

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
