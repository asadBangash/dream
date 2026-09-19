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
                        <li class="breadcrumb-item" aria-current="page"><a
                                href="{{ route('gmeet.index') }}">{{ ___('common.gmeet') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $data['title'] }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}
        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('gmeet.update', [$data['gmeet']->id]) }}" enctype="multipart/form-data" method="post" id="markRegister">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">

                                <div class="col-md-4 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('common.title') }} <span
                                        class="fillable">*</span> </label>
                                    <input class="form-control ot-input @error('title') is-invalid @enderror" name="title"
                                        value="{{ old('title', $data['gmeet']->title) }}" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('account.enter_title') }}">
                                    @error('title')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('online-examination.Start') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('start') is-invalid @enderror" name="start" type="datetime-local"
                                        list="datalistOptions" id="exampleDataList" type="text"
                                        placeholder="{{ ___('online-examination.Enter start') }}" value="{{ old('start', $data['gmeet']->start) }}">
                                    @error('start')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('online-examination.End') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('end') is-invalid @enderror" name="end" type="datetime-local"
                                        list="datalistOptions" id="exampleDataList" type="text"
                                        placeholder="{{ ___('online-examination.Enter end') }}" value="{{ old('end', $data['gmeet']->end) }}">
                                    @error('end')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('student_info.class') }} <span
                                        class="fillable"></span></label>
                                    <select id="getSections"
                                        class="nice-select niceSelect bordered_style wide class @error('class') is-invalid @enderror"
                                        name="class" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_class') }}</option>
                                        @foreach ($data['classes'] as $item)
                                            <option {{ old('class', $data['gmeet']->classes_id) == $item->id ? 'selected' : '' }}
                                                value="{{ $item->class->id }}">{{ $item->class->name }}
                                        @endforeach
                                        </option>
                                    </select>

                                    @error('class')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('student_info.section') }} <span
                                        class="fillable"></span></label>
                                    <select id="getSubjects"
                                        class="nice-select niceSelect sections bordered_style wide section @error('section') is-invalid @enderror"
                                        name="section" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_section') }}</option>
                                        @foreach ($data['sections'] as $item)
                                        <option {{ old('section', $data['gmeet']->sections_id) == $item->sections_id ? 'selected' : '' }}
                                            value="{{ $item->section->id }}">{{ $item->section->name }}
                                    @endforeach
                                    </select>

                                    @error('section')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                               
                                <div class="col-md-4 mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('academic.subject') }} <span
                                        class="fillable"></span></label>
                                    <select id="subject"
                                        class="nice-select niceSelect subjects bordered_style wide @error('subject') is-invalid @enderror"
                                        name="subject" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('examination.select_subject') }}</option>
                                        @foreach ($data['subjects'] as $item)
                                            <option {{ old('subject', $data['gmeet']->subject_id) == $item->subject_id ? 'selected' : '' }}
                                                value="{{ $item->subject->id }}">{{ $item->subject->name }}
                                        @endforeach
                                    </select>

                                    @error('subject')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                               
                                <div class="col-md-4 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('common.gmeet_link') }} </label>
                                    <input class="form-control ot-input @error('gmeet_link') is-invalid @enderror" name="gmeet_link"
                                        value="{{ old('gmeet_link', $data['gmeet']->gmeet_link) }}" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('common.gmeet_link') }}">
                                    @error('gmeet_link')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">

                                    <label for="validationServer04" class="form-label">{{ ___('common.status') }} <span class="fillable">*</span></label>
                                    <select class="nice-select niceSelect bordered_style wide @error('status') is-invalid @enderror"
                                    name="status" id="validationServer04"
                                    aria-describedby="validationServer04Feedback">
                                        <option value="{{ App\Enums\GmeetStatus::PENDING }}" {{$data['gmeet']->status == App\Enums\GmeetStatus::PENDING ? 'selected':''}}>{{ ___('common.pending') }}</option>
                                        <option value="{{ App\Enums\GmeetStatus::CANCEL }}" {{$data['gmeet']->status == App\Enums\GmeetStatus::CANCEL ? 'selected':''}}>{{ ___('common.cancel') }}</option>
                                        <option value="{{ App\Enums\GmeetStatus::START }}" {{$data['gmeet']->status == App\Enums\GmeetStatus::START ? 'selected':''}}>{{ ___('common.start') }}</option>
                                        <option value="{{ App\Enums\GmeetStatus::FINISHED }}" {{$data['gmeet']->status == App\Enums\GmeetStatus::FINISHED ? 'selected':''}}>{{ ___('common.finished') }}</option>
                                        </option>
                                    </select>

                                    @error('status')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('account.description') }}</label>
                                    <textarea class="form-control ot-textarea @error('description') is-invalid @enderror" name="description"
                                    list="datalistOptions" id="exampleDataList"
                                    placeholder="{{ ___('account.enter_description') }}">{{ old('description', $data['gmeet']->description) }}</textarea>
                                    @error('description')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mt-24">
                                    <div class="text-end">
                                        <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                            </span>{{ ___('common.submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
