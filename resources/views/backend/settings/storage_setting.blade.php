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
                    <li class="breadcrumb-item">{{ $data['title'] }}</li>
                </ol>
            </div>
        </div>
    </div>
    {{-- bradecrumb Area E n d --}}

    <div class="card ot-card">
        <div class="card-header ">
            <h4>{{ ___('settings.aws_s3_info') }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('settings.storageSettingUpdate') }}" enctype="multipart/form-data" method="post"
                id="visitForm">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-12">
                            <div class="row mb-3">
                                {{-- File System start --}}
                                <div class="col-sm-6 mb-3">

                                {{-- File System start --}}
                                    <label for="inputname" class="form-label">{{ ___('settings.file_system') }} <span class="text-danger">*</span></label>
                                    <select class="nice-select niceSelect form-select ot-input file_system  bordered_style wide @error('file_system') is-invalid @enderror"
                                        value="{{ Setting('file_system') }}"
                                        name="file_system" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('common.select') }}</option>
                                        <option value="local" {{ setting('file_system') == "local" ? "selected":"" }}>{{ ___('settings.local') }}</option>
                                        <option value="s3" {{ setting('file_system') == "s3" ? "selected":"" }}>{{ ___('settings.s3') }}</option>
                                    </select>
                                @error('file_system')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>
                        {{-- File System end --}}

                        {{-- ACCESS KEY start --}}
                        <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3 _common_div">
                                <label for="inputname" class="form-label">{{ ___('settings.aws_access_key_id') }} <span class="text-danger">*</span></label>
                                <input type="text" name="aws_access_key_id"
                                    class="form-control ot-input @error('aws_access_key_id') is-invalid @enderror"
                                    value="{{ setting('aws_access_key_id') }}" placeholder="{{ ___('settings.aws_access_key_id') }}">
                                @error('aws_access_key_id')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        {{-- ACCESS KEY start --}}

                        {{-- SECRET ACCESS KEY start --}}
                        <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3 _common_div">
                                <label for="inputname" class="form-label"> {{ ___('settings.aws_secret_key') }} <span class="text-danger">*</span></label>
                                <input type="text" name="aws_secret_key"
                                    class="form-control ot-input @error('aws_secret_key') is-invalid @enderror"
                                    value="{{ setting('aws_secret_key') }}" placeholder="{{ ___('settings.aws_secret_key') }}">
                                @error('aws_secret_key')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        {{-- SECRET ACCESS KEY end --}}

                        {{-- REGION start --}}
                        <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3 _common_div">
                                <label for="inputname" class="form-label">{{ ___('settings.aws_default_region') }} <span class="text-danger">*</span></label>
                                <input type="text" name="aws_region"
                                    class="form-control ot-input @error('aws_region') is-invalid @enderror"
                                    value="{{ Setting('aws_region') }}" placeholder="{{ ___('settings.aws_default_region') }}">
                                @error('aws_region')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        {{-- REGION end --}}

                        {{-- BUCKET start --}}
                        <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3 _common_div">
                                <label for="inputname" class="form-label">{{ ___('settings.aws_bucket') }} <span class="text-danger">*</span></label>
                                <input type="text" name="aws_bucket"
                                    class="form-control ot-input @error('aws_bucket') is-invalid @enderror"
                                    value="{{  setting('aws_bucket') }}" placeholder="{{ ___('settings.aws_bucket') }}">
                                @error('aws_bucket')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        {{-- BUCKET end --}}

                        {{-- ENDPOINT start --}}
                        <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3 _common_div">
                                <label for="inputname" class="form-label">{{ ___('settings.aws_endpoint') }} <span class="text-danger">*</span></label>
                                <input type="text" name="aws_endpoint"
                                    class="form-control ot-input @error('aws_endpoint') is-invalid @enderror"
                                    value="{{ Setting('aws_endpoint') }}" placeholder="{{ ___('settings.aws_endpoint') }}">
                                @error('aws_endpoint')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            {{-- ENDPOINT end --}}
                        </div>

                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="text-end">
                            @if (hasPermission('email_settings_update'))
                                <button class="btn btn-lg ot-btn-primary">
                                    <span>
                                        <i class="fa-solid fa-save"></i>
                                    </span>{{ ___('common.update') }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

