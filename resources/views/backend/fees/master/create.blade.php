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
                                href="{{ route('fees-master.index') }}">{{ $data['title'] }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ ___('common.add_new') }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('fees-master.store') }}" enctype="multipart/form-data" method="post" id="visitForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('fees.fees_group') }} <span class="fillable">*</span></label>
                                    <select class="nice-select niceSelect bordered_style wide @error('fees_group_id') is-invalid @enderror"
                                    name="fees_group_id" id="validationServer04"
                                    aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('fees.select_fees_group') }}</option>
                                        @foreach ($data['fees_groups'] as $item)
                                            <option value="{{ $item->id }}" {{ old('fees_group_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('fees_group_id')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('fees.fees_type') }} <span class="fillable">*</span></label>
                                    <select id="getSubjects" class="nice-select niceSelect bordered_style wide @error('fees_type_id') is-invalid @enderror" 
                                    name="fees_type_id">
                                        <option value="">{{ ___('student_info.select_section') }}</option>
                                        @foreach ($data['fees_types'] as $item)
                                            <option value="{{ $item->id }}" {{ old('fees_type_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('fees_type_id')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('fees.due_date') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input @error('due_date') is-invalid @enderror" name="due_date"
                                        list="datalistOptions" id="exampleDataList" type="date"
                                        placeholder="{{ ___('fees.enter_due_date') }}" value="{{ old('due_date') }}">
                                    @error('due_date')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('fees.amount') }} ({{ Setting('currency_symbol') }}) <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input amount @error('amount') is-invalid @enderror" name="amount"
                                        list="datalistOptions" id="exampleDataList" type="number"
                                        placeholder="{{ ___('fees.enter_amount') }}" value="{{ old('amount') }}">
                                    @error('amount')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('fees.fine_type') }} <span class="fillable">*</span></label>
                                    <select class="fine_type nice-select niceSelect bordered_style wide @error('fine_type') is-invalid @enderror"
                                    name="fine_type" id="validationServer04"
                                    aria-describedby="validationServer04Feedback">
                                        <option {{ old('fine_type') == App\Enums\FineType::NONE ? 'selected':'' }} value="{{ App\Enums\FineType::NONE }}">{{ ___('fees.none') }}</option>
                                        <option {{ old('fine_type') == App\Enums\FineType::PERCENTAGE ? 'selected':'' }} value="{{ App\Enums\FineType::PERCENTAGE }}">{{ ___('fees.percentage') }}</option>
                                        <option {{ old('fine_type') == App\Enums\FineType::FIX_AMOUNT ? 'selected':'' }} value="{{ App\Enums\FineType::FIX_AMOUNT }}">{{ ___('fees.fix_amount') }}</option>
                                    </select>
                                    @error('fine_type')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('common.status') }} <span class="fillable">*</span></label>
                                    <select class="nice-select niceSelect bordered_style wide @error('status') is-invalid @enderror"
                                    name="status" id="validationServer04"
                                    aria-describedby="validationServer04Feedback">
                                        <option value="{{ App\Enums\Status::ACTIVE }}">{{ ___('common.active') }}</option>
                                        <option value="{{ App\Enums\Status::INACTIVE }}">{{ ___('common.inactive') }}
                                        </option>
                                    </select>
                                    @error('status')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3 percentage">
                                    <label for="exampleDataList" class="form-label ">{{ ___('fees.percentage') }} <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input percentage_input @error('percentage') is-invalid @enderror" name="percentage"
                                        list="datalistOptions" id="exampleDataList" type="number"
                                        placeholder="{{ ___('fees.enter_percentage') }}" value="{{ old('percentage') ?? 0 }}">
                                    @error('percentage')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3 fine_amount">
                                    <label for="exampleDataList" class="form-label ">{{ ___('fees.fine_amount') }} ({{ Setting('currency_symbol') }}) <span
                                            class="fillable">*</span></label>
                                    <input class="form-control ot-input fine_amount_input @error('fine_amount') is-invalid @enderror" name="fine_amount"
                                        list="datalistOptions" id="exampleDataList" type="number"
                                        placeholder="{{ ___('fees.enter_fine_amount') }}" value="{{ old('fine_amount') ?? 0 }}">
                                    @error('fine_amount')
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
