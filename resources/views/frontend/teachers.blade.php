@extends('frontend.master')
@section('title')
    {{ @$sections['our_teachers']->defaultTranslate->name ?? ___('frontend.our_teachers') }}
@endsection

@section('main')
    <!-- bradcam::start  -->
    <div class="breadcrumb_area" data-background="{{ @globalAsset(@$sections['study_at']->upload->path, '1920X700.webp') }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-xl-5">
                    <div class="breadcam_wrap text-center">
                        <h3>{{ @$sections['our_teachers']->defaultTranslate->name }}</h3>
                        <div class="custom_breadcam">
                            <a href="{{ url('/') }}" class="breadcrumb-item">{{ ___('frontend.home') }}</a>
                            <a href="#" class="breadcrumb-item">{{ @$sections['our_teachers']->defaultTranslate->name }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- bradcam::end  -->

    @include('frontend.partials.our-teachers', [
        'teachers' => $data['teachers'],
        'teachersPageUrl' => null,
        'showViewAll' => false,
    ])
@endsection
