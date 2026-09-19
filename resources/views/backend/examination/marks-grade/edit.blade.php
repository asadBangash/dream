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
                        <li class="breadcrumb-item" aria-current="page"><a
                                href="{{ route('marks-grade.index') }}">{{ $data['title'] }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ ___('common.edit') }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('marks-grade.update', @$data['marks_grade']->id) }}" enctype="multipart/form-data" method="post"
                    id="visitForm">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('common.name') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('name') is-invalid @enderror" name="name"
                                        list="datalistOptions" id="exampleDataList" type="text"
                                        placeholder="{{ ___('common.enter_name') }}" value="{{ old('name', @$data['marks_grade']->name) }}">
                                    @error('name')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('examination.point') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('point') is-invalid @enderror" name="point"
                                        list="datalistOptions" id="exampleDataList" type="number" step="any"
                                        placeholder="{{ ___('common.enter_point') }}" value="{{ old('point', @$data['marks_grade']->point) }}">
                                    @error('point')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('examination.percent_from') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('percent_from') is-invalid @enderror" name="percent_from"
                                        list="datalistOptions" id="exampleDataList" type="number" step="any"
                                        placeholder="{{ ___('common.enter_percent_from') }}" value="{{ old('percent_from', @$data['marks_grade']->percent_from) }}">
                                    @error('percent_from')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('examination.percent_upto') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('percent_upto') is-invalid @enderror" name="percent_upto"
                                        list="datalistOptions" id="exampleDataList" type="number" step="any"
                                        placeholder="{{ ___('common.enter_percent_upto') }}" value="{{ old('percent_upto', @$data['marks_grade']->percent_upto) }}">
                                    @error('percent_upto')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('examination.remarks') }} <span
                                            class="fillable"></span></label>
                                    <input class="form-control ot-input @error('remarks') is-invalid @enderror" name="remarks"
                                        list="datalistOptions" id="exampleDataList" type="text"
                                        placeholder="{{ ___('common.enter_remarks') }}" value="{{ old('remarks', @$data['marks_grade']->remarks) }}">
                                    @error('remarks')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">

                                    <label for="validationServer04" class="form-label">{{ ___('common.status') }} <span class="fillable">*</span></label>
                                    <select class="nice-select niceSelect bordered_style wide @error('status') is-invalid @enderror"
                                    name="status" id="validationServer04"
                                    aria-describedby="validationServer04Feedback">
                                    <option value="{{ App\Enums\Status::ACTIVE }}"
                                    {{ @$data['marks_grade']->status == App\Enums\Status::ACTIVE ? 'selected' : '' }}>
                                    {{ ___('common.active') }}</option>
                                <option value="{{ App\Enums\Status::INACTIVE }}"
                                    {{ @$data['marks_grade']->status == App\Enums\Status::INACTIVE ? 'selected' : '' }}>
                                    {{ ___('common.inactive') }}
                                </option>
                                    </select>

                                    @error('status')
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
@endsection
