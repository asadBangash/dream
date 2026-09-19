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
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{___('mainapp_common.Home')}}</a></li>
                        <li class="breadcrumb-item">{{ $data['title'] }}</li>
                        <li class="breadcrumb-item">{{___('mainapp_language.Edit Terms')}}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            {{-- <div class="card-header">
                <h4>{{ ___('language.edit_terms') }}</h4>
            </div> --}}
            <div class="card-body">
                <form action="{{ route('languages.update.terms', @$data['language']->code) }}" enctype="multipart/form-data"
                      method="post" id="terms-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="code" id="code" value="{{ @$data['language']->code }}">
                    <div class="row mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="validationServer04" class="form-label">{{ ___('mainapp_language.module') }}</label>
                            <select class="form-select ot-input @error('lang_module') is-invalid @enderror change-module"
                                    name="lang_module" id="validationServer04" aria-describedby="validationServer04Feedback">
                                @foreach ($modules as $key => $item)
                                    <option value="{{ $key }}">{{ ucfirst($item) }}</option>
                                @endforeach

                            </select>
                            @error('lang_module')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12">

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleDataList" class="form-label ">{{ ___('mainapp_language.term') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleDataList"
                                        class="form-label ">{{ ___('mainapp_language.translated_language') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 term-translated-language">
                            @foreach ($data['terms'] as $key => $row)
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <input class="form-control ot-input" name="name" list="datalistOptions"
                                            id="exampleDataList" value="{{ $key }}" disabled>

                                    </div>
                                    <div class="col-md-6 translated_language">
                                        <input class="form-control ot-input" list="datalistOptions" id="exampleDataList"
                                            placeholder="{{ ___('mainapp_language.translated_language') }}"
                                            name="{{ $key }}" value="{{ $row }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="col-md-12 mt-3">
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
            $('.change-module').on('change', function () {
                const selectedModule = $(this).val();
                const langCode = $('#code').val();

                $.ajax({
                    url: "{{ route('languages.fetch.terms') }}",
                    type: "GET",
                    data: {
                        code: langCode,
                        module: selectedModule
                    },
                    success: function (data) {
                        console.log(data);
                        const $termContainer = $('.term-translated-language');
                        $termContainer.empty();

                        $.each(data, function (key, value) {
                            const row = `
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input class="form-control ot-input" name="name" value="${key}" disabled>
                                </div>
                                <div class="col-md-6 translated_language">
                                    <input class="form-control ot-input" placeholder="{{ ___('mainapp_language.translated_language') }}"
                                        name="${key}" value="${value}">
                                </div>
                            </div>
                        `;
                            $termContainer.append(row);
                        });
                    },
                    error: function (xhr) {
                        console.error('AJAX error:', xhr.responseText);
                    }
                });
            });
        });
    </script>


@endpush
