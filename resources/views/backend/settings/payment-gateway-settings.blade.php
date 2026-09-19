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
                        <li class="breadcrumb-item">{{ $data['title'] }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-header">
                <h4>{{ ___('common.payment_gateway_settings') }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('settings.payment-gateway-setting.update') }}" enctype="multipart/form-data" method="post" id="visitForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="row">
                                {{-- Payment Gateway start --}}
                                <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3">
                                    <label for="validationServer04" class="form-label">{{ ___('settings.payment_gateway') }} <span class="fillable">*</span></label>
                                    <select onchange="selectPaymentGateway(this)" class="nice-select niceSelect bordered_style wide" name="payment_gateway" id="validationServer04" aria-describedby="validationServer04Feedback">
                                        <option value="Stripe" selected> {{ ___('common.Stripe') }}</option>
                                        <option value="PayPal"> {{ ___('common.PayPal') }}</option>
                                    </select>
                                </div>
                                @error('payment_gateway')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                {{-- Payment Gateway end --}}

                                {{-- PayPal Payment Mode start --}}
                                <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3 d-none" id="paypalPaymentMode">
                                    <label for="validationServer04" class="form-label">{{ ___('settings.paypal_payment_mode') }} <span class="fillable">*</span></label>
                                    <select onchange="togglePayPalOption(this)" class="nice-select niceSelect bordered_style wide payment-mode" name="paypal_payment_mode" id="validationServer04" aria-describedby="validationServer04Feedback">
                                        <option value="Sandbox" {{ Setting('paypal_payment_mode') == 'Sandbox' ? 'selected' : '' }}> {{ ___('common.Sandbox') }}</option>
                                        <option value="Live" {{ Setting('paypal_payment_mode') == 'Live' ? 'selected' : '' }}> {{ ___('common.Live') }}</option>
                                    </select>
                                </div>
                                @error('paypal_payment_mode')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                {{-- PayPal Payment Mode end --}}
                            </div>
                            <div class="row" id="stripeOption">
                                {{-- Stripe KEY start --}}
                                <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3">
                                    <label for="inputname" class="form-label">{{ ___('settings.stripe_key') }}
                                        <span class="fillable">*</span></label>
                                    <input type="text" name="stripe_key" class="form-control ot-input @error('stripe_key') is-invalid @enderror" value="{{ config('app.APP_DEMO') ? '': Setting('stripe_key') }}" placeholder="{{ ___('settings.stripe_key') }}">
                                    @error('stripe_key')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- Stripe KEY end --}}

                                {{-- Stripe SECRET start --}}
                                <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3">
                                    <label for="inputname" class="form-label">{{ ___('settings.stripe_secret') }}
                                        <span class="fillable">*</span></label>
                                    <input type="text" name="stripe_secret" class="form-control ot-input @error('stripe_secret') is-invalid @enderror" value="{{ config('app.APP_DEMO') ? '': Setting('stripe_secret') }}" placeholder="{{ ___('settings.stripe_secret') }}">
                                    @error('stripe_secret')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- Stripe SECRET end --}}
                            </div>


                            <div class="row d-none" id="paypalSandboxOption">
                                {{-- PAYPAL SANDBOX API USERNAME start --}}
                                <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3">
                                    <label for="inputname" class="form-label">
                                        {{ ___('settings.paypal_api_username') }}
                                        <span class="fillable">*</span></label>
                                    <input type="text" name="paypal_sandbox_api_username" class="form-control ot-input @error('paypal_sandbox_api_username') is-invalid @enderror" value="{{ config('app.APP_DEMO') ? '': Setting('paypal_sandbox_api_username') }}" placeholder="{{ ___('settings.paypal_sandbox_api_username') }}">
                                    @error('paypal_sandbox_api_username')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- PAYPAL SANDBOX API USERNAME end --}}

                                {{-- PAYPAL SANDBOX API PASSWORD start --}}
                                <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3">
                                    <label for="inputname" class="form-label">
                                        {{ ___('settings.paypal_api_password') }}
                                        <span class="fillable">*</span></label>
                                    <input type="text" name="paypal_sandbox_api_password" class="form-control ot-input @error('paypal_sandbox_api_password') is-invalid @enderror" value="{{ config('app.APP_DEMO') ? '': Setting('paypal_sandbox_api_password') }}" placeholder="{{ ___('settings.paypal_sandbox_api_password') }}">
                                    @error('paypal_sandbox_api_password')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- PAYPAL SANDBOX API PASSWORD end --}}

                                {{-- PAYPAL SANDBOX API SECRET start --}}
                                <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3">
                                    <label for="inputname" class="form-label">
                                        {{ ___('settings.paypal_api_secret') }}
                                        <span class="fillable">*</span></label>
                                    <input type="text" name="paypal_sandbox_api_secret" class="form-control ot-input @error('paypal_sandbox_api_secret') is-invalid @enderror" value="{{ config('app.APP_DEMO') ? '': Setting('paypal_sandbox_api_secret') }}" placeholder="{{ ___('settings.paypal_sandbox_api_secret') }}">
                                    @error('paypal_sandbox_api_secret')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- PAYPAL SANDBOX API SECRET end --}}

                                {{-- PAYPAL SANDBOX API CERTIFICATE start --}}
                                <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3">
                                    <label for="inputname" class="form-label"> {{ ___('settings.paypal_api_certificate') }}</label>
                                    <input type="text" name="paypal_sandbox_api_certificate" class="form-control ot-input @error('paypal_sandbox_api_certificate') is-invalid @enderror" value="{{ config('app.APP_DEMO') ? '': Setting('paypal_sandbox_api_certificate') }}" placeholder="{{ ___('settings.paypal_sandbox_api_certificate') }}">
                                    @error('paypal_sandbox_api_certificate')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- PAYPAL SANDBOX API CERTIFICATE end --}}
                            </div>


                            <div class="row d-none" id="paypalLiveOption">
                                {{-- PAYPAL LIVE API USERNAME start --}}
                                <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3">
                                    <label for="inputname" class="form-label">
                                        {{ ___('settings.paypal_api_username') }}
                                        <span class="fillable">*</span></label>
                                    <input type="text" name="paypal_live_api_username" class="form-control ot-input @error('paypal_live_api_username') is-invalid @enderror" value="{{ config('app.APP_DEMO') ? '': Setting('paypal_live_api_username') }}" placeholder="{{ ___('settings.paypal_live_api_username') }}">
                                    @error('paypal_live_api_username')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- PAYPAL LIVE API USERNAME end --}}

                                {{-- PAYPAL LIVE API PASSWORD start --}}
                                <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3">
                                    <label for="inputname" class="form-label">
                                        {{ ___('settings.paypal_api_password') }}
                                        <span class="fillable">*</span></label>
                                    <input type="text" name="paypal_live_api_password" class="form-control ot-input @error('paypal_live_api_password') is-invalid @enderror" value="{{ Setting('paypal_live_api_password') }}" placeholder="{{ ___('settings.paypal_live_api_password') }}">
                                    @error('paypal_live_api_password')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- PAYPAL LIVE API PASSWORD end --}}

                                {{-- PAYPAL LIVE API SECRET start --}}
                                <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3">
                                    <label for="inputname" class="form-label">
                                        {{ ___('settings.paypal_api_secret') }}
                                        <span class="fillable">*</span></label>
                                    <input type="text" name="paypal_live_api_secret" class="form-control ot-input @error('paypal_live_api_secret') is-invalid @enderror" value="{{ Setting('paypal_live_api_secret') }}" placeholder="{{ ___('settings.paypal_live_api_secret') }}">
                                    @error('paypal_live_api_secret')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- PAYPAL LIVE API SECRET end --}}

                                {{-- PAYPAL LIVE API CERTIFICATE start --}}
                                <div class="col-12 col-md-6 col-xl-6 col-lg-6 mb-3">
                                    <label for="inputname" class="form-label">{{ ___('settings.paypal_api_certificate') }}</label>
                                    <input type="text" name="paypal_live_api_certificate" class="form-control ot-input @error('paypal_live_api_certificate') is-invalid @enderror" value="{{ Setting('paypal_live_api_certificate') }}" placeholder="{{ ___('settings.paypal_live_api_certificate') }}">
                                    @error('paypal_live_api_certificate')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- PAYPAL LIVE API CERTIFICATE end --}}
                            </div>

                            <div class="col-md-12 mt-3">
                                <div class="text-end">
                                    @if (hasPermission('payment_gateway_settings_update'))
                                        <button class="btn btn-lg ot-btn-primary">
                                            <span>
                                                <i class="fa-solid fa-save"></i>
                                            </span>{{ ___('common.update') }}
                                        </button>
                                    @endif
                                </div>
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
        const selectPaymentGateway = (obj) => {
            let paymentGateway = $(obj).val();

            if (paymentGateway == 'Stripe') {
                $('#paypalPaymentMode').addClass('d-none');
                $('#paypalSandboxOption').addClass('d-none');
                $('#paypalLiveOption').addClass('d-none');
                $('#stripeOption').removeClass('d-none');
            } else {
                $('#paypalPaymentMode').removeClass('d-none');
                $('#stripeOption').addClass('d-none');
                togglePayPalOption($('.payment-mode'));
            }
        }

        const togglePayPalOption = (obj) => {
            let paymentMode = $(obj).val();

            if (paymentMode == 'Sandbox') {
                $('#paypalSandboxOption').removeClass('d-none');
                $('#paypalLiveOption').addClass('d-none');
            } else {
                $('#paypalSandboxOption').addClass('d-none');
                $('#paypalLiveOption').removeClass('d-none');
            }
        }
    </script>
@endpush
