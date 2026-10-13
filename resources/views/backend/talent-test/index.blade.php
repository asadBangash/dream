@extends('backend.master')
@section('title')
    {{ $data['title'] }}
@endsection
@section('content')
    <div class="page-content">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="bradecrumb-title mb-1">{{ $data['title'] }}</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('common.home') }}</a></li>
                        <li class="breadcrumb-item active">{{ $data['title'] }}</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-12">
            <form action="{{ route('talent-test-applications.search') }}" method="post">
                @csrf
                <div class="card ot-card mb-24">
                    <div class="card-header d-flex align-items-center gap-4 flex-wrap">
                        <h3 class="mb-0">{{ ___('common.Filtering') }}</h3>
                        <div class="card_header_right d-flex align-items-center gap-3 flex-fill justify-content-end flex-wrap">
                            <select class="nice-select niceSelect bordered_style wide" name="status">
                                <option value="">{{ ___('common.all') }} {{ ___('common.status') }}</option>
                                @foreach ($data['statuses'] as $value => $label)
                                    <option value="{{ $value }}" {{ (string) old('status', @$data['request']->status) === (string) $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <input class="form-control ot-input" name="keyword" placeholder="{{ ___('student_info.enter_keyword') }}"
                                value="{{ old('keyword', @$data['request']->keyword) }}">
                            <button class="btn btn-lg ot-btn-primary" type="submit">{{ ___('common.Search') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-content table-basic mt-20">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">{{ $data['title'] }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered role-table">
                            <thead>
                                <tr>
                                    <th>{{ ___('common.sr_no') }}</th>
                                    <th>{{ ___('common.reference') }}</th>
                                    <th>{{ ___('student_info.student_name') }}</th>
                                    <th>{{ ___('frontend.father_name') }}</th>
                                    <th>{{ ___('frontend.current_class') }}</th>
                                    <th>{{ ___('frontend.phone_no') }}</th>
                                    <th>{{ ___('common.status') }}</th>
                                    <th>{{ ___('common.date') }}</th>
                                    <th>{{ ___('common.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data['applications'] as $key => $row)
                                    <tr id="row_{{ $row->id }}">
                                        <td>{{ $data['applications']->firstItem() + $key }}</td>
                                        <td>{{ $row->reference_no }}</td>
                                        <td>{{ $row->student_name }}</td>
                                        <td>{{ $row->father_name }}</td>
                                        <td>{{ $row->current_class }}</td>
                                        <td>{{ $row->contact_number }}</td>
                                        <td><span class="badge bg-secondary">{{ $row->statusLabel() }}</span></td>
                                        <td>{{ dateFormat($row->created_at) }}</td>
                                        <td>
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"><i class="fa-solid fa-ellipsis"></i></button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('talent-test-applications.show', $row->id) }}">
                                                            <i class="fa-solid fa-eye me-2"></i>{{ ___('common.view') }}
                                                        </a>
                                                    </li>
                                                    @if (hasPermission('admission_delete'))
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('talent-test-applications/delete', {{ $row->id }})">
                                                                <i class="fa-solid fa-trash-can me-2"></i>{{ ___('common.delete') }}
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center gray-color">{{ ___('common.no_data_available') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="ot-pagination pagination-content d-flex justify-content-end py-3">
                        {!! $data['applications']->appends(\Request::capture()->except('page'))->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    @include('backend.partials.delete-ajax')
@endpush
