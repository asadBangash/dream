@extends('mainapp::layouts.backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('css')
    <style>
        .loader {
        width: 28px;
        height: 28px;
        border: 5px solid #c49c1c;
        border-bottom-color: transparent;
        border-radius: 50%;
        display: inline-block;
        box-sizing: border-box;
        animation: rotation 1s linear infinite;
    }

    @keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
    }
    </style>
@endsection
@section('content')
    <div class="page-content">

        {{-- bradecrumb Area S t a r t --}}
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="bradecrumb-title mb-1">{{ $data['title'] }}</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('mainapp_common.home') }}</a></li>
                        <li class="breadcrumb-item">{{ ___('mainapp_schools.School List') }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <!--  table content start -->
        <div class="table-content table-basic mt-20">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ ___('mainapp_schools.School List') }}</h4>
                    <a href="{{ route('school.create') }}" class="btn btn-lg ot-btn-primary">
                        <span><i class="fa-solid fa-plus"></i> </span>
                        <span class="">{{ ___('mainapp_common.add') }}</span>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered school-table">
                            <thead class="thead">
                                <tr>
                                    <th class="serial">{{ ___('mainapp_common.sr_no') }}</th>
                                    <th class="purchase">{{ ___('mainapp_schools.Sub domain') }}</th>
                                    <th class="purchase">{{ ___('mainapp_common.name') }}</th>
                                    <th class="purchase">{{ ___('mainapp_schools.Package') }}</th>
                                    <th class="purchase">{{ ___('mainapp_common.phone') }}</th>
                                    <th class="purchase">{{ ___('mainapp_common.email') }}</th>
                                    <th class="purchase">{{ ___('mainapp_common.address') }}</th>
                                    <th class="purchase">{{ ___('mainapp_common.status') }}</th>
                                    <th class="action">{{ ___('mainapp_common.action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @forelse ($data['schools'] as $key => $row)
                                <tr id="row_{{ $row->id }}">
                                    <td class="serial">{{ ++$key }}</td>
                                    <td>
                                        @if($row->status == App\Enums\Status::ACTIVE && $row->tenant)
                                            <a href="https://{{ $row->sub_domain_key.'.'.env('APP_MAIN_APP_URL') }}" target="_blank">
                                                    {{ $row->sub_domain_key.'.'.env('APP_MAIN_APP_URL') }}
                                            </a>
                                        @else
                                              <span class="loader"></span>

                                        @endif
                                    </td>
                                    <td>{{ $row->name }}</td>

                                    <td>{{ $row->package->name }}</td>
                                    <td>{{ $row->phone }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->address }}</td>
                                    <td>
                                        @if ($row->status == App\Enums\Status::ACTIVE && $row->tenant)
                                            <span class="badge-basic-success-text">{{ ___('mainapp_common.active') }}</span>
                                        @else
                                            <span class="badge-basic-danger-text">{{ ___('mainapp_common.inactive') }}</span>
                                        @endif
                                    </td>
                                    <td class="action">
                                        <div class="dropdown dropdown-action">
                                            <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end ">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('school.edit', $row->id) }}"><span
                                                            class="icon mr-8"><i
                                                                class="fa-solid fa-pen-to-square"></i></span>
                                                        {{ ___('mainapp_common.edit') }}</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        onclick="delete_row('school/delete', {{ $row->id }})">
                                                        <span class="icon mr-8"><i
                                                                class="fa-solid fa-trash-can"></i></span>
                                                        <span>{{ ___('mainapp_common.delete') }}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="100%" class="text-center gray-color">
                                        <img src="{{ asset('images/no_data.svg') }}" alt="" class="mb-primary" width="100">
                                        <p class="mb-0 text-center">{{ ___('mainapp_common.no_data_available') }}</p>
                                        <p class="mb-0 text-center text-secondary font-size-90">
                                            {{ ___('mainapp_common.please_add_new_entity_regarding_this_table') }}</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!--  table end -->
                    <!--  pagination start -->

                        <div class="ot-pagination pagination-content d-flex justify-content-end align-content-center py-3">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-between">
                                    {!!$data['schools']->links() !!}
                                </ul>
                            </nav>
                        </div>

                    <!--  pagination end -->
                </div>
            </div>
        </div>
        <!--  table content end -->

    </div>
@endsection

@push('script')
    @include('backend.partials.delete-ajax')
@endpush
