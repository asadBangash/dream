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
                                href="{{ route('event.index') }}">{{ ___('settings.event') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ ___('common.add_new') }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('event.store') }}" enctype="multipart/form-data" method="post" id="visitForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="exampleDataList" class="form-label ">{{ ___('common.title') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('title') is-invalid @enderror" name="title"
                                value="{{ old('title') }}" list="datalistOptions" id="exampleDataList"
                                placeholder="{{ ___('common.enter_title') }}">
                            @error('title')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="exampleDataList"
                                class="form-label ">{{ ___('common.image') }} {{ ___('common.(815 x 500 px)') }}<span
                                    class="fillable">*</span></label>
                            <div class="ot_fileUploader left-side mb-3 @error('image') is-invalid @enderror">
                                <input class="form-control" type="text"
                                    placeholder="{{ ___('common.image') }}" readonly="" id="placeholder">
                                <button class="primary-btn-small-input" type="button">
                                    <label class="btn btn-lg ot-btn-primary"
                                        for="fileBrouse">{{ ___('common.browse') }}</label>
                                    <input type="file" class="d-none form-control" name="image" accept="image/*"
                                        id="fileBrouse">
                                </button>
                            </div>
                            @error('image')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="exampleDataList" class="form-label ">{{ ___('common.Date') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('date') is-invalid @enderror" name="date"
                                value="{{ old('date') }}" list="datalistOptions" id="exampleDataList" type="date"
                                placeholder="{{ ___('common.enter_date') }}">
                            @error('date')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="exampleDataList" class="form-label ">{{ ___('common.address') }} </label>
                            <input class="form-control ot-input @error('address') is-invalid @enderror" name="address"
                                value="{{ old('address') }}" list="datalistOptions" id="exampleDataList"
                                placeholder="{{ ___('common.enter_address') }}">
                            @error('address')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="exampleDataList" class="form-label ">{{ ___('common.start_time') }} </label>
                            <input class="form-control ot-input @error('start_time') is-invalid @enderror" name="start_time"
                                value="{{ old('start_time') }}" list="datalistOptions" id="exampleDataList" type="time"
                                placeholder="{{ ___('common.enter_start_time') }}">
                            @error('start_time')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="exampleDataList" class="form-label ">{{ ___('common.end_time') }} </label>
                            <input class="form-control ot-input @error('end_time') is-invalid @enderror" name="end_time"
                                value="{{ old('end_time') }}" list="datalistOptions" id="exampleDataList" type="time"
                                placeholder="{{ ___('common.enter_end_time') }}">
                            @error('end_time')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationServer04" class="form-label">{{ ___('common.status') }} <span class="fillable">*</span></label>
                            <select class="nice-select niceSelect bordered_style wide @error('status') is-invalid @enderror"
                            name="status" id="validationServer04"
                            aria-describedby="validationServer04Feedback">
                                <option value="{{ App\Enums\Status::ACTIVE }}">{{ ___('common.active') }}</option>
                                <option value="{{ App\Enums\Status::INACTIVE }}">{{ ___('common.inactive') }}
                                </option>
                            </select>
                            @error('status')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="exampleDataList" class="form-label">{{ ___('common.Description') }}</label>
                            <textarea id="summernote" class="form-control ot-textarea @error('description') is-invalid @enderror" name="description"
                            list="datalistOptions" id="exampleDataList"
                            placeholder="{{ ___('common.Enter description') }}">{{ old('description') }}</textarea>
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
@endsection
