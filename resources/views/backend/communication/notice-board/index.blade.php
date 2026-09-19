@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    <div class="page-content">

        {{-- bradecrumb Area S t a r t --}}
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="bradecrumb-title mb-1">{{ $data['title'] }}</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('common.home') }}</a></li>
                            <li class="breadcrumb-item">{{ $data['title'] }}</li>
                        </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <!--  table content start -->
        <div class="table-content table-basic mt-20">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $data['title'] }}</h4>
                    @if (hasPermission('homework_create'))
                        <a href="{{ route('notice-board.create') }}" class="btn btn-lg ot-btn-primary">
                            <span><i class="fa-solid fa-plus"></i> </span>
                            <span class="">{{ ___('common.add') }}</span>
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered role-table">
                            <thead class="thead">
                                <tr>
                                    <th class="serial">{{ ___('common.sr_no') }}</th>
                                    <th class="serial">{{ ___('common.title') }}</th>
                                    <th class="purchase">{{ ___('common.Department') }}</th>
                                    <th class="serial">{{ ___('common.Accessbility') }}</th>
                                    <th class="serial">{{ ___('common.Visibility') }}</th>
                                    <th class="purchase">{{ ___('common.date') }}</th>
                                    <th class="purchase">{{ ___('common.publish_date') }}</th>
                                    <th class="purchase">{{ ___('account.description') }}</th>
                                    <th class="purchase">{{ ___('common.attachment') }}</th>
                                    <th class="purchase">{{ ___('common.status') }}</th>
                                    @if (hasPermission('homework_update') || hasPermission('homework_delete'))
                                        <th class="action">{{ ___('common.action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @forelse ($data['notice-boards'] ?? [] as $key => $row)
                                    <tr id="row_{{ $row->id }}">
                                        <td class="serial">{{ ++$key }}</td>
                                        <td>{{ $row->title }} {{ $row->id }}</td>
                                        <td>{{ @$row->department->name }} </td>
                                        <td>
                                            @if ($row->student)
                                                {{ $row->student->full_name }} - {{ $row->class->name }}
                                                ({{ $row->section->name }})
                                            @elseif($row->class && $row->section)
                                                {{ @$row->class->name }} ({{ @$row->section->name }}) -
                                                {{ ___('common.All Students') }}
                                            @elseif($row->class)
                                                {{ $row->class->name }} - {{ ___('common.All Students') }}
                                            @endif
                                        </td>
                                        <td>{{ $row->visible_role_names ? $row->visible_role_names : ___('common.To All') }}
                                        </td>
                                        <td>{{ date('d-m-Y', strtotime(@$row->date)) }}</td>

                                        <td>{{ date('d-m-Y H:i a', strtotime(@$row->publish_date)) }}</td>
                                        <td>{!! \Illuminate\Support\Str::limit(strip_tags(@$row->description), 40) !!}</td>

                                        <td>
                                            <a class="btn btn-lg ot-btn-primary radius_30px small_add_btn"
                                                href="{{ @globalAsset($row->attachmentFile->path, '100X100.webp') }}"
                                                target="_blank">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        </td>
                                        <td>
                                            @if ($row->status == App\Enums\Status::ACTIVE)
                                                <span class="badge-basic-success-text">{{ ___('common.active') }}</span>
                                            @else
                                                <span class="badge-basic-danger-text">{{ ___('common.inactive') }}</span>
                                            @endif
                                        </td>
                                        @if (hasPermission('homework_update') || hasPermission('homework_delete'))
                                            <td class="action">
                                                <div class="dropdown dropdown-action">
                                                    <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end ">
                                                        @if (hasPermission('homework_update'))
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('notice-board.edit', $row->id) }}"><span
                                                                        class="icon mr-8"><i
                                                                            class="fa-solid fa-pen-to-square"></i></span>
                                                                    {{ ___('common.edit') }}</a>
                                                            </li>
                                                        @endif
                                                        @if (hasPermission('homework_update'))
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('notice-board.translate', $row->id) }}"><span
                                                                        class="icon mr-8"><i
                                                                            class="fa-solid fa-globe"></i></span>
                                                                    {{ ___('common.translate') }}</a>
                                                            </li>
                                                        @endif
                                                        @if (hasPermission('homework_delete'))
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0);"
                                                                    onclick="delete_row('communication/notice-board/delete', {{ $row->id }})">
                                                                    <span class="icon mr-8"><i
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
                                            <p class="mb-0 text-center text-secondary font-size-90">
                                                {{ ___('common.please_add_new_entity_regarding_this_table') }}</p>
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
                                {!! $data['notice-boards']->appends(\Request::capture()->except('page'))->links() !!}
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
