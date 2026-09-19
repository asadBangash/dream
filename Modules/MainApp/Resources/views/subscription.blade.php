@extends('mainapp::layouts.frontend.master')

@section('content')

<!-- BREADCRUMB_AREA::START  -->
<div class="breadcrumb_area bradcam_bg_1">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcam_wrap text-center">
                    <h3>{{ ___('common.School Subscription') }}</h3>
                    <span> <a href="/">{{ ___('common.Home') }}</a> / {{ ___('common.Subscription') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- BREADCRUMB_AREA::END  -->

<!-- subscription_form::start  -->
<div class="subscription_form_area section_padding ">
    <div class="container">
        <div class="row">
            <div class="col-xl-8">
                <div class="subscription_form mb_30">
                    <h3 class="title_1">{{ ___('common.School Details') }}</h3>
                    <form action="{{ route('purchase-subscription.store') }}" id="subscription" method="post">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="package_id" value="{{ $data['package']->id }}">
                            <input type="hidden" name="package_amount" value="{{ $data['package']->price + @$data['previousDue'] }}">
                            <input type="hidden" name="package_name" value="{{ $data['package']->name }}">
                            <input type="hidden" name="package_duration" value="{{ $data['package']->duration }}">
                            <input type="hidden" name="package_duration_number" value="{{ $data['package']->duration_number }}">
                            <input type="hidden" name="sub_domain_key" value="{{ $data['subdomain_name'] }}">
                            <input type="hidden" name="payment_type" value="{{ $data['package']->payment_type }}">
                            <input type="hidden" name="previous_due" value="{{ @$data['previousDue'] }}">

                            @if($data['subdomain_name'])
                                <input type="hidden" name="name" value="{{ $data['school_info']->name }}">
                                <input type="hidden" name="sub_domain_key" value="{{ $data['school_info']->sub_domain_key }}">
                                <input type="hidden" name="email" value="{{ $data['school_info']->email }}">
                                <input type="hidden" name="phone" value="{{ $data['school_info']->phone }}">
                                <input type="hidden" name="address" value="{{ $data['school_info']->address }}">
                            @endif

                            <div class="col-xl-12 mb_15">
                                <div class="single_select">
                                    <label class="primary_label2">{{ ___('common.Name') }}</label>
                                    <input name="name" placeholder="{{ ___('common.Type Name') }}" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ ___('common.Type Name') }}'" class="primary_input" required type="text" value="{{ old('name', @$data['school_info']->name) }}" {{ @$data['school_info'] ? 'disabled' : '' }}>
                                </div>
                                @if ($errors->has('name'))
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                @endif
                            </div>
                            <div class="col-xl-12 mb_15">
                                <div class="single_select">
                                    <label class="primary_label2">{{ ___('common.Sub domain key') }}</label>
                                    <input id="sub_domain_key" name="sub_domain_key" placeholder="{{ ___('common.Enter sub domain key (0-9a-z)') }}" class="primary_input" required type="text" value="{{ old('sub_domain_key', @$data['school_info']->sub_domain_key) }}" {{ @$data['school_info'] ? 'disabled' : '' }}>
                                </div>
                                @if ($errors->has('sub_domain_key'))
                                    <small class="text-danger">{{ $errors->first('sub_domain_key') }}</small>
                                @endif
                            </div>
                            <div class="col-xl-6 mb_15">
                                <div class="single_select">
                                    <label class="primary_label2">{{ ___('common.Email Address') }}</label>
                                    <input name="email" placeholder="{{ ___('common.Type e-mail address') }}" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ ___('common.Type e-mail address') }}'" class="primary_input" required type="email" value="{{ old('email', @$data['school_info']->email) }}" {{ @$data['school_info'] ? 'disabled' : '' }}>
                                </div>
                                @if ($errors->has('email'))
                                    <small class="text-danger">{{ $errors->first('email') }}</small>
                                @endif
                            </div>
                            <div class="col-xl-6 mb_15">
                                <div class="single_select">
                                    <label class="primary_label2">{{ ___('common.Phone') }}</label>
                                    <input name="phone" placeholder="{{ ___('common.Type phone number') }}" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ ___('common.Type phone number') }}'" class="primary_input" required value="{{ old('phone', @$data['school_info']->phone) }}" {{ @$data['school_info'] ? 'disabled' : '' }}>
                                </div>
                                @if ($errors->has('phone'))
                                    <small class="text-danger">{{ $errors->first('phone') }}</small>
                                @endif
                            </div>
                            <div class="col-xl-12 mb_30">
                                <div class="single_select">
                                    <label class="primary_label2">{{ ___('common.Address') }}</label>
                                    <input name="address" placeholder="{{ ___('common.Type Address') }}" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ ___('common.Type Address') }}'" class="primary_input" required type="text" value="{{ old('address', @$data['school_info']->address) }}"  {{ @$data['school_info'] ? 'disabled' : '' }}>
                                </div>
                                @if ($errors->has('address'))
                                    <small class="text-danger">{{ $errors->first('address') }}</small>
                                @endif
                            </div>

                            @if ($data['package']->payment_type == \Modules\MainApp\Enums\PackagePaymentType::PREPAID || @$data['previousDue'] > 0)
                                <div class="col-12">
                                    <h4 class="title_2">{{ ___('common.Payment Method') }}</h4>
                                    <div class="paypal_payment_wrapper mb_24">
                                        <p>{{ ___('common.You will be redirected to the PayPal website after submitting your order') }}</p>
                                        <div class="">
                                            <label class="primary_bulet_checkbox d-flex align-items-center gap_12">
                                                <input class="radio-input" type="radio" name="payment_method" value="Paypal">
                                                <span class="checkmark mr_0"></span>
                                                <span class="label_name">{{ ___('common.PayPal') }}</span>
                                                <div class="paypal_icon">
                                                    <img src="{{ asset('saas-frontend') }}/img/svg/PayPal.svg" alt="#">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="pay_with_card mb_24">
                                        <div class="">
                                            <label class="primary_bulet_checkbox d-flex mb_30 align-items-start gap_12 flex-wrap align-items-center">
                                                <input class="radio-input" type="radio" name="payment_method" value="Stripe" checked>
                                                <span class="checkmark m-0"></span>
                                                <span class="label_name d-block">{{ ___('common.Pay with Credit Card') }}</span>
                                                <div class="card_icon">
                                                    <img src="{{ asset('saas-frontend') }}/img/svg/card_imgs.png" alt="#">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-3" id="stripeOption">
                                    <input type='hidden' name='stripeToken' id='stripe-token-id'>

                                    <div id="card-element" class="form-control" ></div>
                                </div>
                            @endif
                            <div class="col-12 d-flex gap_12 flex">
                                @php
                                    $button = session()->has('subdomainForPackageUpgrade') ? ___('ui_element.upgrade') : ___('ui_element.confirm');
                                @endphp
                                @if ($data['package']->payment_type == \Modules\MainApp\Enums\PackagePaymentType::PREPAID || @$data['previousDue'] > 0)
                                    <button type="button" onclick="createToken()" class="theme_btn_blue small_btn8" id='stripe-pay-btn'>
                                        {{ $button }}
                                    </button>
                                    <button type="submit" class="theme_btn_blue small_btn8 d-none" id='paypal-pay-btn'>
                                        {{ $button }}
                                    </button>
                                @else
                                    <button type="submit" class="theme_btn_blue small_btn8">
                                        {{ $button }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="subscription_sidebar mb_30">
                    <div class="subscription_sidebar_header d-flex justify-content-between align-items-center flex-wrap">
                        <h3>{{ $data['package']->name }}</h3>
                        @if ($data['package']->popular == 1)
                            <span class="purchase_badge">{{ ___('common.Most Popular') }}</span>
                        @endif
                        <h2>${{ $data['package']->price }} /

                            @if ($data['package']->duration == \App\Enums\PricingDuration::DAYS)
                                <span>{{ $data['package']->duration_number }} {{ ___('common.days') }}</span>
                            @elseif ($data['package']->duration == \App\Enums\PricingDuration::MONTHLY)
                                <span>{{ $data['package']->duration_number }} {{ ___('common.monthly') }}</span>
                            @elseif ($data['package']->duration == \App\Enums\PricingDuration::YEARLY)
                                <span>{{ $data['package']->duration_number }} {{ ___('common.yearly') }}</span>
                            @else
                                <span>{{ ___('common.lifetime') }}</span>
                            @endif

                        </h2>
                    </div>
                    <div class="subscription_sidebar_body">
                        <ul>
                            <li>
                                <span>{{ ___('common.Plan Name') }}</span>
                                <span>{{ $data['package']->name }}</span>
                            </li>
                            <li>
                                <span>{{ ___('common.Start Date') }}</span>
                                <span>{{ date('d M Y') }}</span>
                            </li>
                            <li>
                                <span>{{ ___('common.End Date') }}</span>
                                @if ($data['package']->duration == \App\Enums\PricingDuration::DAYS)
                                    <span>{{ date("d M Y", strtotime("+ ". $data['package']->duration_number ." day")); }}</span>
                                @elseif ($data['package']->duration == \App\Enums\PricingDuration::MONTHLY)
                                    <span>{{ date("d M Y", strtotime("+ ". $data['package']->duration_number ." month")); }}</span>
                                @elseif ($data['package']->duration == \App\Enums\PricingDuration::YEARLY)
                                    <span>{{ date("d M Y", strtotime("+ ". $data['package']->duration_number ." year")); }}</span>
                                @else
                                    <span>{{ ___('common.Lifetime') }}</span>
                                @endif
                            </li>
                            <li>
                                <span>{{ ___('common.Price') }}</span>
                                <span>${{ $data['package']->price }}</span>
                            </li>
                            @if (@$data['previousDue'] > 0)
                                <li>
                                    <span>{{ ___('common.Previous Due') }}</span>
                                    <span>${{ number_format(@$data['previousDue'], 2, '.', '') }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="subscription_sidebar_bottom">
                        <span>{{ ___('common.Total Subscription Cost') }}</span>
                        <span>${{ number_format($data['package']->price + @$data['previousDue'], 2, '.', '') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- subscription_form::end  -->

