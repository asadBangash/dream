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
                                href="{{ route('class-setup.index') }}">{{ $data['title'] }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ ___('common.add_new') }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('class-setup.store') }}" enctype="multipart/form-data" method="post" id="visitForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="validationServer04" class="form-label">{{ ___('academic.class') }} <span class="fillable">*</span></label>
                                        <select class="nice-select niceSelect bordered_style wide @error('classes') is-invalid @enderror"
                                        name="classes" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                            <option value="">{{ ___('common.select class') }}</option>
                                            @foreach ($data['classes'] as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('classes')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">{{ ___('academic.section') }} <span class="fillable">*</span></label>
                                        <div class="input-check-radio academic-section @error('sections') is-invalid @enderror">
                                            @foreach ($data['section'] as $item)
                                                <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="sections[]" value="{{$item->id}}" id="flexCheckDefault" />
                                                <label class="form-check-label ps-2 pe-5" for="flexCheckDefault">{{ $item->name }}</label>
                                                </div>
                                            @endforeach
                                    </div>
                                        @error('sections')
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
                                </div>
                                <div class="col-md-12 mt-24">
                                    <div class="text-end">
                                        <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i> </span>{{ ___('common.submit') }}</button>
                                    </div>
                                </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
