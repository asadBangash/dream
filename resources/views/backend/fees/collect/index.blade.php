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

        <div class="row">
            <div class="col-12">
                <div class="card ot-card mb-24 position-relative z_1">
                    <form action="{{ route('fees-collect-search') }}" enctype="multipart/form-data" method="post" id="fees-collect">
                        @csrf
                    <div class="card-header d-flex align-items-center gap-4 flex-wrap">
                        <h3 class="mb-0">{{ ___('common.Filtering') }}</h3>

                        <div class="card_header_right d-flex align-items-center gap-3 flex-fill justify-content-end flex-wrap">
                            <!-- table_searchBox -->

                            <div class="single_selectBox">
                                <select id="getSections" class="class nice-select niceSelect bordered_style wide" name="class">
                                    <option value="">{{ ___('student_info.select_class') }}</option>
                                @foreach ($data['classes'] as $item)
                                    <option {{ old('class') == $item->id ? 'selected' : '' }} value="{{ $item->class->id }}">{{ $item->class->name }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="single_selectBox">
                                <select class="sections section nice-select niceSelect bordered_style wide" name="section">
                                    <option value="">{{ ___('student_info.select_section') }}</option>
                                </select>
                            </div>
                            <div class="single_selectBox">
                                <select class="students nice-select niceSelect bordered_style wide @error('student') is-invalid @enderror"
                                    name="student">
                                    <option value="">{{ ___('student_info.select_student') }}</option>
                                </select>
                                @error('student')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="input-group table_searchBox">
                                <input name="name" type="text" class="form-control" placeholder="{{___('common.name')}} " aria-label="Search " aria-describedby="searchIcon">
                                <span class="input-group-text" id="searchIcon">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                            </div>
                            <button class="btn btn-lg ot-btn-primary">
                                {{ ___('common.Search')}}
                            </button>
                        </div>


                    </div>
                </form>
                </div>
            </div>
        </div>

        @isset($data['students'])

        <!--  table content start -->
        <div class="table-content table-basic mt-20">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $data['title'] }}</h4>

                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered role-table" id="students_table">
                            <thead class="thead">
                                <tr>
                                    <th class="purchase">{{___('student_info.student_name') }}</th>
                                    <th class="purchase">{{ ___('student_info.admission_no') }}</th>
                                    <th class="purchase">{{ ___('academic.class') }} ({{ ___('academic.section') }})</th>
                                    <th class="purchase">{{ ___('student_info.guardian_name') }}</th>
                                    <th class="purchase">{{ ___('student_info.mobile_number') }}</th>
                                    @if (hasPermission('fees_collect_create'))
                                        <th class="purchase">{{ ___('common.action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data['students'] as $item)
                                <tr id="document-file">
                                    <td>{{ @$item->student->first_name }} {{ @$item->student->last_name }}</td>
                                    <td>{{ @$item->student->admission_no }}</td>
                                    <td>{{ @$item->class->name }} ({{ @$item->section->name }})</td>
                                    <td>{{ @$item->student->parent->guardian_name }}</td>
                                    <td>{{ @$item->student->mobile }}</td>
                                    @if (hasPermission('fees_collect_create'))
                                        <td><a href="{{ route('fees-collect.collect',$item->student_id) }}" target="_blank" class="btn btn-sm ot-btn-primary">{{___('fees.Collect')}}</a></td>
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
                     <!--  pagination start -->

                    <div class="ot-pagination pagination-content d-flex justify-content-end align-content-center py-3">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-between">
                                {!!$data['students']->appends(\Request::capture()->except('page'))->links() !!}
                            </ul>
                        </nav>
                    </div>

                <!--  pagination end -->
                </div>

            </div>
        </div>
        <!--  table content end -->

        @endif

    </div>
@endsection

@push('script')
    @include('backend.partials.delete-ajax')
@endpush
