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
                        <li class="breadcrumb-item"><a href="{{ route('book.index') }}">{{ $data['title'] }}</a></li>
                        <li class="breadcrumb-item">{{ ___('common.edit') }}</li>

                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('book.update', @$data['book']->id) }}" enctype="multipart/form-data" method="post"
                    id="visitForm">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="validationServer04" class="form-label">{{ ___('settings.book_category') }} <span
                                        class="fillable">*</span></label>
                                    <select class="nice-select niceSelect bordered_style wide @error('category') is-invalid @enderror"
                                    name="category" id="validationServer04"
                                    aria-describedby="validationServer04Feedback">
                                    <option value="">{{ ___('library.select_category') }}</option>
                                        @foreach ($data['categories'] as $item)
                                            <option {{ @$data['book']->category_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}" {{ old('category') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('common.name') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name',@$data['book']->name) }}" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('common.enter_name') }}">
                                    @error('name')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('library.code') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('code') is-invalid @enderror" name="code"
                                        value="{{ old('code',@$data['book']->code) }}" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('library.enter_code') }}">
                                    @error('code')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('library.publisher_name') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('publisher_name') is-invalid @enderror" name="publisher_name"
                                        value="{{ old('publisher_name',@$data['book']->publisher_name) }}" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('library.enter_publisher_name') }}">
                                    @error('publisher_name')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('library.author_name') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('author_name') is-invalid @enderror" name="author_name"
                                        value="{{ old('author_name',@$data['book']->author_name) }}" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('library.enter_author_name') }}">
                                    @error('author_name')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('library.rack_no') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('rack_no') is-invalid @enderror" name="rack_no"
                                        value="{{ old('rack_no',@$data['book']->rack_no) }}" list="datalistOptions" id="exampleDataList" type="number"
                                        placeholder="{{ ___('library.enter_rack_no') }}">
                                    @error('rack_no')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('library.price') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('price') is-invalid @enderror" name="price" type="number"
                                        value="{{ old('price',@$data['book']->price) }}" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('library.enter_price') }}">
                                    @error('price')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('library.quantity') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('quantity') is-invalid @enderror" name="quantity" type="number"
                                        value="{{ old('quantity',@$data['book']->quantity) }}" list="datalistOptions" id="exampleDataList"
                                        placeholder="{{ ___('library.enter_quantity') }}">
                                    @error('quantity')
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
                                        <option value="{{ App\Enums\Status::ACTIVE }}"
                                            {{ @$data['book']->status == App\Enums\Status::ACTIVE ? 'selected' : '' }}>
                                            {{ ___('common.active') }}</option>
                                        <option value="{{ App\Enums\Status::INACTIVE }}"
                                            {{ @$data['book']->status == App\Enums\Status::INACTIVE ? 'selected' : '' }}>
                                            {{ ___('common.inactive') }}
                                        </option>
                                    </select>
                                    @error('status')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="exampleDataList" class="form-label">{{ ___('library.description') }}</label>
                                    <textarea class="form-control" name="description" id="exampleDataList">{{ old('description',@$data['book']->description) }}</textarea>
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
