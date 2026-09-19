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
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> {{ ___('common.home') }} </a></li>
                        <li class="breadcrumb-item"><a href="{{ route('event.index') }}">{{ $data['title'] }}</a></li>
                        <li class="breadcrumb-item">{{ ___('common.edit') }}</li>

                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('event.translate.update', @$data['event']->id) }}" enctype="multipart/form-data" method="post"
                    id="visitForm">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-lg-12">

                            @foreach ($data['languages'] as $language)

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.name') }}- ({{$language->name}})<span
                                                class="fillable">*</span></label>
                                        <input class="form-control ot-input @error('title') is-invalid @enderror" name="title[{{$language->code}}]"
                                            value="{{isset($data['translates'][$language->code][0]) ? $data['translates'][$language->code][0]->title :  @$data['event']->title}}" list="datalistOptions" id="exampleDataList"
                                            placeholder="{{ ___('common.enter_name') }}">
                                        @error('title')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label for="exampleDataList" class="form-label">{{ ___('common.Description') }}- ({{$language->name}})</label>
                                        <textarea class="form-control summernote ot-textarea @error('description') is-invalid @enderror" name="description[{{$language->code}}]"
                                        list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('common.Enter description') }}">{{isset($data['translates'][$language->code][0]) ? $data['translates'][$language->code][0]->description :  @$data['event']->description}}</textarea>
                                        @error('description')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.address') }}- ({{$language->name}})<span
                                                class="fillable">*</span></label>
                                        <input class="form-control ot-input @error('address') is-invalid @enderror" name="address[{{$language->code}}]"
                                            value="{{isset($data['translates'][$language->code][0]) ? $data['translates'][$language->code][0]->address :  @$data['event']->address}}" list="datalistOptions" id="exampleDataList"
                                            placeholder="{{ ___('common.enter_name') }}">
                                        @error('address')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach


                                <div class="col-md-12 mt-24">
                                    <div class="text-end">
                                        <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                            </span>{{ ___('common.update') }}</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function () {
            try {
                $('.summernote').summernote({
                    tabsize: 2,
                    height: 300
                });
            } catch (e) {

            }
        });
    </script>
@endpush
