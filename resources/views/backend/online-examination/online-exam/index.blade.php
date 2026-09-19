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
                        <li class="breadcrumb-item"><a href="">{{ ___('online-examination.online_examination') }}</a></li>
                        <li class="breadcrumb-item">{{ $data['title'] }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="col-12">
            <form action="{{ route('online-exam.search') }}" method="post" id="marksheet" class="exam_assign" enctype="multipart/form-data">
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
                                        <option value="{{ $item->class->id }}" {{ old('class', @$data['request']->class ) == $item->class->id ? 'selected' : '' }}>{{ $item->class->name }}</option>
                                    @endforeach
                                </select>
                                @error('class')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="single_large_selectBox">
                                <select id="section" class="sections section nice-select niceSelect bordered_style wide @error('section') is-invalid @enderror"
                                    name="section">
                                    <option value="">{{ ___('student_info.select_section') }} </option>
                                    @foreach ($data['sections'] as $item)
                                        <option value="{{ $item->section->id }}" {{ old('section', @$data['request']->section ) == $item->section->id ? 'selected' : '' }}>{{ $item->section->name }}</option>
                                    @endforeach
                                </select>
                                @error('section')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="single_large_selectBox">
                                <select class="subjects nice-select niceSelect bordered_style wide @error('subject') is-invalid @enderror" name="subject">
                                    <option value="">{{ ___('online-examination.select_subject') }} </option>
                                    @foreach ($data['subjects'] as $item)
                                        <option value="{{ $item->subject->id }}" {{ old('subject', @$data['request']->subject ) == $item->subject->id ? 'selected' : '' }}>{{ $item->subject->name }}</option>
                                    @endforeach
                                </select>
                                @error('subject')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="single_large_selectBox">
                                <input class="form-control ot-input"
                                    name="keyword" list="datalistOptions" id="exampleDataList"
                                    placeholder="{{ ___('online-examination.Search Exam / Start') }}"
                                    value="{{ old('keyword', @$data['request']->keyword) }}">
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
                    @if (hasPermission('online_exam_create'))
                        <a href="{{ route('online-exam.create') }}" class="btn btn-lg ot-btn-primary">
                            <span><i class="fa-solid fa-plus"></i> </span>
                            <span class="">{{ ___('common.add') }}</span>
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered class-table">
                            <thead class="thead">
                                <tr>
                                    <th class="serial">{{ ___('common.sr_no') }}</th>

                                    <th class="purchase">{{ ___('examination.class') }} ({{ ___('examination.section') }})</th>
                                    <th class="purchase">{{ ___('examination.subject') }}</th>

                                    <th class="purchase">{{ ___('common.name') }}</th>
                                    <th class="purchase">{{ ___('online-examination.Type') }}</th>
                                    <th class="purchase">{{ ___('online-examination.Total Mark') }}</th>
                                    <th class="purchase">{{ ___('online-examination.Exam Start') }}</th>
                                    <th class="purchase">{{ ___('online-examination.Exam End') }}</th>
                                    <th class="purchase">{{ ___('online-examination.Duration') }}</th>
                                    <th class="purchase">{{ ___('online-examination.Exam Published') }}</th>

                                    <th class="purchase">{{ ___('common.status') }}</th>
                                    @if (hasPermission('online_exam_update') || hasPermission('online_exam_delete'))
                                        <th class="action">{{ ___('common.action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @forelse ($data['online_exam'] as $key => $row)
                                <tr id="row_{{ $row->id }}">
                                    <td class="serial">{{ ++$key }}</td>

                                    <td>{{ @$row->class->name }} ({{ @$row->section->name }})</td>
                                    <td>{{ @$row->subject->name }}</td>

                                    <td>{{ @$row->name }}</td>
                                    <td>{{ @$row->type->name }}</td>
                                    <td>{{ @$row->total_mark }}</td>
                                    <td>{{ date('d-m-Y H:i a', strtotime(@$row->start)) }}</td>
                                    <td>{{ date('d-m-Y H:i a', strtotime(@$row->end)) }}</td>
                                    <td>
                                        <?php
                                            $startDate = new DateTime($row->start);
                                            $endDate = new DateTime($row->end);
                                            $interval = date_diff($startDate,$endDate);
                                            echo $interval->format('%d Day %h Hour %i Minute');
                                        ?>
                                      </td>
                                    <td>{{ date('d-m-Y H:i a', strtotime(@$row->published)) }}</td>

                                    <td>
                                        @if ($row->status == App\Enums\Status::ACTIVE)
                                            <span class="badge-basic-success-text">{{ ___('common.active') }}</span>
                                        @else
                                            <span class="badge-basic-danger-text">{{ ___('common.inactive') }}</span>
                                        @endif
                                    </td>
                                    @if (hasPermission('online_exam_update') || hasPermission('online_exam_delete'))
                                        <td class="action">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end ">

                                                    <li>
                                                        <a href="{{ route('online-exam.question-download', $row->id) }}" class="dropdown-item">
                                                            <span class="icon mr-8"><i class="fa-solid fa-download"></i></span> {{ ___('online-examination.Download Questions') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalCustomizeWidth" onclick="viewQuestions({{ $row->id }})">
                                                            <span class="icon mr-8"><i class="fa-solid fa-eye"></i></span> {{ ___('online-examination.View Questions') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalCustomizeWidth" onclick="viewStudents({{ $row->id }})">
                                                            <span class="icon mr-8"><i class="fa-solid fa-eye"></i></span> {{ ___('online-examination.View Students') }}
                                                        </a>
                                                    </li>

                                                    @if (hasPermission('online_exam_update'))
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('online-exam.edit', $row->id) }}"><span
                                                                    class="icon mr-8"><i
                                                                        class="fa-solid fa-pen-to-square"></i></span>
                                                                {{ ___('common.edit') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (hasPermission('online_exam_delete'))
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0);"
                                                                onclick="delete_row('online-exam/delete', {{ $row->id }})">
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
                                    {!!$data['online_exam']->links() !!}
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
            <div class="modal-dialog modal-xl"></div>
        </div>
    </div>
@endsection

@push('script')
    @include('backend.partials.delete-ajax')
@endpush
