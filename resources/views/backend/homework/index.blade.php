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
            <form action="{{ route('homework.search') }}" method="post" id="marksheet" class="exam_assign" enctype="multipart/form-data">
                @csrf
                <div class="card ot-card mb-24 position-relative z_1">
                    <div class="card-header d-flex align-items-center gap-4 flex-wrap">
                        <h3 class="mb-0">{{ ___('common.Filtering') }}</h3>
                        
                        <div
                            class="card_header_right d-flex align-items-center gap-3 flex-fill justify-content-end flex-wrap">
                            <!-- table_searchBox -->

                            <div class="single_large_selectBox">
                                <select id="getSections" class="class nice-select niceSelect bordered_style wide @error('class') is-invalid @enderror"
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
                                <select id="getSubjects"  class="sections section nice-select niceSelect bordered_style wide @error('section') is-invalid @enderror"
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
                                <select class="subjects nice-select niceSelect bordered_style wide @error('subject') is-invalid @enderror"
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
                                {{___('common.Search')}}
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
                    @if (hasPermission('homework_create'))
                        <a href="{{ route('homework.create') }}" class="btn btn-lg ot-btn-primary">
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
                                    <th class="purchase">{{ ___('academic.class') }} ({{ ___('academic.section') }})</th>
                                    <th class="purchase">{{ ___('academic.subject') }}</th>
                                    <th class="purchase">{{ ___('common.date') }}</th>
                                    <th class="purchase">{{ ___('common.submission_date') }}</th>
                                    <th class="purchase">{{ ___('examination.marks') }}</th>
                                    <th class="purchase">{{ ___('common.document') }}</th>
                                    @if (hasPermission('homework_update') || hasPermission('homework_delete'))
                                        <th class="action">{{ ___('common.action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @forelse ($data['homeworks'] as $key => $row)
                                <tr id="row_{{ $row->id }}">
                                    <td class="serial">{{ ++$key }}</td>
                                    <td>{{ $row->class->name }} ({{ $row->section->name }})</td>
                                    <td>{{ $row->subject->name }}</td>
                                    <td>{{ $row->date }}</td>
                                    <td>{{ $row->submission_date }}</td>
                                    <td>{{ $row->marks }}</td>
                                    <td><a class="btn btn-lg ot-btn-primary radius_30px small_add_btn" href="{{ @globalAsset($row->upload->path, '100X100.webp') }}" target="_blank"><i class="fa-solid fa-eye"></i></td>
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
                                                                href="{{ route('homework.edit', $row->id) }}"><span
                                                                    class="icon mr-8"><i
                                                                        class="fa-solid fa-pen-to-square"></i></span>
                                                                {{ ___('common.edit') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (hasPermission('homework_delete'))
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0);"
                                                                onclick="delete_row('homework/delete', {{ $row->id }})">
                                                                <span class="icon mr-8"><i
                                                                        class="fa-solid fa-trash-can"></i></span>
                                                                <span>{{ ___('common.delete') }}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="" data-bs-toggle="modal"
                                                            data-bs-target="#modalHomeworkEvaluation" onclick="openHomeworkEvaluationModal({{$row->id}})"><span
                                                                class="icon mr-8"><i
                                                                    class="fa-solid fa-save"></i></span>
                                                            {{ ___('common.evaluation') }}</a>
                                                           
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="100%" class="text-center gray-color">
                                        <img src="{{ asset('images/no_data.svg') }}" alt="" class="mb-primary" width="100">
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
                                    {!!$data['homeworks']->appends(\Request::capture()->except('page'))->links() !!}
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
        <div class="modal fade" id="modalHomeworkEvaluation" tabindex="-1" aria-labelledby="modalWidth"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content" id="modalWidth">
                    <div class="modal-header modal-header-image">
                        <h5 class="modal-title" id="modalLabel2">
                            {{ ___('common.Homework') }}
                        </h5>
                        <button type="button" class="m-0 btn-close d-flex justify-content-center align-items-center"
                            data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times text-white" aria-hidden="true"></i></button>
                    </div>
                    <form action="{{ route('homework.evaluation.submit') }}" enctype="multipart/form-data" method="post" id="homework-submit-form">
                        @csrf
                        <input type="hidden" name="homework_id" id="homework_id">
                        <div class="modal-body p-5">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary py-2 px-4"
                                data-bs-dismiss="modal">{{ ___('ui_element.cancel') }}</button>
                                
                            <button type="submit" class="btn ot-btn-primary">{{ ___('ui_element.confirm') }}</button>
                        
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>


@endsection

@push('script')
    @include('backend.partials.delete-ajax')
@endpush
