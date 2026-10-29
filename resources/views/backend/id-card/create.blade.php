@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('css')
<style>
    .id_card_front {
        width: 250px;
        min-width: 250px;
        height: 387px;
        position: relative;
        border-radius: 8px;
        background: #FFF;
        box-shadow: 0px 4px 11px 0px rgba(0, 0, 0, 0.15);
        display: flex;
        justify-content: center;
        align-items: flex-end;
    }

    .shape_img_top {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 8px;
    }

    .shape_img_top img {
        border-radius: 8px;
        height: 100%;
        width: 100%;
        object-fit: cover;
        object-position: top;
    }

    .id_card_front_inner h3 {
        color: #003249;
        font-family: Lexend;
        font-size: 21.323px;
        font-style: normal;
        font-weight: 600;
        line-height: normal;
        margin-bottom: 8px;
    }

    .id_card_front_inner .class_name {
        color: #003249;
        font-family: Lexend;
        font-size: 12.794px;
        font-style: normal;
        font-weight: 300;
        line-height: normal;
        text-align: center;
        display: block;
        margin-bottom: 12px;
    }

    .student_info p {
        color: #003249;
        font-family: Lexend;
        font-size: 9.946px;
        font-style: normal;
        font-weight: 300;
        line-height: normal;
        margin-bottom: 4px;
    }

    .id_card_profile_img {
        width: 98.315px;
        height: 98.315px;
        transform: rotate(45deg);
        flex-shrink: 0;
        box-shadow: 0px 0px 4.569228172302246px rgba(0, 0, 0, 0.25);
        background: #fff;
        margin: 0 auto;
        position: relative;
        top: -20px;
        margin-bottom: 7px;

    }

    .id_card_profile_img img {
        width: calc(100% + 10px);
        height: calc(100% + 10px);
        transform: rotate(-45deg);
        clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
        position: relative;
        top: -5px;
        right: 5px;
    }

    .id_card_front_info {
        position: relative;
        z-index: 12;
        height: 100%;
        padding-top: 100px;
    }

    .signature_image {
        max-width: 73px;
        margin: 0 auto;
        margin-top: 15px;
    }

    .signature_image img {
        max-width: 100%;
        height: 30px;
        object-fit: cover;
    }

    .id_card_back {
        width: 250px;
        min-width: 250px;
        height: 387px;
        position: relative;
        border-radius: 8px;
        background: #FFF;
        box-shadow: 0px 4px 11px 0px rgba(0, 0, 0, 0.15);
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    .id_card_back .shape_img_top {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 8px;
    }

    .id_card_back .shape_img_top img {
        border-radius: 8px;
        height: 100%;
        width: 100%;
        object-fit: cover;
        object-position: bottom;
    }

    .id_card_back {
        padding: 38px 29px;
        text-align: center;
    }

    .id_card_back_info {
        position: relative;
        z-index: 12;
    }

    .id_card_back .id_card_back_info p {
        color: #003249;
        text-align: center;
        font-family: Lexend;
        font-size: 10.403px;
        font-style: normal;
        font-weight: 300;
        line-height: normal;

    }

    .id_card_back .id_card_back_info h5 {
        color: #003249;
        font-family: Lexend;
        font-size: 10.403px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        margin: 18px 0 25px 0;
    }

    .id_card_back .id_card_back_info .qr_code {
        width: 57.786px;
        height: 57.709px;
        margin: 0 auto;
    }

    .id_card_back .id_card_back_info .qr_code img {
        max-width: 100%;
    }

    .id_card_back_logo_img {
        position: absolute;
        left: 20px;
        bottom: 45px;
        z-index: 15;
        text-align: left;
    }

    .id_card_back_logo_img img{
        max-width: 100px;
        width: 100%;
        object-fit: cover;
    }

    .gap_12 {
        grid-gap: 12px;
    }

    .gray_card {}

    .gray_card .card-header h3 {
        color: #1A1D1F;
        font-family: Lexend;
        font-size: 18px;
        font-style: normal;
        font-weight: 600;
        line-height: 30px;
    }

    .gray_card .card-body {
        background: #F2F2F2;
        border-radius: 0;
    }

    .generated_card_wrapper {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        grid-gap: 24px;
    }

    @media (max-width: 767.98px) {
        .preview_box_wrapper {
            margin-top: 20px;
        }
    }

    @media (min-width: 320px) and (max-width: 575.98px) {
        .generated_card_wrapper {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
    }

    @media (min-width: 576px) and (max-width: 767.98px) {
        .generated_card_wrapper {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 768px) and (max-width: 991.98px) {
        .generated_card_wrapper {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 992px) and (max-width: 1199.98px) {
        .generated_card_wrapper {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    .card_generated_img img {
        max-width: 100%;
        object-fit: cover;
    }

    .ot-btn-cancel {
        border-radius: 4px;
        background: rgba(4, 82, 204, 0.10);
        font-size: 13px;
        font-weight: 500;
    }
</style>
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
        <form action="{{ route('idcard.store') }}" method="post" id="marksheed" enctype="multipart/form-data">
            @csrf
            <div class="table-content table-basic">
                <div class="card">
          
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-7">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.ID_Card_Title') }} <span class="fillable">*</span></label>
                                        <input class="form-control ot-input @error('title') is-invalid @enderror" type="text" name="title" list="datalistOptions" id="exampleDataList" placeholder="{{ ___('common.title') }}" value="{{ old('title') }}">
                                        @error('title')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    @include('backend.id-card.partials.card-type-and-visibility', ['idCard' => null])

                                    <div class="col-md-12 mb-3">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.expired_date') }} <span
                                                class="fillable"></span></label>
                                        <input class="form-control ot-input @error('expired_date') is-invalid @enderror" name="expired_date" type="date"
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
                                        placeholder="{{ ___('account.enter_description') }}">{{ old('backside_description') }}</textarea>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end gap-2">
                                        <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                        </span>{{ ___('common.submit') }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="preview_box_wrapper">
                                    <h4 class="preview_title">{{ ___('common.format') }}</h4>
                                    <div class="preview_box overflow-auto">
                                        @include('backend.id-card.partials.dream-tuition-id-styles')
                                        @php
                                            $previewIsTeacher = old('card_type', \App\Enums\IdCardType::STUDENT) === \App\Enums\IdCardType::TEACHER;
                                        @endphp
                                        <div id="idCardFormatPreviewStudent" class="{{ $previewIsTeacher ? 'd-none' : 'd-flex' }} justify-content-center" style="transform:scale(0.42);transform-origin:top center;">
                                            @include('backend.id-card.partials.dream-student-id', [
                                                'idCard' => (object) ['card_type' => \App\Enums\IdCardType::STUDENT, 'student_name' => true, 'admission_no' => true, 'class_name' => true, 'roll_no' => true, 'expired_date' => now()->addYear()],
                                                'idCardContext' => idCardStudentContext(null, null, true),
                                            ])
                                        </div>
                                        <div id="idCardFormatPreviewTeacher" class="{{ $previewIsTeacher ? 'd-flex' : 'd-none' }} justify-content-center" style="transform:scale(0.55);transform-origin:top center;">
                                            @include('backend.id-card.partials.dream-teacher-id', [
                                                'idCard' => (object) ['card_type' => \App\Enums\IdCardType::TEACHER, 'student_name' => true, 'admission_no' => true, 'class_name' => true, 'section_name' => true, 'dob' => true, 'blood_group' => true],
                                                'idCardContext' => idCardTeacherContext(null, null, true),
                                            ])
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