@extends('parent-panel.partials.master')

@section('title')
{{ ___('common.Homework List') }}
@endsection

@section('content')
<div class="page-content">

    <div class="col-12 p-0">
        <form action="{{ route('parent-panel-homeworks.search') }}" method="post" id="marksheed" enctype="multipart/form-data">
            @csrf
            <div class="card ot-card mb-24 position-relative z_1">
                <div class="card-header d-flex align-items-center gap-4 flex-wrap">
                    <h3 class="mb-0">{{ ___('common.Filtering') }}</h3>

                    <div class="card_header_right d-flex align-items-center gap-3 flex-fill justify-content-end flex-wrap">
                        <!-- table_searchBox -->

                        <div class="single_large_selectBox">
                            <select class="nice-select niceSelect bordered_style wide @error('student') is-invalid @enderror" name="student">
                                <option value="">{{ ___('student_info.select_student') }}</option>
                                @foreach ($data['students'] as $item)
                                <option {{ old('student', Session::get('student_id')) == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->first_name }} {{ $item->last_name }}
                                    @endforeach
                            </select>
                            @error('student')
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
    <div class="table-content table-basic">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{___('settings.homework_list')}}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered class-table">
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
                            @if(@$data['homeworks'])
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
                            @endif
                        </tbody>
                    </table>
                </div>
                <!--  table end -->
                <!--  pagination start -->


                <!--  pagination end -->
            </div>
        </div>
    </div>
    <!--  table content end -->

</div>
@endsection