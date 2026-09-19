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

        <div class="col-12">
            <form action="{{ route('exam-assign.search') }}" method="post" id="marksheet" class="exam_assign"
                enctype="multipart/form-data">
                @csrf
                <div class="card ot-card mb-24 position-relative z_1">
                    <div class="card-header d-flex align-items-center gap-4 flex-wrap">
                        <h3 class="mb-0">{{ ___('common.Filtering') }}</h3>

                        <div
                            class="card_header_right d-flex align-items-center gap-3 flex-fill justify-content-end flex-wrap">
                            <!-- table_searchBox -->

                            <div class="single_large_selectBox">
                                <select id="getSections"
                                    class="class nice-select niceSelect bordered_style wide @error('class') is-invalid @enderror"
                                    name="class">
                                    <option value="">{{ ___('student_info.select_class') }} </option>
                                    @foreach ($data['classes'] as $item)
                                        <option value="{{ $item->class->id }}">{{ $item->class->name }}</option>
                                    @endforeach
                                </select>
                                @error('class')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="single_large_selectBox">
                                <select
                                    class="sections section nice-select niceSelect bordered_style wide @error('section') is-invalid @enderror"
                                    name="section">
                                    <option value="">{{ ___('student_info.select_section') }} </option>
                                </select>
                                @error('section')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="single_large_selectBox">
                                <select
                                    class="nice-select niceSelect bordered_style wide exam_types @error('exam_type') is-invalid @enderror"
                                    name="exam_type">
                                    <option value="">{{ ___('examination.select_exam_type') }} </option>
                                </select>
                                @error('exam_type')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="single_large_selectBox">
                                <select
                                    class="subjects nice-select niceSelect bordered_style wide @error('subject') is-invalid @enderror"
                                    name="subject">
                                    <option value="">{{ ___('academic.select_subject') }} </option>

                                </select>
                                @error('subject')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button class="btn btn-lg ot-btn-primary" type="submit">
                                {{ ___('common.Search') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!--  table content start -->
        <div class="table-content table-basic mt-20">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $data['title'] }}</h4>
                    @if (hasPermission('exam_assign_create'))
                        <a href="{{ route('exam-assign.create') }}" class="btn btn-lg ot-btn-primary">
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
                                    <th class="purchase">{{ ___('examination.exam_title') }}</th>
                                    <th class="purchase">{{ ___('examination.class') }} ({{ ___('examination.section') }})
                                    </th>
                                    <th class="purchase">{{ ___('examination.subjects') }}</th>
                                    <th class="purchase">{{ ___('examination.total_mark') }}</th>
                                    <th class="purchase">{{ ___('examination.mark_distribution') }}</th>
                                    @if (hasPermission('exam_assign_update') || hasPermission('exam_assign_delete'))
                                        <th class="action">{{ ___('common.action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @forelse ($data['exam_assigns'] as $key => $row)
                                    <tr id="row_{{ $row->id }}">
                                        <td class="serial">{{ ++$key }}</td>
                                        <td>{{ @$row->exam_type->name }}</td>
                                        <td>{{ @$row->class->name }} ({{ @$row->section->name }})</td>
                                        <td>{{ @$row->subject->name }}</td>
                                        <td>{{ @$row->total_mark }}</td>
                                        <td>
                                            @foreach (@$row->mark_distribution as $item)
                                                <div class="d-flex align-items-center justify-content-between mt-0">
                                                    <p>{{ $item->title }}</p>
                                                    <p>{{ $item->mark }}</p>
                                                </div>
                                            @endforeach
                                        </td>
                                        @if (hasPermission('exam_assign_update') || hasPermission('exam_assign_delete'))
                                            <td class="action">
                                                <div class="dropdown dropdown-action">
                                                    <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end ">
                                                        @if (hasPermission('exam_assign_update'))
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('exam-assign.edit', $row->id) }}"><span
                                                                        class="icon mr-8"><i
                                                                            class="fa-solid fa-pen-to-square"></i></span>
                                                                    {{ ___('common.edit') }}</a>
                                                            </li>
                                                        @endif
                                                        @if (hasPermission('exam_assign_delete'))
                                                            <li>
                                                                <input type="hidden" name=""
                                                                    value="{{ ___('examination.already_mark_registered_they_will_also_be_deleted') }}"
                                                                    class="note">
                                                                <a class="dropdown-item" href="javascript:void(0);"
                                                                    onclick="delete_row('exam-assign/delete', {{ $row->id }})">
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
                                {!! $data['exam_assigns']->appends(\Request::capture()->except('page'))->links() !!}
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
    @include('backend.examination.exam-assign.delete-ajax')
@endpush
