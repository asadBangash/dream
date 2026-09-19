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
                    <h4 class="mb-0">{{ ___('student_info.disabled_students') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('disabled_students.search') }}" enctype="multipart/form-data" method="post" id="visitForm">
                    @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="validationServer04" class="form-label">{{ ___('student_info.class') }} <span class="fillable">*</span></label>
                                <select id="getSections" class="nice-select niceSelect bordered_style wide @error('class') is-invalid @enderror" name="class" >
                                    <option value="">{{ ___('student_info.select_class') }}</option>
                                    @foreach ($data['classes'] as $item)
                                        <option {{ old('class',@$request->class) == $item->id ? 'selected' : '' }} value="{{ $item->class->id }}">{{ $item->class->name }}</option>
                                    @endforeach
                                </select>
                                @error('class')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer04" class="form-label">{{ ___('student_info.section') }} <span class="fillable">*</span></label>
                                <select class="sections nice-select niceSelect bordered_style wide @error('section') is-invalid @enderror" name="section" >
                                    <option value="">{{ ___('student_info.select_section') }}</option>
                                    @foreach (@$data['sections'] as $item)
                                        <option {{ old('section',@$request->section) == $item->section->id ? 'selected' : '' }} value="{{ $item->section->id }}">{{ $item->section->name }}</option>
                                    @endforeach
                                </select>
                                @error('section')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="text-end">
                                <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid la-search"></i>
                                    </span>{{ ___('common.Search') }}</button>
                            </div>
                        </div>
                    </form>

                    @if ($students)
                    <form action="{{ route('disabled_students.store') }}" enctype="multipart/form-data" method="post" id="visitForm">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="class" value="{{ $request->class }}">
                        <input type="hidden" name="section" value="{{ $request->section }}">
                        <input type="hidden" name="promote_session" value="{{ $request->promote_session }}">
                        <input type="hidden" name="promote_class" value="{{ $request->promote_class }}">
                        <input type="hidden" name="promote_section" value="{{ $request->promote_section }}">
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered role-table">
                                <thead class="thead">
                                    <tr>
                                        <th class="serial">{{ ___('common.sr_no') }}</th>
                                        <th class="purchase">{{ ___('student_info.admission_no') }}</th>
                                        <th class="purchase">{{ ___('student_info.student_name') }}</th>
                                        <th class="purchase">{{ ___('academic.class') }} ({{ ___('academic.section') }})</th>
                                        <th class="purchase">{{ ___('student_info.guardian_name') }}</th>
                                        <th class="purchase">{{ ___('student_info.date_of_birth') }}</th>
                                        <th class="purchase">{{ ___('common.gender') }}</th>
                                        <th class="purchase">{{ ___('student_info.mobile_number') }}</th>
                                        <th class="purchase">{{ ___('common.status') }}</th>
                                        @if (hasPermission('disabled_students_update') || hasPermission('disabled_students_delete'))
                                            <th class="action">{{ ___('common.action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    @forelse ($students as $key => $item)
                                    <tr id="row_{{ @$item->student->id }}">
                                        <td class="serial">{{ ++$key }}</td>
                                        <td class="serial">{{ @$item->student->admission_no }}</td>
                                        <td>
                                            <div class="">
                                                <a href="{{ route('student.show',@$item->student->id) }}">
                                                    <div class="user-card">
                                                        <div class="user-avatar">
                                                            <img src="{{ @globalAsset(@$item->student->user->upload->path) }}"
                                                                alt="{{ @$item->student->name }}">
                                                        </div>
                                                        <div class="user-info">
                                                            {{ @$item->student->first_name }} {{ @$item->student->last_name }}
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </td>
                                        <td>{{ @$item->student->session_class_student->class->name }} ({{ @$item->student->session_class_student->section->name }})</td>
                                        <td>{{ @$item->student->parent->guardian_name }}</td>
                                        <td>{{ dateFormat(@$item->student->dob) }}</td>
                                        <td>{{ @$item->student->gender->name }}</td>
                                        <td>{{ @$item->student->mobile }}</td>
                                        <td>
                                            @if (@$item->student->status == App\Enums\Status::ACTIVE)
                                                <span class="badge-basic-success-text">{{ ___('common.active') }}</span>
                                            @else
                                                <span class="badge-basic-danger-text">{{ ___('common.inactive') }}</span>
                                            @endif
                                        </td>
                                        @if (hasPermission('disabled_students_update'))
                                            <td class="action">
                                                <div class="dropdown dropdown-action">
                                                    <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end ">
                                                        @if (hasPermission('disabled_students_update'))
                                                            <li>
                                                                <a class="dropdown-item"
                                                                    href="{{ route('student.edit', @$item->student->id) }}"><span
                                                                        class="icon mr-8"><i
                                                                            class="fa-solid fa-pen-to-square"></i></span>
                                                                    {{ ___('common.edit') }}</a>
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
                    </form>
                    @endif
                </div>

            </div>
        </div>
        <!--  table content end -->

    </div>
@endsection

@push('script')
    @include('backend.partials.delete-ajax')
@endpush
