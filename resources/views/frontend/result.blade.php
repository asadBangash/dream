@extends('frontend.master')
@section('title')
    {{ ___('frontend.search_result') }}
@endsection

@section('main')
<!-- bradcam::start  -->
<div class="breadcrumb_area" data-background="{{ @globalAsset(@$sections['study_at']->upload->path, '1920X700.webp') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-xl-5">
                <div class="breadcam_wrap text-center">
                    <h3>{{ ___('frontend.search_result') }}</h3>
                    <div class="custom_breadcam">
                        <a href="{{url('/')}}" class="breadcrumb-item">{{ ___('frontend.home') }}</a>
                        <a href="#" class="breadcrumb-item">{{ ___('frontend.search_result') }}</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- bradcam::end  -->
<!-- search_result_area::start  -->
<div class="search_result_area section_padding">
    <div class="container">
        <div class="row justify-content-center">
            
            <div class="col-xl-7">
                <div class="search_result_box mb_30">
                    <div class="section__title text-center mb_45">
                        <h3 class="theme_text4 mb-0">{{ ___('frontend.check_results') }}</h3>
                        <p class="mb_20 mt-2">{{ ___('frontend.here_check_your_recent_result') }}</p>
                        <div class="border_line d-block mx-auto"></div>
                    </div>
                    <form action="{{ route('frontend.result.search') }}" method="post" enctype="multipart/form-data" id="result">
                        @csrf
                        <div class="search_result_form ">
                            
                            @if ($data['result'])
                                <div class="alert alert-success text-center">
                                    {{ $data['result'] }}
                                </div>
                            @endif

                            <div class="row">

                                <div class="col-xl-6 mb_24">
                                    <label class="primary_label2" for="#">{{ ___('frontend.academic_year_session') }} <span class="fillable">*</span></label>
                                    <select class="theme_select wide session" name="session">
                                        <option value="" data-display="Select">{{ ___('frontend.Select') }}</option>
                                        @foreach ($data['sessions'] as $item)
                                            <option {{ old('session') == $item->id ? 'selected':'' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('session'))
                                        <small class="text-danger">{{ $errors->first('session') }}</small>
                                    @endif
                                </div>
                                
                                <div class="col-xl-6 mb_24">
                                    <label class="primary_label2" for="#">{{ ___('frontend.select_class') }} <span class="fillable">*</span></label>
                                    <select class="theme_select wide classes" name="class">
                                        <option value="" data-display="Select">{{ ___('frontend.Select') }}</option>
                                    </select>
                                    @if ($errors->has('class'))
                                        <small class="text-danger">{{ $errors->first('class') }}</small>
                                    @endif
                                </div>

                                <div class="col-xl-6 mb_24">
                                    <label class="primary_label2" for="#">{{ ___('frontend.select_section') }} <span class="fillable">*</span></label>
                                    <select class="theme_select wide sections" name="section">
                                        <option value="" data-display="Select">{{ ___('frontend.Select') }}</option>
                                    </select>
                                    @if ($errors->has('section'))
                                        <small class="text-danger">{{ $errors->first('section') }}</small>
                                    @endif
                                </div>

                                <div class="col-xl-6 mb_24">
                                    <label class="primary_label2" for="#">{{ ___('frontend.select_exam') }} <span class="fillable">*</span></label>
                                    <select class="theme_select wide exam_types" name="exam">
                                        <option value="" data-display="Select">{{ ___('frontend.Select') }}</option>
                                    </select>
                                    @if ($errors->has('exam'))
                                        <small class="text-danger">{{ $errors->first('exam') }}</small>
                                    @endif
                                </div>

                                <div class="col-xl-12 mb_24">
                                    <label for="exampleDataList" class="primary_label2">{{ ___('frontend.admission_no') }} <span class="fillable">*</span></label>
                                    <input class="form-control ot-input" type="number" value="{{ old('admission_no') }}" name="admission_no" id="exampleDataList" placeholder="{{ ___('frontend.enter_admission_no') }}">
                                    @if ($errors->has('admission_no'))
                                        <small class="text-danger">{{ $errors->first('admission_no') }}</small>
                                    @endif
                                </div>
                                
                                <div class="col-12 mt_10">
                                    <button type="submit" class="theme_btn2  submit-btn text-center d-flex align-items-center m-0 w-100 justify-content-center text-uppercase large_btn">{{ ___('frontend.search_result') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- search_result_area::end  -->

@endsection