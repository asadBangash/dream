@extends('backend.master')
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
                        <li class="breadcrumb-item"><a href="{{ route('forum.index') }}">{{ ___('common.Forums') }}</a>
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
                    @if (hasPermission('forum_list'))
                        <a href="{{ route('forum.index') }}" class="btn btn-lg ot-btn-primary">
                            <span><i class="fa-solid fa-arrow-left"></i> </span>
                            <span class="">{{ ___('common.Back') }}</span>
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    <form action="{{ route('forum.update', $forum->id) }}" class="row" method="post" enctype="multipart/form-data">
                        @csrf()
                        @method('put')
                        <div class="col-md-3">
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
                        <div class="col-lg-3">
                            <label for="views_count" class="form-label">{{ ___('common.Views Count') }}</label>
                            <input name="views_count" id="views_count" placeholder="{{ ___('common.Views Count') }}" class="email form-control ot-input mb_30" type="number" value="{{ $forum->views_count }}">
                            @error('views_count')
                            <div id="validationServer04Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-3">
                            <label for="status" class="form-label">{{ ___('common.Publish Status') }}</label>
                            <select class="nice-select niceSelect bordered_style wide @error('is_published') is-invalid @enderror" name="is_published" id="status">
                                <option {{ $forum->is_published == 1 ? 'selected' : '' }} value="1">{{ ___('common.Published') }}</option>
                                <option {{ $forum->is_published == 0 ? 'selected' : '' }} value="0">{{ ___('common.Unpublished') }}</option>
                            </select>

                            @error('is_published')
                            <div id="validationServer04Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-3">
                            <label for="status" class="form-label">{{ ___('common.status') }} <span class="fillable">*</span></label>
                            <select class="nice-select niceSelect bordered_style wide @error('status') is-invalid @enderror" name="status" id="status">
                                <option {{ $forum->status == \App\Enums\Status::ACTIVE ? 'selected' : '' }} value="{{ App\Enums\Status::ACTIVE }}">{{ ___('common.active') }}</option>
                                <option {{ $forum->status == \App\Enums\Status::INACTIVE ? 'selected' : '' }} value="{{ App\Enums\Status::INACTIVE }}">{{ ___('common.inactive') }}</option>
                            </select>

                            @error('status')
                            <div id="validationServer04Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-12 __role mb-3">
                            <label for="terget_roles" class="form-label">
                                {{ ___('common.Terget Roles') }}<span class="fillable">*</span>
                            </label>
                            <select class="form-control role_ids select2_multy wide nice-select" name="target_roles[]" id="target_roles" multiple="multiple">
                                @foreach ($roles as $key => $value)
                                    <option value="{{ $key }}" {{ in_array($key, $forum->target_roles ?? []) ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('target_roles')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="summernote" class="form-label ">{{ ___('common.Description') }}<span class="fillable">*</span></label>
                            <textarea name="description" id="summernote" class="form-control" rows="10">{!! @$forum->description !!}</textarea>

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







