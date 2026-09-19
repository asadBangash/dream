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
                    @if (hasPermission('fees_assign_create'))
                        <div>
                            <a href="{{ route('fees-assign.import') }}" class="btn btn-lg ot-btn-primary">
                                <span><i class="fa-solid fa-plus"></i> </span>
                                <span class="">{{ ___('common.Import Fees') }}</span>
                            </a>
                            <a href="{{ route('fees-assign.create') }}" class="btn btn-lg ot-btn-primary">
                                <span><i class="fa-solid fa-plus"></i> </span>
                                <span class="">{{ ___('common.add') }}</span>
                            </a>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered role-table">
                            <thead class="thead">
                                <tr>
                                    <th class="serial">{{ ___('common.sr_no') }}</th>
                                    <th class="purchase">{{ ___('fees.group') }}</th>
                                    <th class="purchase">{{ ___('academic.class') }} ({{ ___('academic.section') }})</th>
                                    <th class="purchase">{{ ___('fees.Category') }}</th>
                                    <th class="purchase">{{ ___('common.gender') }}</th>
                                    <th class="purchase">{{ ___('fees.students_list') }}</th>
                                    @if (hasPermission('fees_assign_update') || hasPermission('fees_assign_delete'))
                                        <th class="action">{{ ___('common.action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @forelse ($data['fees_assigns'] as $key => $row)
                                    <tr id="row_{{ $row->id }}">
                                        <td class="serial">{{ ++$key }}</td>
                                        <td>{{ @$row->feesGroup->name }}</td>
                                        <td>{{ @$row->class->name }} ({{ @$row->section->name }})</td>
                                        <td>{{ @$row->category->name }}</td>
                                        <td>{{ @$row->gender->name }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm ot-btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#modalCustomizeWidth"
                                                onclick="viewStudentList({{ $row->id }})">
                                                <span><i class="fa-solid fa-eye"></i> </span>
                                            </a>
                                        </td>
                                        @if (hasPermission('fees_assign_update') || hasPermission('fees_assign_delete'))
                                            <td class="action">
                                                <div class="dropdown dropdown-action">
                                                    <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end ">
                                                        @if (hasPermission('fees_assign_update'))
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('fees-assign.edit', $row->id) }}"><span
                                                                        class="icon mr-8"><i
                                                                            class="fa-solid fa-pen-to-square"></i></span>
                                                                    {{ ___('common.edit') }}</a>
                                                            </li>
                                                        @endif
                                                        @if (hasPermission('fees_assign_delete'))
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0);"
                                                                    onclick="delete_row('fees-assign/delete', {{ $row->id }})">
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
                                {!! $data['fees_assigns']->links() !!}
                            </ul>
                        </nav>
                    </div>

                    <!--  pagination end -->
                </div>
            </div>
        </div>
        <!--  table content end -->

    </div>

    <div id="view-modal">
        <div class="modal fade" id="modalCustomizeWidth" tabindex="-1" aria-labelledby="modalWidth" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                {{--  --}}
            </div>
        </div>
    </div>

@endsection

@push('script')
    @include('backend.partials.delete-ajax')
@endpush
