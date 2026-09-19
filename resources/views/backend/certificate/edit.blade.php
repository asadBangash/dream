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
                            href="{{ route('certificate.index') }}">{{ ___('common.certificate') }}</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a
                            href="#">{{ $data['title'] }}</a></li>
                </ol>
            </div>
        </div>
    </div>
    {{-- bradecrumb Area E n d --}}

    <div class="col-12">
        <form action="{{ route('certificate.update', [$data['certificate']->id]) }}" method="post" id="marksheed" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="table-content table-basic">
                <div class="card">
          
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-7">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.certificate_title') }} <span class="fillable">*</span></label>
                                        <input class="form-control ot-input @error('title') is-invalid @enderror" type="text" value="{{$data['certificate']->title}}" name="title" list="datalistOptions" id="exampleDataList" placeholder="{{ ___('student_info.enter_admission_no') }}" value="{{ old('admission_no') }}">
                                        @error('title')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.top_text') }} <span class="fillable">*</span></label>
                                        <input class="form-control ot-input @error('top_text') is-invalid @enderror" type="text" value="{{$data['certificate']->top_text}}" name="top_text" list="datalistOptions" id="exampleDataList" placeholder="{{ ___('student_info.enter_admission_no') }}" value="{{ old('admission_no') }}">
                                        @error('top_text')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('account.description') }}
                                            ([student_name], [class_name], [section_name], [school_name], [session], [school_address])
                                        </label>
                                        <textarea id="summernote" class="form-control ot-textarea @error('description') is-invalid @enderror" name="description"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('account.description') }}">{{ old('description', $data['certificate']->description) }}</textarea>
                                        @error('description')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>


                                    <div class="col-md-12">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.background_image') }}<span class="fillable"></span></label>
                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control" type="text" placeholder="{{ ___('common.bg_image') }}" readonly="" id="placeholder">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary text-nowrap " for="fileBrouse">{{ ___('common.browse') }}</label>
                                                <input type="file" class="d-none form-control" name="bg_image" id="fileBrouse" accept="image/*">
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.bottom_left_text') }}</label>
                                        <textarea id="summernote2" class="form-control ot-textarea @error('bottom_left_text') is-invalid @enderror" name="bottom_left_text"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('account.bottom_left_text') }}">{{ old('bottom_left_text', $data['certificate']->bottom_left_text) }}</textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.bottom_left_signature') }}<span class="fillable"></span></label>
                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control" type="text" placeholder="{{ ___('common.bottom_left_signature') }}" readonly="" id="placeholder2">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary text-nowrap " for="fileBrouse2">{{ ___('common.browse') }}</label>
                                                <input type="file" class="d-none form-control" name="bottom_left_signature" id="fileBrouse2" accept="image/*">
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.bottom_right_text') }}</label>
                                        <textarea id="summernote3" class="form-control ot-textarea @error('description') is-invalid @enderror" name="bottom_right_text"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('common.bottom_right_text') }}">{{ old('bottom_right_text', $data['certificate']->bottom_right_text) }}</textarea>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.bottom_right_signature') }}<span class="fillable"></span></label>
                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control" type="text" placeholder="{{ ___('common.bottom_right_signature') }}" readonly="" id="placeholder3">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary text-nowrap " for="fileBrouse3">{{ ___('common.browse') }}</label>
                                                <input type="file" class="d-none form-control" name="bottom_right_signature" id="fileBrouse3" accept="image/*">
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.certificate_visibility') }} <span class="fillable"></span></label>
                                        <div class="card_visibility_box">
                                            <!-- card_visibility_box_item::start  -->
                                            <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                                <span class="card_visibility_box_item_title flex-fill">{{ ___('common.logo') }}</span>
                                                <div class="toggle-checkbox-wrapper">
                                                    <input class="toggle-checkbox" type="checkbox" name="logo" {{$data['certificate']->logo == true ? 'checked':''}} id="logo">
                                                    <label class="slider-btn" for="logo"></label>
                                                </div>
                                            </div>
                                            <!-- card_visibility_box_item::end  -->
                                            <!-- card_visibility_box_item::start  -->
                                            <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                                <span class="card_visibility_box_item_title flex-fill">{{ ___('common.name') }}</span>
                                                <div class="toggle-checkbox-wrapper">
                                                    <input class="toggle-checkbox" type="checkbox" name="name" {{$data['certificate']->name == true ? 'checked':''}} id="name">
                                                    <label class="slider-btn" for="name"></label>
                                                </div>
                                            </div>
                                            <!-- card_visibility_box_item::end  -->
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end gap-2">
                                        <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                        </span>{{ ___('common.submit') }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="preview_box_wrapper ">
                                    <h4 class="preview_title">{{ ___('common.format') }}</h4>
                                    <div class="certificate_wrapper_preview_box">
                                        <div class="certificate_wrapper">
                                            <div class="certificate_wrapper_bg">
                                                <img src="{{ asset('backend') }}/uploads/card-images/certificate_bg.png" alt="">
                                            </div>
                                            <div class="large_logo">
                                                <img src="{{  @globalAsset(setting('dark_logo'), '154X38.webp')  }}" alt="#">
                                            </div>
                                            <div class="certificate_info">
                                                <h3>Certificate</h3>
                                                <p class="subtext">OF APPRECIATION</p>
                                                <p class="subtext_short_description">THIS CERTIFICATE IS PROUDLY PRESENTEDTO</p>
                                                <div class="certificate__name">
                                                    <h2>Name Surname</h2>
                                                </div>
                                                <p class="certificate_description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident</p>
                                            </div>
                                            <div class="signature_imgs">
                                                <div class="signature_single">
                                                    <div class="signature_img">
                                                        <img src="{{ asset('backend') }}/uploads/card-images/MANAGER_signature.png" alt="">
                                                    </div>
                                                    <div class="border_1px"></div>
                                                    <span>MANAGER</span>
                                                </div>
                                                <div class="signature_single">
                                                    <div class="signature_img">
                                                        <img src="{{ asset('backend') }}/uploads/card-images/MANAGER_signature.png" alt="">
                                                    </div>
                                                    <div class="border_1px"></div>
                                                    <span>DIRECTOR</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection