@extends('backend.master')

@section('title', 'Id Card')

@section('content')
<div class="page-content">

    {{-- bradecrumb Area S t a r t --}}
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="bradecrumb-title mb-1">{{ ___('common.Id Card') }}</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('common.home') }}</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('blood-groups.index') }}">{{ ___('settings.Id Card') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ ___('common.Create Id Card') }}</li>
                    </ol>
            </div>
        </div>
    </div>
    {{-- bradecrumb Area E n d --}}

    <div class="col-12">
        <form action="{{ route('student.search') }}" method="post" id="marksheed" enctype="multipart/form-data">
            @csrf
            <div class="table-content table-basic">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Create Id Card</h4>
                        <a href="/id_card/generate" class="btn btn-lg ot-btn-primary">
                            <span><i class="fa-solid fa-plus mr-2"></i> </span>
                            <span class="">{{ ___('common.Genrate Id') }}</span>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-7">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('student_info.ID Card Title') }} <span class="fillable">*</span></label>
                                        <input class="form-control ot-input @error('admission_no') is-invalid @enderror" type="text" name="admission_no" list="datalistOptions" id="exampleDataList" placeholder="{{ ___('student_info.enter_admission_no') }}" value="{{ old('admission_no') }}">
                                        @error('admission_no')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('student_info.Card Direction') }} <span class="fillable">*</span></label>
                                        <div class="single_small_selectBox">
                                            <select id="getSections" class="class nice-select niceSelect bordered_style wide @error('class') is-invalid @enderror" name="class">
                                                <option value="Student 9">Student</option>
                                                <option value="Student 9">Student</option>
                                                <option value="Student 9">Student</option>
                                            </select>
                                            @error('class')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.image') }} {{ ___('common.Background') }}<span class="fillable"></span></label>
                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control" type="text" placeholder="{{ ___('common.image') }}" readonly="" id="placeholder">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary text-nowrap " for="fileBrouse">{{ ___('common.browse') }}</label>
                                                <input type="file" class="d-none form-control" name="image" id="fileBrouse" accept="image/*">
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="exampleDataList" class="form-label ">{{ ___('student_info.Applicable User') }} <span class="fillable">*</span></label>
                                        <div class="single_small_selectBox">
                                            <select id="getSections" class="class nice-select mb-3 niceSelect bordered_style wide @error('class') is-invalid @enderror" name="class">
                                                <option value="Student 9">Student</option>
                                                <option value="Student 9">Student</option>
                                                <option value="Student 9">Student</option>
                                            </select>
                                            @error('class')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('student_info.Width ( Default 100 MM)') }} <span class="fillable">*</span></label>
                                        <input class="form-control ot-input @error('admission_no') is-invalid @enderror" type="text" name="admission_no" list="datalistOptions" id="exampleDataList" placeholder="{{ ___('student_info.120') }}" value="{{ old('admission_no') }}">
                                        @error('admission_no')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('student_info.Height ( Default 100 MM)') }} <span class="fillable">*</span></label>
                                        <input class="form-control ot-input @error('admission_no') is-invalid @enderror" type="text" name="admission_no" list="datalistOptions" id="exampleDataList" placeholder="{{ ___('student_info.120') }}" value="{{ old('admission_no') }}">
                                        @error('admission_no')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.image') }} {{ ___('common.Profile Image') }}<span class="fillable"></span></label>
                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control" type="text" placeholder="{{ ___('common.image') }}" readonly="" id="placeholder2">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary text-nowrap" for="fileBrouse2">{{ ___('common.browse') }}</label>
                                                <input type="file" class="d-none form-control" name="image" id="fileBrouse2" accept="image/*">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="exampleDataList" class="form-label ">{{ ___('student_info.User Photo Style') }} <span class="fillable">*</span></label>
                                        <div class="single_small_selectBox">
                                            <select id="getSections" class="class nice-select niceSelect mb-3 bordered_style wide @error('class') is-invalid @enderror" name="class">
                                                <option value="Student 9">Student</option>
                                                <option value="Student 9">Student</option>
                                                <option value="Student 9">Student</option>
                                            </select>
                                            @error('class')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('student_info.User Photo Width ( Default 100 MM)') }} <span class="fillable">*</span></label>
                                        <input class="form-control ot-input @error('admission_no') is-invalid @enderror" type="text" name="admission_no" list="datalistOptions" id="exampleDataList" placeholder="{{ ___('student_info.120') }}" value="{{ old('admission_no') }}">
                                        @error('admission_no')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('student_info.User Photo Height ( Default 100 MM) *') }} <span class="fillable">*</span></label>
                                        <input class="form-control ot-input @error('admission_no') is-invalid @enderror" type="text" name="admission_no" list="datalistOptions" id="exampleDataList" placeholder="{{ ___('student_info.120') }}" value="{{ old('admission_no') }}">
                                        @error('admission_no')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.image') }} {{ ___('common.Your Logo') }}<span class="fillable"></span></label>
                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control" type="text" placeholder="{{ ___('common.image') }}" readonly="" id="placeholder3">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary text-nowrap" for="fileBrouse3">{{ ___('common.browse') }}</label>
                                                <input type="file" class="d-none form-control" name="image" id="fileBrouse3" accept="image/*">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.image') }} {{ ___('common.Signature') }}<span class="fillable"></span></label>
                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control " type="text" placeholder="{{ ___('common.image') }}" readonly="" id="placeholder4">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary text-nowrap" for="fileBrouse4">{{ ___('common.browse') }}</label>
                                                <input type="file" class="d-none form-control" name="image" id="fileBrouse4" accept="image/*">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('student_info.ID Card Visibility') }} <span class="fillable">*</span></label>
                                        <div class="card_visibility_box">
                                            <!-- card_visibility_box_item::start  -->
                                            <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                                <span class="card_visibility_box_item_title flex-fill">Admission No</span>
                                                <div class="toggle-checkbox-wrapper">
                                                    <input class="toggle-checkbox" type="checkbox" id="Admission">
                                                    <label class="slider-btn" for="Admission"></label>
                                                </div>
                                            </div>
                                            <!-- card_visibility_box_item::end  -->
                                            <!-- card_visibility_box_item::start  -->
                                            <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                                <span class="card_visibility_box_item_title flex-fill">Student Name</span>
                                                <div class="toggle-checkbox-wrapper">
                                                    <input class="toggle-checkbox" type="checkbox" id="3">
                                                    <label class="slider-btn" for="3"></label>
                                                </div>
                                            </div>
                                            <!-- card_visibility_box_item::end  -->
                                            <!-- card_visibility_box_item::start  -->
                                            <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                                <span class="card_visibility_box_item_title flex-fill">Class</span>
                                                <div class="toggle-checkbox-wrapper">
                                                    <input class="toggle-checkbox" type="checkbox" id="4">
                                                    <label class="slider-btn" for="4"></label>
                                                </div>
                                            </div>
                                            <!-- card_visibility_box_item::end  -->
                                            <!-- card_visibility_box_item::start  -->
                                            <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                                <span class="card_visibility_box_item_title flex-fill">Section</span>
                                                <div class="toggle-checkbox-wrapper">
                                                    <input class="toggle-checkbox" type="checkbox" id="toggle5">
                                                    <label class="slider-btn" for="toggle5"></label>
                                                </div>
                                            </div>
                                            <!-- card_visibility_box_item::end  -->
                                            <!-- card_visibility_box_item::start  -->
                                            <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                                <span class="card_visibility_box_item_title flex-fill">Signature</span>
                                                <div class="toggle-checkbox-wrapper">
                                                    <input class="toggle-checkbox" type="checkbox" id="toggle6">
                                                    <label class="slider-btn" for="toggle6"></label>
                                                </div>
                                            </div>
                                            <!-- card_visibility_box_item::end  -->
                                            <!-- card_visibility_box_item::start  -->
                                            <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                                <span class="card_visibility_box_item_title flex-fill">Blood Group</span>
                                                <div class="toggle-checkbox-wrapper">
                                                    <input class="toggle-checkbox" type="checkbox" id="toggle7">
                                                    <label class="slider-btn" for="toggle7"></label>
                                                </div>
                                            </div>
                                            <!-- card_visibility_box_item::end  -->
                                            <!-- card_visibility_box_item::start  -->
                                            <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                                <span class="card_visibility_box_item_title flex-fill">Expired Date </span>
                                                <div class="toggle-checkbox-wrapper">
                                                    <input class="toggle-checkbox" type="checkbox" id="toggle8">
                                                    <label class="slider-btn" for="toggle8"></label>
                                                </div>
                                            </div>
                                            <!-- card_visibility_box_item::end  -->
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end gap-2">
                                        <button class="btn btn-lg ot-btn-cancel">
                                            <span class="">{{ ___('common.Cancel') }}</span>
                                        </button>
                                        <button class="btn btn-lg ot-btn-primary">
                                            <span class="">{{ ___('common.Save Certificate') }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="preview_box_wrapper">
                                    <h4 class="preview_title">Preview</h4>
                                    <div class="preview_box  ">
                                        <div class="preview_box_inner d-flex flex-wrap flex-xxl-nowrap">
                                            <!-- id_card_front  -->
                                            <div class="id_card_front">
                                                <div class="shape_img_top">
                                                    <img src="{{ asset('backend') }}/uploads/card-images/card-top-shape.png" alt="">
                                                </div>
                                                <div class="id_card_front_info">
                                                    <div class="id_card_front_inner">
                                                        <div class="id_card_profile_img">
                                                            <!-- <img src="{{ asset('backend') }}/uploads/card-images/card_profile.png" alt=""> -->
                                                            <img src="https://bennettfeely.com/clippy/pics/pittsburgh.jpg" alt="">
                                                        </div>
                                                        <h3>Student Name</h3>
                                                        <span class="class_name">Class 6 (A)</span>
                                                    </div>
                                                    <div class="student_info">
                                                        <p>ID No 123.456.789</p>
                                                        <p>DOB MM/DD/YEAR</p>
                                                        <p>Section A</p>
                                                        <p>Blood Group B+ (Positive)</p>
                                                        <div class="signature_image ">
                                                            <img src="{{ asset('backend') }}/uploads/card-images/signature.png" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- id_card_front  -->
                                            <div class="id_card_back">
                                                <div class="id_card_back_info">
                                                    <p>Lorem ipsum dolor sit amet, consectetuer consequat. Aenean et eros in justo pretium laoreet. Pellentesque pharetra purus dui, non vestibulum arcu dapibus at.</p>
                                                    <h5>EXPIRED: MM/DD/YEAR</h5>
                                                    <div class="qr_code">
                                                        <img src="{{ asset('backend') }}/uploads/card-images/qr_code.png" alt="">
                                                    </div>
                                                </div>

                                                <div class="id_card_back_logo_img">
                                                    <img src="{{ asset('backend') }}/uploads/card-images/logo.png" alt="">
                                                </div>
                                                <div class="shape_img_top">
                                                    <img src="{{ asset('backend') }}/uploads/card-images/card-bottom-shape.png" alt="#">
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