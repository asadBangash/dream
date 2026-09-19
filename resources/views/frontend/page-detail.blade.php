@extends('frontend.master')
@section('title')
    {{ @$data['page']->defaultTranslate->name }}
@endsection

@section('main')


<!-- bradcam::start  -->
<div class="breadcrumb_area" data-background="{{ @globalAsset(@$sections['study_at']->upload->path, '1920X700.webp') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-xl-5">
                <div class="breadcam_wrap text-center">
                    <h3>{{ @$data['page']->defaultTranslate->name }}</h3>
                    <div class="custom_breadcam">
                        <a href="{{url('/')}}" class="breadcrumb-item">{{ ___('frontend.home') }}</a>
                        <a href="#" class="breadcrumb-item">{{ @$data['page']->defaultTranslate->name }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- bradcam::end  -->

<!-- STATEMENT_AREA::START  -->
<div class="statement_area section_padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="section__title text-center mb_50">
                    <h3>{{ @$data['page']->defaultTranslate->name }}</h3>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="ck-ditor-img">
                    {!! @$data['page']->defaultTranslate->content !!}
                </div>

            </div>
        </div>
    </div>
</div>
<!-- STATEMENT_AREA::END  -->

@endsection
