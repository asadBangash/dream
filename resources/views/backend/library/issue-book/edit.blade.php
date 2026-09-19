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
                        <li class="breadcrumb-item"><a href="{{ route('issue-book.index') }}">{{ $data['title'] }}</a></li>
                        <li class="breadcrumb-item">{{ ___('common.edit') }}</li>

                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('issue-book.update', @$data['issue_book']->id) }}" enctype="multipart/form-data" method="post"
                    id="issue_book">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">
                                
                                <div class="col-md-6 book mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('library.select_book') }}
                                        <span class="fillable">*</span></label>
                                    <select
                                        class="book nice-select niceSelect bordered_style wide @error('book') is-invalid @enderror"
                                        name="book" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('library.select_book') }}</option>
                                        <option selected value="{{ @$data['issue_book']->book_id }}">{{ $data['book'] }}</option>
                                    </select>
                                    @error('book')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 member mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('library.select_member') }}
                                        <span class="fillable">*</span></label>
                                    <select
                                        class="member nice-select niceSelect bordered_style wide @error('member') is-invalid @enderror"
                                        name="member" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('library.select_member') }}</option>
                                        <option selected value="{{ @$data['issue_book']->user_id }}">{{ $data['user'] }}</option>
                                    </select>
                                    @error('member')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('library.issue_date') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('issue_date') is-invalid @enderror" name="issue_date" type="date"
                                        value="{{ old('issue_date',@$data['issue_book']->issue_date) }}" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('library.enter_issue_date') }}">
                                    @error('issue_date')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('library.return_date') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('return_date') is-invalid @enderror" name="return_date" type="date"
                                        value="{{ old('return_date',@$data['issue_book']->return_date) }}" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('library.enter_return_date') }}">
                                    @error('return_date')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('common.phone') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ old('phone',@$data['issue_book']->phone) }}" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('library.enter_phone_no') }}">
                                    @error('phone')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label for="exampleDataList" class="form-label">{{ ___('library.description') }}</label>
                                    <textarea class="form-control" name="description" id="exampleDataList">{{ old('description',@$data['issue_book']->description) }}</textarea>
                                </div>
                                
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
