@extends('backend.master')
@section('title', ___('multibranch.Branches'))
@section('content')
    <div class="page-content">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="bradecrumb-title mb-1">{{ $title }}</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('common.home') }}</a></li>
                        <li class="breadcrumb-item">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="table-content table-basic mt-20">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h4 class="mb-0 text-capitalize">{{ $title }}</h4>
                    <div class="d-flex align-items-center gap-2">
                        @if (hasPermission('user_delete'))
                            <button type="button" class="btn btn-lg ot-btn-danger d-none" id="branchBulkDeleteBtn"
                                    onclick="bulk_delete_branches()">
                                <i class="fa-solid fa-trash-can"></i>
                                <span>{{ ___('branch.bulk_delete') }}</span>
                            </button>
                        @endif
                        @if (hasPermission('user_create'))
                            <a href="{{ route('branch.create') }}" class="btn btn-lg ot-btn-primary">
                                <span><i class="fa-solid fa-plus"></i> </span>
                                <span class="">{{ ___('common.add') }}</span>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered user-table">
                            <thead class="thead">
                            <tr>
                                @if (hasPermission('user_delete'))
                                    <th class="serial" style="width: 40px;">
                                        <input type="checkbox" class="form-check-input" id="branchSelectAll"
                                               title="{{ ___('common.select_all') }}">
                                    </th>
                                @endif
                                <th class="serial">{{ ___('common.sr_no.') }}</th>
                                <th class="purchase">{{ ___('common.name') }}</th>
                                <th class="purchase">{{ ___('branch.branch_admin') }}</th>
                                <th class="purchase">{{ ___('common.email') }}</th>
                                <th class="purchase">{{ ___('common.phone') }}</th>
                                <th class="purchase">{{ ___('common.address') }}</th>
                                <th class="purchase">{{ ___('common.status') }}</th>
                                @if (hasPermission('user_update') || hasPermission('user_delete'))
                                    <th class="action">{{ ___('common.action') }}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody class="tbody">
                            @forelse ($branches ?? [] as $key => $row)
                                @php
                                    $admin = $branchAdmins[$row->id] ?? null;
                                    $sr = ($branches->currentPage() - 1) * $branches->perPage() + $key + 1;
                                @endphp
                                <tr id="row_{{ $row->id }}">
                                    @if (hasPermission('user_delete'))
                                        <td>
                                            <input type="checkbox" class="form-check-input branch-row-check"
                                                   value="{{ $row->id }}">
                                        </td>
                                    @endif
                                    <td class="serial">{{ $sr }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>
                                        @if ($admin)
                                            <div>{{ $admin->name }}</div>
                                            <small class="text-muted">{{ $admin->email }}</small>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->phone }}</td>
                                    <td>{{ $row->address }}</td>
                                    <td>
                                        @if ($row->status == App\Enums\Status::ACTIVE)
                                            <span class="badge-basic-success-text">{{ ___('common.active') }}</span>
                                        @else
                                            <span class="badge-basic-danger-text">{{ ___('common.inactive') }}</span>
                                        @endif
                                    </td>
                                    @if (hasPermission('user_update') || hasPermission('user_delete'))
                                        <td class="action">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @if (hasPermission('user_update'))
                                                        <li>
                                                            <a class="dropdown-item"
                                                               href="{{ route('branch.edit', $row->id) }}">
                                                    <span class="icon mr-8"><i
                                                            class="fa-solid fa-pen-to-square"></i></span>
                                                                <span>{{ ___('common.edit') }}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    @if (hasPermission('user_delete'))
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0);"
                                                               onclick="delete_row('branches/delete', {{ $row->id }})">
                                                    <span class="icon mr-12"><i
                                                            class="fa-solid fa-trash-can"></i></span>
                                                                <span>{{ ___('common.delete') }}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center gray-color">
                                        <img src="{{ asset('images/no_data.svg') }}" alt="" class="mb-primary"
                                             width="100">
                                        <p class="mb-0 text-center">{{ ___('common.no_data_available') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="ot-pagination pagination-content d-flex justify-content-end align-content-center py-3">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-between">
                                {!! $branches->links() !!}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    @include('backend.partials.delete-ajax')
    <script>
        function toggleBranchBulkDeleteBtn() {
            const any = $('.branch-row-check:checked').length > 0;
            $('#branchBulkDeleteBtn').toggleClass('d-none', !any);
        }

        $('#branchSelectAll').on('change', function() {
            $('.branch-row-check').prop('checked', this.checked);
            toggleBranchBulkDeleteBtn();
        });

        $(document).on('change', '.branch-row-check', toggleBranchBulkDeleteBtn);

        function bulk_delete_branches() {
            const ids = $('.branch-row-check:checked').map(function() {
                return $(this).val();
            }).get();

            if (!ids.length) {
                return;
            }

            Swal.fire({
                title: $('#alert_title').val(),
                text: $('#alert_subtitle').val(),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: $('#alert_yes_btn').val(),
                cancelButtonText: $('#alert_cancel_btn').val(),
            }).then((confirmed) => {
                if (!confirmed.isConfirmed) {
                    return;
                }

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '{{ route('branch.bulk-destroy') }}',
                    data: {
                        ids: ids,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                }).done(function(response) {
                    Swal.fire({
                        icon: response[1],
                        title: response[2],
                        text: response[0],
                        showCloseButton: true,
                        confirmButtonText: response[3],
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }).fail(function() {
                    Swal.fire('{{ ___('common.opps') }}...',
                        '{{ ___('common.something_went_wrong_with_ajax') }}', 'error');
                });
            });
        }
    </script>
@endpush
