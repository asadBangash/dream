@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection

@section('css')
<style>
    .toggle-checkbox:disabled~.slider-btn:before {
    background-color: #9f9f9f; /* Adjust the color as needed */
    border-color: #a8a8a9; /* Adjust the color as needed */
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
                        <li class="breadcrumb-item">{{ $data['title'] }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <!--  table content start -->
        <div class="table-content table-basic mt-20">

            <div class="card mb-5">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{___('common.Admission_Fees_Setting')}}</h4>
                </div>

                <div class="card-body">
                    <form action="{{route('online-admissions.setting.update')}}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <input type="hidden" name="type" value="fees_setting">

                            <div class="col-md-12 mb-3">
                                <label for="exampleDataList" class="form-label">{{ ___('fees.description') }}</label>
                                <textarea class="form-control ot-textarea @error('field_value') is-invalid @enderror" name="field_value[admission_payment_info]"
                                    list="datalistOptions" id="exampleDataList"
                                    placeholder="{{ ___('fees.enter_description') }}"> {{$data['admission_payment_info'] ? $data['admission_payment_info']->field_value : old('field_value.admission_payment_info')}}</textarea>
                                    @error('description')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">{{___('frontend.online_admission_fees_enable')}}<span class="fillable"></span></label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-check-radio academic-section ">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" name="online_admission_fees" value="1" id="flexCheckDefault-1" @if($data['admission_payment']->is_show == 1) checked @endif>
                                      <label class="form-check-label ps-2 pe-5" for="flexCheckDefault-1">{{___('common.Yes')}}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <code class="text-danger">{{___('common.Before_Enabling_Online_Admission_Fees_Please_Assigned_Admission_Fees_From')}} <a target="_blank" href="{{url('/online-admissions-setting/fees')}}">{{url('/online-admissions-setting/fees')}}</a></code>
                            </div>

                            <div class="col-md-12 mt-24">
                                <div class="text-end">
                                    <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                        </span>{{ ___('common.submit') }}</button>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>

            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $data['title'] }}</h4>
                </div>
                <form action="{{route('online-admissions.setting.update')}}" method="post">
                    @csrf

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered role-table">
                                <thead class="thead">
                                    <tr>
                                        <th class="serial w-50">{{ ___('common.field') }}</th>
                                        <th class="purchase">{{ ___('common.visibility') }} </th>
                                        <th class="purchase">{{ ___('common.required') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    @foreach ($data['fields'] ?? [] as $key => $field)
                                    
                                        <input type="hidden" name="id[]" value="{{$field->id}}">
                                    <tr id="row_{{ $field->id }}">
                                        <td>{{ucwords(str_replace('_', ' ',___('frontend.'.$field->field)))}} @if($field->is_system_required) <span class="text-danger">*</span> @endif</td>
                                        <td>
                                            <input type="hidden" class="visibility" name="visibility[]" value="{{ $field->is_show ? 1 : 0 }}">
                                            <div class="toggle-checkbox-wrapper">
                                                <input
                                                    class="toggle-checkbox"
                                                    type="checkbox"
                                                    @if($field->is_show) checked @endif id="visibility{{$field->id}}"
                                                    @if($field->is_system_required) disabled @endif
                                                    onchange="toggleVisibility(this)"
                                                >
                                                <label class="slider-btn" for="visibility{{$field->id}}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="hidden" class="required" name="required[]" value="{{ $field->is_required ? 1 : 0 }}">

                                            <div class="toggle-checkbox-wrapper">
                                                <input
                                                    class="toggle-checkbox"
                                                    type="checkbox"
                                                    @if($field->is_required) checked @endif
                                                    id="required{{$field->id}}"
                                                    @if($field->is_system_required) disabled  @endif
                                                    onchange="toggleRequired(this)"
                                                >
                                                <label class="slider-btn" for="required{{$field->id}}" @if($field->is_system_required) data-toggle="tooltip" data-placement="top" title="{{ ___('common.Required_With_System_Cant_Modify')}}"  @endif></label>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-12 d-flex justify-content-end gap-2">
                            <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                            </span>{{ ___('common.submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--  table content end -->

    </div>


    <div id="view-modal">
        <div class="modal fade" id="openCertificatePreviewModal" tabindex="-1" aria-labelledby="modalWidth"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" id="modalWidth">
                    <div class="modal-header modal-header-image">
                        <h5 class="modal-title" id="modalLabel2">
                            {{ ___('common.Preview') }}
                        </h5>

                    </div>

                        <div class="modal-body p-5">

                        </div>
                </div>

            </div>
        </div>
    </div>



@endsection



@push('script')
<script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip();
    });


    function toggleVisibility(obj) {

        if ($(obj).prop("checked")) {
            $(obj).closest('td').find('.visibility').val(1)
        } else {
            $(obj).closest('td').find('.visibility').val(0)
        }
    }

    function toggleRequired(obj) {
        if ($(obj).prop("checked")) {
            $(obj).closest('td').find('.required').val(1)
        } else {
            $(obj).closest('td').find('.required').val(0)
        }
    }
  </script>
    @include('backend.partials.delete-ajax')
@endpush
