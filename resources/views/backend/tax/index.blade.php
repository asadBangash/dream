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
                    <h4 class="bradecrumb-title mb-1">{{ $data['title'] }}</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('common.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="#">{{ ___('common.settings') }}</a></li>
                            <li class="breadcrumb-item">{{ $data['title'] }}</li>
                        </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('taxes.store') }}" method="post" id="visitForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('tax.Tax Percentage')}} % </label>
                                    <input class="form-control ot-input @error('tax_percentage') is-invalid @enderror" name="tax_percentage" type="number"
                                           value="{{ Setting('tax_percentage') }}" list="datalistOptions" id="exampleDataList"
                                           placeholder="{{ ___('tax.Enter Tax Percentage') }}" min="0">
                                    @error('tax_percentage')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="validationServer04" class="form-label">{{ ___('tax.Tax Income Head') }}</label>

                                    <input class="form-control ot-input @error('tax_income_head') is-invalid @enderror" name="tax_income_head" type="text"
                                           value="{{ Setting('tax_income_head') }}" list="datalistOptions" id="exampleDataList"
                                           placeholder="{{ ___('common.Enter Head') }}">
                                </div>

                                @error('tax_income_head')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror

                                <div class="col-md-6 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('tax.Min Tax Eligible Amount') }} ({{ Setting('currency_symbol') }})</label>
                                    <input class="form-control ot-input @error('tax_min_amount') is-invalid @enderror" name="tax_min_amount" type="number"
                                           value="{{ Setting('tax_min_amount') }}" list="datalistOptions" id="exampleDataList" min="0"
                                           placeholder="{{ ___('account.enter_amount') }}">
                                    @error('tax_min_amount')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="exampleDataList" class="form-label ">{{ ___('tax.Max Tax Amount') }} ({{ Setting('currency_symbol') }})</label>
                                    <input class="form-control ot-input @error('tax_max_amount') is-invalid @enderror" name="tax_max_amount" type="number"
                                           value="{{ Setting('tax_max_amount') }}" list="datalistOptions" id="exampleDataList" min="0"
                                           placeholder="{{ ___('account.enter_amount') }}">
                                    @error('tax_max_amount')
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
            </form>
            </div>
        </div>
    </div>
@endsection
