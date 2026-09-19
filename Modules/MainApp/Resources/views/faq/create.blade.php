@extends('mainapp::layouts.backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    <div class="page-content">

        {{-- bradecrumb Area S t a r t --}}
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="bradecrumb-title mb-1">{{ $data['title'] }}</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('mainapp_common.home') }}</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a
                                href="{{ route('faq.index') }}">{{ ___('mainapp_faq.faq') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ ___('mainapp_common.add_new') }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('faq.store') }}" enctype="multipart/form-data" method="post" id="visitForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="exampleDataList" class="form-label">{{ ___('mainapp_faq.Question') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('question') is-invalid @enderror" name="question"
                                list="datalistOptions" id="exampleDataList"
                                placeholder="{{ ___('mainapp_faq.Enter question') }}" value="{{ old('question') }}">
                            @error('question')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="exampleDataList" class="form-label">{{ ___('mainapp_common.Position') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('position') is-invalid @enderror" name="position" type="number"
                                list="datalistOptions" id="exampleDataList"
                                placeholder="{{ ___('mainapp_common.Enter position') }}" value="{{ old('position') }}">
                            @error('position')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="validationServer04" class="form-label">{{ ___('mainapp_common.Status') }} <span class="fillable">*</span></label>
                            <select class="nice-select niceSelect bordered_style wide @error('status') is-invalid @enderror"
                            name="status" id="validationServer04"
                            aria-describedby="validationServer04Feedback">
                                <option {{ old('status') == App\Enums\Status::ACTIVE ? 'selected':'' }} value="{{ App\Enums\Status::ACTIVE }}">{{ ___('mainapp_common.active') }}</option>
                                <option {{ old('status') == App\Enums\Status::INACTIVE ? 'selected':'' }} value="{{ App\Enums\Status::INACTIVE }}">{{ ___('mainapp_common.inactive') }}
                                </option>
                            </select>

                            @error('status')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="col-12 mb-3">
                            <label for="exampleDataList" class="form-label">{{ ___('mainapp_common.Answer') }} <span
                                    class="fillable">*</span></label>
                            <textarea id="summernote" class="mt-0 form-control ot-textarea @error('answer') is-invalid @enderror" name="answer" list="datalistOptions" id="exampleDataList"
                                    placeholder="{{ ___('mainapp_common.Enter answer') }}">{{ old('answer') }}</textarea>
                            @error('answer')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="col-md-12 mt-24">
                            <div class="text-end">
                                <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                    </span>{{ ___('mainapp_common.submit') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection



@push('script')
    <script>
        $(document).ready(function () {
            try {
                $('#summernote').summernote();
            } catch (e) {

            }
        });
    </script>
@endpush
