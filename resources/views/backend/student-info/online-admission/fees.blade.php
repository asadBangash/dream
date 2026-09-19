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
            <div class="col-md-3">
                <div class="card ot-card">
                    <div class="card-body">
                        @if(isset($assign_fees))
                        <form action="{{ route('online-admissions.setting.feesUpdate') }}" enctype="multipart/form-data" method="post" id="visitForm">
                            <input type="hidden" name="id" value="{{$assign_fees->id}}">
                        @else
                        <form action="{{ route('online-admissions.setting.feesStore')}}" enctype="multipart/form-data" method="post" id="visitForm">
                        @endif

                            @csrf
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <div class="row">
                                        @if ($errors->has('admission_fees_master'))
                                            <div class="alert alert-danger alert-dismissable">
                                                <span class="text-danger mb-2">{{ $errors->first('admission_fees_master') }}</span>
                                            </div>
                                        @endif


                                        <input type="hidden" name="session_id" value="{{ isset($assign_fees) ? $assign_fees->session_id : setting('session') }} ">
                                        <div class="col-md-12 mb-3">
                                            <label for="validationServer04" class="form-label">{{ ___('student_info.fees_group') }} <span
                                                class="fillable">*</span></label>
                                            <select id="feesGroup"
                                                class="nice-select niceSelect bordered_style wide @error('fees_group') is-invalid @enderror"
                                                name="fees_group" id="validationServer04"
                                                aria-describedby="validationServer04Feedback">
                                                <option value="">{{ ___('student_info.select_fees_group') }}</option>
                                                @foreach ($data['fees_groups'] as $group)
                                                    <option {{ ( isset($assign_fees) && $assign_fees->fees_group_id == $group->id ) ? 'selected': '' }} value="{{ $group->id }}">{{ $group->name }}
                                                @endforeach
                                                </option>
                                            </select>

                                            @error('fees_group')
                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="validationServer04" class="form-label">{{ ___('student_info.class') }} <span
                                                class="fillable">*</span></label>
                                            <select id="getSections"
                                                class="nice-select niceSelect bordered_style wide @error('class') is-invalid @enderror"
                                                name="class" id="validationServer04"
                                                aria-describedby="validationServer04Feedback">
                                                <option value="">{{ ___('student_info.select_class') }}</option>
                                                @foreach ($data['classes'] as $item)
                                                    <option {{ ( isset($assign_fees) && $assign_fees->class_id == $item->id ) ? 'selected': '' }} value="{{ $item->class->id }}">{{ $item->class->name }}
                                                @endforeach
                                                </option>
                                            </select>

                                            @error('class')
                                                <div id="validationServer04Feedback" class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mb-3">

                                                <label for="validationServer04" class="form-label">{{ ___('student_info.section') }} <span
                                                    class="fillable">*</span></label>
                                                <select id="getSections"
                                                    class="nice-select sections niceSelect bordered_style wide @error('section') is-invalid @enderror"
                                                    name="section" id="validationServer04"
                                                    aria-describedby="validationServer04Feedback">
                                                    <option value="">{{ ___('student_info.select_section') }}</option>

                                                    @isset($assign_fees)
                                                        @foreach ($data['sections'] as $item)
                                                            <option {{ (isset($assign_fees) && $assign_fees->section_id == $item->id) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                                @error('section')
                                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="exampleDataList" class="form-label">{{ ___('fees.description') }}</label>
                                            <textarea class="form-control ot-textarea @error('description') is-invalid @enderror" name="description"
                                                list="datalistOptions" id="exampleDataList"
                                                placeholder="{{ ___('fees.enter_description') }}">{{ (isset($assign_fees)) ? $assign_fees->description : old('description') }} </textarea>
                                                @error('description')
                                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                        </div>


                                        <div class="col-md-12 mt-24">
                                            <div class="text-end">
                                                <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                                    </span>{{ ___('common.submit') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <!--  table content start -->
                <div class="table-content table-basic">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">{{ ___('fees.fees_master') }}</h4>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered role-table">
                                    <thead class="thead">
                                        <tr>
                                            <th class="serial">{{ ___('common.sr_no') }}</th>
                                            <th class="purchase">{{ ___('common.name') }}</th>
                                            <th class="purchase">{{ ___('academic.class') }}</th>
                                            <th class="purchase">{{ ___('academic.section') }}</th>
                                            <th class="purchase">{{ ___('fees.amount') }} ({{ Setting('currency_symbol') }})</th>

                                            <th class="action">{{ ___('common.action') }}</th>

                                        </tr>
                                    </thead>
                                    <tbody class="tbody">
                                        @forelse ($data['fees'] as $key => $row)
                                        <tr id="row_{{ $row->id }}">
                                            <td class="serial">{{ ++$key }}</td>
                                            <td>{{@$row->group->name}}</td>
                                            <td>{{@$row->class->name}}</td>
                                            <td>{{@$row->section->name}}</td>
                                            <td> {{@$row->group->feeMasters->sum('amount')}}</td>

                                            <td class="action">
                                                @if (hasPermission('fees_master_update') || hasPermission('fees_master_delete'))
                                                    <div class="dropdown dropdown-action">
                                                        <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            <i class="fa-solid fa-ellipsis"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end ">
                                                            @if (hasPermission('fees_master_update'))
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('online-admissions.setting.feesEdit', $row->id) }}"><span
                                                                            class="icon mr-8"><i
                                                                                class="fa-solid fa-pen-to-square"></i></span>
                                                                        {{ ___('common.edit') }}</a>
                                                                </li>
                                                            @endif
                                                            @if (hasPermission('fees_master_delete'))
                                                                <li>
                                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                                        onclick="delete_row('online-admissions-setting/fees-delete', {{ $row->id }})">
                                                                        <span class="icon mr-8"><i
                                                                                class="fa-solid fa-trash-can"></i></span>
                                                                        <span>{{ ___('common.delete') }}</span>
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                @endif
                                            </td>
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
                                            {!!$data['fees']->links() !!}
                                        </ul>
                                    </nav>
                                </div>

                            <!--  pagination end -->
                        </div>
                    </div>
                </div>
        <!--  table content end -->

            </div>
        </div>
        <!--  table content end -->

    </div>
@endsection

@push('script')
    @include('backend.partials.delete-ajax')
@endpush
