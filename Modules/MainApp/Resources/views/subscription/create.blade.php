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
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"> {{ ___('mainapp_common.home') }} </a></li>
                        <li class="breadcrumb-item"><a href="{{ route('subscription.index') }}">{{ ___('mainapp_subscriptions.subscriptions') }}</a></li>
                        <li class="breadcrumb-item">{{ $data['title'] }}</li>

                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}
        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('subscription.store') }}" enctype="multipart/form-data" method="post"
                    id="visitForm">
                    @csrf
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label for="validationServer04" class="form-label">{{ ___('mainapp_schools.School') }} <span class="fillable">*</span></label>
                            <select class="nice-select niceSelect bordered_style wide @error('package') is-invalid @enderror"
                            name="school" id="validationServer04"
                            aria-describedby="validationServer04Feedback">
                                <option value="">{{ ___('mainapp_schools.Select School') }}</option>
                                @foreach ($data['schools'] as $item)
                                    <option {{ old('package') == $item->id ? 'selected':'' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>

                            @error('package')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="validationServer04" class="form-label">{{ ___('mainapp_subscriptions.Package') }} <span class="fillable">*</span></label>
                            <select class="nice-select niceSelect bordered_style wide @error('package') is-invalid @enderror"
                            name="package" id="validationServer04"
                            aria-describedby="validationServer04Feedback">
                                <option value="">{{ ___('mainapp_subscriptions.Select package') }}</option>
                                @foreach ($data['packages'] as $item)
                                    <option {{ old('package', @$data['subscription']->package_id) == $item->id ? 'selected':'' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>

                            @error('package')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="exampleDataList" class="form-label">{{ ___('mainapp_subscriptions.Transaction NO') }} <span
                                    class="fillable"></span></label>
                            <input class="form-control ot-input @error('transaction_no') is-invalid @enderror" name="transaction_no" type="number"
                                list="datalistOptions" id="exampleDataList"
                                placeholder="{{ ___('mainapp_subscriptions.Enter Transaction NO') }}" value="{{ old('transaction_no') }}">
                            @error('transaction_no')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="validationServer04" class="form-label">{{ ___('mainapp_subscriptions.Payment method') }} <span class="fillable">*</span></label>
                            <select class="nice-select niceSelect bordered_style wide @error('payment_method') is-invalid @enderror"
                            name="payment_method" id="validationServer04"
                            aria-describedby="validationServer04Feedback">
                                <option value="">{{ ___('mainapp_subscriptions.Select payment method') }}</option>
                                <option value="cash">{{ ___('mainapp_subscriptions.Cash') }}</option>
                                <option value="bank">{{ ___('mainapp_subscriptions.Bank') }}</option>

                            </select>

                            @error('package')
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
