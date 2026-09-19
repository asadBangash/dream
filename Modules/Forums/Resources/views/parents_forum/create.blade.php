@extends('parent-panel.partials.master')
@section('title')
    {{ @$title }}
@endsection
@section('content')
    <div class="page-content">

        {{-- bradecrumb Area S t a r t --}}
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="bradecrumb-title mb-1">{{ $title }}</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('common.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('parent-panel-forum.index') }}">{{ ___('common.Forums') }}</a>
                        </li>
                        <li class="breadcrumb-item">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    {{-- bradecrumb Area E n d --}}

    <!--  table content start -->
        <div class="table-content table-basic mt-20">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $title }}</h4>
                        <a href="{{ route('parent-panel-forum.index') }}" class="btn btn-lg ot-btn-primary">
                            <span><i class="fa-solid fa-arrow-left"></i> </span>
                            <span class="">{{ ___('common.Back') }}</span>
                        </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('parent-panel-forum.store') }}" class="row" method="post" enctype="multipart/form-data">
                        @csrf()
                        <div class="col-md-6">
                            <label for="exampleDataList" class="form-label ">{{ ___('common.image') }}<span class="fillable">*</span></label>
                            <div class="ot_fileUploader left-side mb-3">
                                <input class="form-control" type="text"
                                       placeholder="{{ ___('common.image') }}" readonly="" id="placeholder">
                                <button class="primary-btn-small-input" type="button">
                                    <label class="btn btn-lg ot-btn-primary"
                                           for="fileBrouse">{{ ___('common.browse') }}</label>
                                    <input type="file" class="d-none form-control" name="image"
                                           id="fileBrouse" accept="image/*">
                                </button>
                            </div>
                            @error('image')  <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="status" class="form-label">{{ ___('common.status') }} <span class="fillable">*</span></label>
                            <select class="nice-select niceSelect bordered_style wide @error('status') is-invalid @enderror"
                                    name="status" id="status">
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

                        <div class="col-md-12">
                            <label for="summernote" class="form-label ">{{ ___('common.Description') }}<span class="fillable">*</span></label>
                            <textarea name="description" id="summernote" class="form-control" rows="10"></textarea>

                            @error('description')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12 mt-24">
                            <div class="text-end">
                                <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                    </span>Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection







