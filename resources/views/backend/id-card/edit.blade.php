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
                            href="{{ route('idcard.index') }}">{{ ___('common.id card') }}</a></li>
                    <li class="breadcrumb-item" aria-current="page"><a
                            href="#">{{ $data['title'] }}</a></li>
                </ol>
            </div>
        </div>
    </div>
    {{-- bradecrumb Area E n d --}}

    <div class="col-12">
        <form action="{{ route('idcard.update', [$data['id_card']->id]) }}" method="post" id="marksheed" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="table-content table-basic">
                <div class="card">
          
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-7">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.ID_Card_Title') }} <span class="fillable">*</span></label>
                                        <input class="form-control ot-input @error('title') is-invalid @enderror" type="text" name="title" value="{{$data['id_card']->title}}" list="datalistOptions" id="exampleDataList" placeholder="{{ ___('student_info.enter_admission_no') }}" value="{{ old('admission_no') }}">
                                        @error('title')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.expired_date') }} <span
                                                class="fillable"></span></label>
                                        <input class="form-control ot-input @error('expired_date') is-invalid @enderror" name="expired_date" value="{{$data['id_card']->expired_date}}" type="date"
                                            value="{{ old('expired_date') }}" list="datalistOptions" id="exampleDataList"
                                            placeholder="{{ ___('common.enter expired date') }}">
                                        @error('expired_date')
                                            <div id="validationServer06Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.frontside_background_image') }}<span class="fillable"></span></label>
                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control" type="text" placeholder="{{ ___('common.image') }}" readonly="" id="placeholder">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary text-nowrap " for="fileBrouse">{{ ___('common.browse') }}</label>
                                                <input type="file" class="d-none form-control" name="frontside_bg_image" id="fileBrouse" accept="image/*">
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.backside_background_image') }}<span class="fillable"></span></label>
                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control" type="text" placeholder="{{ ___('common.image') }}" readonly="" id="placeholder2">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary text-nowrap " for="fileBrouse2">{{ ___('common.browse') }}</label>
                                                <input type="file" class="d-none form-control" name="backside_bg_image" id="fileBrouse2" accept="image/*">
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.signature') }}<span class="fillable"></span></label>
                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control" type="text" placeholder="{{ ___('common.image') }}" readonly="" id="placeholder3">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary text-nowrap " for="fileBrouse3">{{ ___('common.browse') }}</label>
                                                <input type="file" class="d-none form-control" name="signature" id="fileBrouse3" accept="image/*">
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.QR_Code') }}<span class="fillable"></span></label>
                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control" type="text" placeholder="{{ ___('common.image') }}" readonly="" id="placeholder4">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary text-nowrap " for="fileBrouse4">{{ ___('common.browse') }}</label>
                                                <input type="file" class="d-none form-control" name="qr_code" id="fileBrouse4" accept="image/*">
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.backside_description') }}</label>
                                        <textarea id="summernote" class="form-control ot-textarea @error('backside_description') is-invalid @enderror" name="backside_description"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('account.enter_description') }}">{{ old('backside_description', $data['id_card']->backside_description) }}</textarea>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.ID_Card_Visibility') }} <span class="fillable"></span></label>
                                        <div class="card_visibility_box">
                                            <!-- card_visibility_box_item::start  -->
                                            <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                                <span class="card_visibility_box_item_title flex-fill">{{ ___('student_info.admission_no') }}</span>
                                                <div class="toggle-checkbox-wrapper">
                                                    <input class="toggle-checkbox" type="checkbox" name="admission_no" {{$data['id_card']->admission_no == true ? 'checked':''}} id="Admission">
                                                    <label class="slider-btn" for="Admission"></label>
                                                </div>
                                            </div>
                                            <!-- card_visibility_box_item::end  -->
                                            <!-- card_visibility_box_item::start  -->
                                            <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                                <span class="card_visibility_box_item_title flex-fill">{{ ___('student_info.roll_no') }}</span>
                                                <div class="toggle-checkbox-wrapper">
                                                    <input class="toggle-checkbox" type="checkbox" name="roll_no" {{$data['id_card']->roll_no == true ? 'checked':''}} id="Roll">
                                                    <label class="slider-btn" for="Roll"></label>
                                                </div>
                                            </div>
                                            <!-- card_visibility_box_item::end  -->
                                            <!-- card_visibility_box_item::start  -->
                                            <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                                <span class="card_visibility_box_item_title flex-fill">{{ ___('common.student_name') }}</span>
                                                <div class="toggle-checkbox-wrapper">
                                                    <input class="toggle-checkbox" type="checkbox" name="student_name" {{$data['id_card']->student_name == true ? 'checked':''}} id="3">
                                                    <label class="slider-btn" for="3"></label>
                                                </div>
                                            </div>
                                            <!-- card_visibility_box_item::end  -->
                                            <!-- card_visibility_box_item::start  -->
                                            <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                                <span class="card_visibility_box_item_title flex-fill">{{ ___('common.class_name') }}</span>
                                                <div class="toggle-checkbox-wrapper">
                                                    <input class="toggle-checkbox" type="checkbox" name="class_name" {{$data['id_card']->class_name == true ? 'checked':''}} id="4">
                                                    <label class="slider-btn" for="4"></label>
                                                </div>
                                            </div>
                                            <!-- card_visibility_box_item::end  -->
                                            <!-- card_visibility_box_item::start  -->
                                            <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                                <span class="card_visibility_box_item_title flex-fill">{{ ___('common.section_name') }}</span>
                                                <div class="toggle-checkbox-wrapper">
                                                    <input class="toggle-checkbox" type="checkbox" name="section_name" {{$data['id_card']->section_name == true ? 'checked':''}} id="toggle5">
                                                    <label class="slider-btn" for="toggle5"></label>
                                                </div>
                                            </div>
                                            <!-- card_visibility_box_item::end  -->
                                  
                                            <!-- card_visibility_box_item::start  -->
                                            <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                                <span class="card_visibility_box_item_title flex-fill">{{ ___('common.blood_group') }}</span>
                                                <div class="toggle-checkbox-wrapper">
                                                    <input class="toggle-checkbox" type="checkbox" {{$data['id_card']->student_name == true ? 'checked':''}} name="blood_group" id="toggle7">
                                                    <label class="slider-btn" for="toggle7"></label>
                                                </div>
                                            </div>
                                            <!-- card_visibility_box_item::end  -->
                                             <!-- card_visibility_box_item::start  -->
                                             <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                                <span class="card_visibility_box_item_title flex-fill">{{ ___('common.date_of_birth') }}</span>
                                                <div class="toggle-checkbox-wrapper">
                                                    <input class="toggle-checkbox" type="checkbox" checked name="dob" {{$data['id_card']->dob == true ? 'checked':''}} id="toggle8">
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
                                    <h4 class="preview_title">{{ ___('common.format') }}</h4>
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
                                                    <img width="50%" src="{{  @globalAsset(setting('light_logo'), '154X38.webp')  }}" alt="#">
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