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
                        <li class="breadcrumb-item"><a href="#">{{ ___("settings.examination") }}</a></li>
                        <li class="breadcrumb-item">{{ $data['title'] }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-header">
                <h4>{{ ___('settings.examination_settings') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('examination-settings.update') }}" enctype="multipart/form-data" method="post"
                    id="visitForm">
                    @csrf
                    @method('put')
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="row mb-3">
                                <!--average pass marks -->
                                <div class="col-12 col-md-12 mb-3 ">
                                    <label for="inputname" class="form-label">{{ ___('settings.average_pass_marks_percentage') }} <span
                                            class="fillable">*</span></label>
                                    <input type="number" name="values[]"
                                        class="form-control ot-input @error('average_pass_marks') is-invalid @enderror"
                                        value="{{examSetting('average_pass_marks')}}"
                                        placeholder="{{ ___('settings.Enter Average Pass marks(Percentage)') }}" />
                                        <input type="hidden" name="fields[]" value="average_pass_marks" />
                                    @error('average_pass_marks')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <!-- Update Button Start-->
                            <div class="text-end">
                                @if (hasPermission('exam_setting_update'))
                                    <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                        </span>{{ ___('common.update') }}</button>
                                @endif
                            </div>
                            <!-- Update Button End-->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
