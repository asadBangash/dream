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
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> {{ ___('common.home') }} </a></li>
                        <li class="breadcrumb-item"><a href="{{ route('time_schedule.index') }}">{{ $data['title'] }}</a></li>
                        <li class="breadcrumb-item">{{ ___('common.edit') }}</li>

                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('time_schedule.update', @$data['time_schedule']->id) }}" enctype="multipart/form-data" method="post"
                    id="visitForm">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">

                            <label for="validationServer04" class="form-label">{{ ___('academic.type') }} <span class="fillable">*</span></label>
                            <select class="nice-select niceSelect bordered_style wide @error('type') is-invalid @enderror"
                            name="type" id="validationServer04"
                            aria-describedby="validationServer04Feedback">
                                <option {{ old('type', @$data['time_schedule']->type) == 1 ? 'selected':'' }} value="1">{{ ___('academic.class') }}</option>
                                <option {{ old('type', @$data['time_schedule']->type) == 2 ? 'selected':'' }} value="2">{{ ___('academic.exam') }}
                                </option>
                            </select>

                            @error('type')
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
                                <option {{ old('status', @$data['time_schedule']->status) == App\Enums\Status::ACTIVE ? 'selected':'' }} value="{{ App\Enums\Status::ACTIVE }}">{{ ___('common.active') }}</option>
                                <option {{ old('status', @$data['time_schedule']->status) == App\Enums\Status::INACTIVE ? 'selected':'' }} value="{{ App\Enums\Status::INACTIVE }}">{{ ___('common.inactive') }}
                                </option>
                            </select>

                            @error('status')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="exampleDataList" class="form-label ">{{ ___('academic.start_time') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('start_time') is-invalid @enderror" name="start_time"
                                list="datalistOptions" id="exampleDataList" type="time"
                                placeholder="{{ ___('academic.enter_start_time') }}" value="{{ old('start_time',@$data['time_schedule']->start_time) }}">
                            @error('start_time')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="exampleDataList" class="form-label ">{{ ___('academic.end_time') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('end_time') is-invalid @enderror" name="end_time"
                                list="datalistOptions" id="exampleDataList" type="time"
                                placeholder="{{ ___('academic.enter_end_time') }}" value="{{ old('end_time',@$data['time_schedule']->end_time) }}">
                            @error('end_time')
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
                </form>
            </div>
        </div>
    </div>
@endsection
