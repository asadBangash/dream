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
                <form action="{{ route('subscription.approved', @$data['subscription']->id) }}" enctype="multipart/form-data" method="post"
                    id="visitForm">
                    @csrf
                    @method('PUT')
                    <div class="row">


                        <div class="col-md-6 mb-3">
                            <label for="validationServer04" class="form-label">{{ ___('mainapp_subscriptions.Package') }} <span class="fillable">*</span></label>
                            <select class="nice-select niceSelect bordered_style wide @error('package') is-invalid @enderror"
                            name="package" id="validationServer04"
                            aria-describedby="validationServer04Feedback" @disabled(true)>
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
                            <label for="validationServer04" class="form-label">{{ ___('mainapp_common.Status') }} <span class="fillable">*</span></label>
                            <select class="nice-select niceSelect bordered_style wide @error('status') is-invalid @enderror"
                            name="status" id="validationServer04"
                            aria-describedby="validationServer04Feedback">
                                @if (@$data['subscription']->status != \App\Enums\SubscriptionStatus::APPROVED)
                                    <option {{ @$data['subscription']->status == \App\Enums\SubscriptionStatus::APPROVED ? 'selected':'' }} value="{{ \App\Enums\SubscriptionStatus::APPROVED }}">{{ ___('mainapp_common.Approved') }}</option>
                                @endif
                                @if (@$data['subscription']->status != \App\Enums\SubscriptionStatus::REJECT)
                                    <option {{ @$data['subscription']->status == \App\Enums\SubscriptionStatus::REJECT ? 'selected':'' }} value="{{ \App\Enums\SubscriptionStatus::REJECT }}">{{ ___('mainapp_common.Reject') }}</option>
                                @endif
                            </select>

                            @error('status')
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
