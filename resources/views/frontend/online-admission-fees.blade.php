@extends('frontend.master')
@section('title')
    {{ ___('frontend.online_admission') }}
@endsection

@push('css')
<style>
    .ot_fileUploader {
        display: flex;
        align-items: center;
        border: 1px solid var(--ot-border-primary) !important;
        height: 48px;
    }
    .left-side {
    flex-direction: row-reverse;

  }
  .ot_fileUploader input.form-control {
    border: 0 !important;
    border-radius: 3px;
    border: 0;
    height: 40px;
    width: 100%;
    box-shadow: none !important;
}
.ot_fileUploader .ot-btn-primary {
    padding: 10px 20px;
}
.ot-btn-common, .ot-dropdown-btn, .ot-btn-primary, .ot-btn-success, .ot-btn-danger, .ot-btn-warning, .ot-btn-info {
    background: linear-gradient(130.57deg, #392C7D -0.48%, #314CAD 71.79%) !important;
}
.ot-btn-common, .ot-dropdown-btn, .ot-btn-primary, .ot-btn-success, .ot-btn-danger, .ot-btn-warning, .ot-btn-info {
    color: #ffffff !important;
    font-weight: 500;
    font-size: 13px;
    text-transform: capitalize;
}
.ot_fileUploader button {
    background: transparent;
}

button {
    border: none;
    outline: none;
}

input[type="file"] {
    padding-left: 10px !important;
}

</style>
@endpush

@section('main')


<!-- bradcam::start  -->
<div class="breadcrumb_area" data-background="{{ @globalAsset(@$sections['study_at']->upload->path, '1920X700.webp') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-xl-5">
                <div class="breadcam_wrap text-center">
                    <h3>{{ ___('frontend.online_admission_payment') }}</h3>
                    <div class="custom_breadcam">
                        <a href="{{url('/')}}" class="breadcrumb-item">{{ ___('frontend.home') }}</a>
                        <a href="#" class="breadcrumb-item">{{ ___('frontend.online_admission_payment') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- bradcam::end  -->

<!-- ADMISSION::START  -->
<div class="search_result_area section_padding">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-xl-8">
                <div class="search_result_box mb_30">
                    @if(session('message'))
                        <div class="section__title mb_50">
                            <h5 class="mb-0 text-success text-center">{{ session('message') }} </h5>
                        </div>
                        
                        @endif

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">{{___('frontend.Student Information')}}</h4>
                        </div>
                        <dv class="card-body">
                            <div class="card_visibility_box">
                                <!-- card_visibility_box_item::start  -->
                                <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                    <span class="card_visibility_box_item_title flex-fill">{{ ___('student_info.first_name') }}</span>
                                    <p>{{$data['admission']->first_name}}</p>
                                </div>
                                <!-- card_visibility_box_item::end  -->
                                <!-- card_visibility_box_item::start  -->
                                <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                    <span class="card_visibility_box_item_title flex-fill">{{ ___('student_info.last_name') }}</span>
                                    <p>{{$data['admission']->last_name}}</p>
                                </div>
                                <!-- card_visibility_box_item::end  -->
                                <!-- card_visibility_box_item::start  -->
                                <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                    <span class="card_visibility_box_item_title flex-fill">{{ ___('student_info.class') }}</span>
                                    <p>{{@$data['admission']->class->name}}</p>
                                </div>
                                <!-- card_visibility_box_item::end  -->
                                <!-- card_visibility_box_item::start  -->
                                <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                    <span class="card_visibility_box_item_title flex-fill">{{ ___('student_info.section') }}</span>
                                    <p>{{@$data['admission']->section->name}}</p>
                                </div>
                                <!-- card_visibility_box_item::end  -->
                                <!-- card_visibility_box_item::start  -->
                                <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                    <span class="card_visibility_box_item_title flex-fill">{{ ___('common.email') }}</span>
                                    <p>{{@$data['admission']->email}}</p>
                                </div>
                                <!-- card_visibility_box_item::end  -->

                                <!-- card_visibility_box_item::start  -->
                                <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                    <span class="card_visibility_box_item_title flex-fill">{{ ___('common.phone') }}</span>
                                    <p>{{@$data['admission']->phone}}</p>
                                </div>
                                <!-- card_visibility_box_item::end  -->
                                <!-- card_visibility_box_item::start  -->
                                <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                    <span class="card_visibility_box_item_title flex-fill">{{ ___('common.date_of_birth') }}</span>
                                    <div class="toggle-checkbox-wrapper">
                                        <input class="toggle-checkbox" type="checkbox" checked name="dob" id="toggle7">
                                        <label class="slider-btn" for="toggle7"></label>
                                    </div>
                                </div>
                                <!-- card_visibility_box_item::end  -->
                            </div>
                        </dv>

                        <div class="card-header d-flex justify-content-between align-items-center mt-2">
                            <h4 class="mb-0">{{___('frontend.Payment Information')}}</h4>
                        </div>
                        <div class="card-body ">

                            @foreach ($data['fees']->group->feeMasters as $feesMaster)
                                <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                    <span class="card_visibility_box_item_title flex-fill">{{ @$feesMaster->type->name }}</span>
                                    <p>{{setting('currency_code')}} {{$feesMaster->amount}}</p>
                                </div>
                            @endforeach

                            <hr>

                            <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                <span class="card_visibility_box_item_title flex-fill"><strong>{{___('common.total')}}</strong></span>
                                <p><strong>{{setting('currency_code')}} {{@$data['fees']->group->feeMasters->sum('amount')}}</strong> </p>
                            </div>
                        </div>

                        <div class="card-header d-flex justify-content-between align-items-center mt-2">
                            <h4 class="mb-0">{{___('frontend.Payment Instruction')}}</h4>
                        </div>
                        <div class="card-body">
                            <p>{{@$data['payment_instruction']->field_value}}</p>
                            <div class="col-md-12 mt-5">
                                <form action="{{route('frontend.online-admission-fees-store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$data['admission']->id}}">
                                    <div class="col-xl-6 mb_24">
                                        <label for="exampleDataList"
                                            class="primary_label2">{{ ___('frontend.upload_payment_document') }}<span
                                                class="fillable"></span></label>
                                        <div class="ot_fileUploader left-side mb-3">
                                            <input class="form-control @error('payment_image') is-invalid @enderror" type="text"
                                                placeholder="{{ ___('common.image') }}" readonly="" id="placeholder">

                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary"
                                                    for="fileBrouse">{{ ___('common.browse') }}</label>
                                                <input type="file" class="d-none form-control" name="payment_image"
                                                    id="fileBrouse" accept="image/*">
                                            </button>
                                            @error('payment_image')
                                                    <p class="input-error error-danger invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-12 text-left d-flex">
                                        <button type="submit" class="theme_btn2  submit-btn text-center d-flex align-items-center m-0 w-100 justify-content-center text-uppercase large_btn">{{ ___('frontend.Submit') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ADMISSION::END  -->


@endsection

@push('script')
<script>
// ONLICK BROUSE FILE UPLOADER
  var fileInp = document.getElementById("fileBrouse");

    if (fileInp){
            fileInp.addEventListener("change", showFileName);
            function showFileName(event) {
            var fileInp = event.srcElement;
            var fileName = fileInp.files[0].name;
            document.getElementById("placeholder").placeholder = fileName;
        }
  }
</script>
@endpush
