@extends('mainapp::layouts.backend.master')

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
                                href="{{ route('feature.index') }}">{{ ___('settings.feature') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ ___('common.add_new') }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('feature.store') }}" enctype="multipart/form-data" method="post" id="visitForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="exampleDataList" class="form-label">{{ ___('common.title') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('title') is-invalid @enderror" name="title"
                                list="datalistOptions" id="exampleDataList"
                                placeholder="{{ ___('common.Enter title') }}" value="{{ old('title') }}">
                            @error('title')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="exampleDataList"
                                class="form-label ">{{ ___('common.Icon') }} {{ ___('common.(60 x 60 px)') }}</label>
                            <div class="ot_fileUploader left-side mb-3">
                                <input class="form-control" type="text"
                                    placeholder="{{ ___('common.icon') }}" readonly="" id="placeholder2">
                                <button class="primary-btn-small-input" type="button">
                                    <label class="btn btn-lg ot-btn-primary"
                                        for="fileBrouse2">{{ ___('common.browse') }}</label>
                                    <input type="file" class="d-none form-control" name="icon" accept="image/*"
                                        id="fileBrouse2">
                                </button>
                            </div>
                        </div>
                                                        
                        <div class="col-md-6 mb-3">
                            <label for="exampleDataList" class="form-label">{{ ___('common.Position') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('position') is-invalid @enderror" name="position" type="number"
                                list="datalistOptions" id="exampleDataList"
                                placeholder="{{ ___('common.Enter position') }}" value="{{ old('position') }}">
                            @error('position')
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
                                <option {{ old('status', App\Enums\Status::ACTIVE) == App\Enums\Status::ACTIVE ? 'selected':'' }} value="{{ App\Enums\Status::ACTIVE }}">{{ ___('common.active') }}</option>
                                <option {{ old('status', App\Enums\Status::INACTIVE) == App\Enums\Status::INACTIVE ? 'selected':'' }} value="{{ App\Enums\Status::INACTIVE }}">{{ ___('common.inactive') }}
                                </option>
                            </select>

                            @error('status')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                                                        
                                                  
                        <div class="col-12 mb-3">
                            <label for="exampleDataList" class="form-label">{{ ___('common.Description') }} <span
                                    class="fillable">*</span></label>
                            <textarea id="summernote" class="mt-0 form-control ot-textarea @error('description') is-invalid @enderror" name="description" list="datalistOptions" id="exampleDataList"
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
                </form>
            </div>
        </div>
    </div>
@endsection
