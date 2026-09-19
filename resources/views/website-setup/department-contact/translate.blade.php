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
                        <li class="breadcrumb-item"><a href="{{ route('department-contact.index') }}">{{ $data['title'] }}</a></li>
                        <li class="breadcrumb-item">{{ ___('common.edit') }}</li>

                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('department-contact.translate.update', @$data['department_contact']->id) }}" enctype="multipart/form-data" method="post"
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
                                        <input class="form-control ot-input @error('name') is-invalid @enderror" name="name[{{$language->code}}]"
                                            value="{{isset($data['translates'][$language->code][0]) ? $data['translates'][$language->code][0]->name :  @$data['department_contact']->name}}" list="datalistOptions" id="exampleDataList"
                                            placeholder="{{ ___('common.enter_name') }}">
                                        @error('name')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.phone') }}- ({{$language->name}})<span
                                                class="fillable">*</span></label>
                                        <input class="form-control ot-input @error('phone') is-invalid @enderror" name="phone[{{$language->code}}]"
                                            value="{{isset($data['translates'][$language->code][0]) ? $data['translates'][$language->code][0]->phone :  @$data['department_contact']->phone}}" list="datalistOptions" id="exampleDataList"
                                            placeholder="{{ ___('common.enter_name') }}">
                                        @error('phone')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="exampleDataList" class="form-label ">{{ ___('common.email') }}- ({{$language->name}})<span
                                                class="fillable">*</span></label>
                                        <input class="form-control ot-input @error('email') is-invalid @enderror" name="email[{{$language->code}}]"
                                            value="{{isset($data['translates'][$language->code][0]) ? $data['translates'][$language->code][0]->email :  @$data['department_contact']->email}}" list="datalistOptions" id="exampleDataList"
                                            placeholder="{{ ___('common.enter_name') }}">
                                        @error('email')
                                            <div id="validationServer04Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>department-contact
                                    department-contact
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
