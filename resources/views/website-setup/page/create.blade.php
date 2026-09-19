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
                                href="{{ route('page.index') }}">{{ ___('settings.page') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ ___('common.add_new') }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('page.store') }}" enctype="multipart/form-data" method="post" id="visitForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="exampleDataList" class="form-label ">{{ ___('common.name') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" list="datalistOptions" id="exampleDataList"
                                placeholder="{{ ___('common.enter_title') }}">
                            @error('name')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>





                        <div class="col-md-3 mb-3">
                            <label for="validationServer04" class="form-label">{{ ___('common.menu_show') }} <span class="fillable">*</span></label>
                            <select class="nice-select niceSelect bordered_style wide @error('menu_show') is-invalid @enderror"
                            name="menu_show" id="validationServer04"
                            aria-describedby="validationServer04Feedback">
                                <option value="header">{{ ___('common.header') }}</option>
                                <option value="footer">{{ ___('common.footer') }}
                                </option>
                            </select>
                            @error('menu_show')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="validationServer04" class="form-label">{{ ___('common.status') }} <span class="fillable">*</span></label>
                            <select class="nice-select niceSelect bordered_style wide @error('active_status') is-invalid @enderror"
                            name="active_status" id="validationServer04"
                            aria-describedby="validationServer04Feedback">
                                <option value="1">{{ ___('common.active') }}</option>
                                <option value="0">{{ ___('common.inactive') }}
                                </option>
                            </select>
                            @error('active_status')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="exampleDataList" class="form-label">{{ ___('common.Description') }} <span class="fillable">*</span> </label>
                            <textarea id="summernote" class="form-control ot-textarea @error('content') is-invalid @enderror" name="content"
                            list="datalistOptions" id="exampleDataList"
                            placeholder="{{ ___('common.Enter description') }}">{{ old('content') }}</textarea>
                            @error('content')
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
