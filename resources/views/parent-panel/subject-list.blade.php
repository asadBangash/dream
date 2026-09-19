@extends('parent-panel.partials.master')

@section('title')
{{ ___('common.Subject List') }}
@endsection

@section('content')
<div class="page-content">

    <div class="col-12 p-0">
        <form action="{{ route('parent-panel-subject-list.search') }}" method="post" id="marksheed" enctype="multipart/form-data">
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
                <h4 class="mb-0">{{___('settings.subject_list')}}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered class-table">
                        <thead class="thead">
                            <tr>
                                <th class="serial">{{ ___('common.sr_no') }}</th>
                                <th class="purchase">{{ ___('common.name') }}</th>
                                <th class="purchase">{{ ___('academic.code') }}</th>
                                <th class="purchase">{{ ___('academic.type') }}</th>
                                <th class="purchase">{{ ___('academic.teacher') }}</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            @if(@$data['subjectTeacher'])
                                @forelse (@$data['subjectTeacher']->subjectTeacher as $key => $row)
                                <tr id="row_{{ $row->id }}">
                                    <td class="serial">{{ ++$key }}</td>
                                    <td>{{ $row->subject->name }}</td>
                                    <td>{{ $row->subject->code }}</td>
                                    <td>
                                        @if ($row->subject->type == App\Enums\SubjectType::THEORY)
                                        {{ ___('academic.theory') }}
                                        @elseif ($row->subject->type == App\Enums\SubjectType::PRACTICAL)
                                        {{ ___('academic.practical') }}
                                        @endif
                                    </td>
                                    <td>{{ $row->teacher->first_name }} {{ $row->teacher->last_name }} <br> <small>{{ $row->teacher->email }}</small></td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="100%" class="text-center gray-color">
                                        <img src="{{ asset('images/no_data.svg') }}" alt="" class="mb-primary" width="100">
                                        <p class="mb-0 text-center">{{ ___('common.no_data_available') }}</p>
                                        <p class="mb-0 text-center text-secondary font-size-90">
                                            {{ ___('common.please_add_new_entity_regarding_this_table') }}
                                        </p>
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