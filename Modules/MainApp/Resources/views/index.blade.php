@extends('mainapp::layouts.frontend.master')

@section('content')
    <!-- BANNER::START  -->
    <div id="Home" class="banner_area ">
        <div class="banner_item" data-background="{{ @globalAsset(@$sections['banner']->upload->path, '1920X700.webp') }}">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-6">
                        <div class="banner_text ">
                            <h3>{{ @$sections['banner']->name }}</h3>
                            <p>{{ @$sections['banner']->description }}</p>
                            <div class="d-flex flex-wrap gap_20">
                                <a href="#" class="theme_gradient_btn"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M20.2953 17.3921L13.0233 20.4551V11.8991L20.2953 8.83614V17.3921ZM12.1133 10.3081L5.36728 7.46714L12.1133 4.62914L18.8603 7.46714L12.1133 10.3081ZM11.2043 20.4551L3.93228 17.3921V8.83614L11.2043 11.8991V20.4551ZM22.0773 7.22114C22.0693 7.19514 22.0573 7.17014 22.0473 7.14514C22.0283 7.09414 22.0063 7.04414 21.9783 6.99714C21.9623 6.97114 21.9433 6.94714 21.9243 6.92214C21.8933 6.88114 21.8603 6.84414 21.8223 6.80814C21.7993 6.78714 21.7753 6.76514 21.7503 6.74614C21.7343 6.73514 21.7233 6.72014 21.7073 6.70914C21.6773 6.69014 21.6443 6.67814 21.6123 6.66314C21.5933 6.65314 21.5773 6.63714 21.5573 6.62814L12.4663 2.80514C12.2403 2.71014 11.9863 2.71014 11.7613 2.80514L2.67028 6.62814C2.65028 6.63714 2.63528 6.65214 2.61628 6.66214C2.58428 6.67814 2.55028 6.68914 2.52028 6.70914C2.50328 6.72014 2.49228 6.73514 2.47728 6.74614C2.45128 6.76514 2.42828 6.78714 2.40528 6.80814C2.36728 6.84314 2.33428 6.88114 2.30228 6.92214C2.28428 6.94714 2.26528 6.97114 2.24928 6.99714C2.22128 7.04514 2.19928 7.09414 2.17928 7.14614C2.17028 7.17114 2.15728 7.19514 2.15028 7.22114C2.12828 7.30014 2.11328 7.38214 2.11328 7.46614V17.9961C2.11328 18.3621 2.33328 18.6921 2.67028 18.8331L11.7603 22.6631C11.7733 22.6681 11.7873 22.6661 11.7993 22.6701C11.9013 22.7081 12.0063 22.7341 12.1133 22.7341C12.2213 22.7341 12.3263 22.7081 12.4273 22.6701C12.4403 22.6661 12.4543 22.6681 12.4663 22.6631L21.5573 18.8331C21.8943 18.6921 22.1133 18.3621 22.1133 17.9961V7.46614C22.1133 7.38214 22.0993 7.30014 22.0773 7.22114Z" fill="white" />
                                    </svg> Try Live Demo</a>
                                <a href="#" class="theme_gradient_line_btn"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M20.2953 17.3921L13.0233 20.4551V11.8991L20.2953 8.83614V17.3921ZM12.1133 10.3081L5.36728 7.46714L12.1133 4.62914L18.8603 7.46714L12.1133 10.3081ZM11.2043 20.4551L3.93228 17.3921V8.83614L11.2043 11.8991V20.4551ZM22.0773 7.22114C22.0693 7.19514 22.0573 7.17014 22.0473 7.14514C22.0283 7.09414 22.0063 7.04414 21.9783 6.99714C21.9623 6.97114 21.9433 6.94714 21.9243 6.92214C21.8933 6.88114 21.8603 6.84414 21.8223 6.80814C21.7993 6.78714 21.7753 6.76514 21.7503 6.74614C21.7343 6.73514 21.7233 6.72014 21.7073 6.70914C21.6773 6.69014 21.6443 6.67814 21.6123 6.66314C21.5933 6.65314 21.5773 6.63714 21.5573 6.62814L12.4663 2.80514C12.2403 2.71014 11.9863 2.71014 11.7613 2.80514L2.67028 6.62814C2.65028 6.63714 2.63528 6.65214 2.61628 6.66214C2.58428 6.67814 2.55028 6.68914 2.52028 6.70914C2.50328 6.72014 2.49228 6.73514 2.47728 6.74614C2.45128 6.76514 2.42828 6.78714 2.40528 6.80814C2.36728 6.84314 2.33428 6.88114 2.30228 6.92214C2.28428 6.94714 2.26528 6.97114 2.24928 6.99714C2.22128 7.04514 2.19928 7.09414 2.17928 7.14614C2.17028 7.17114 2.15728 7.19514 2.15028 7.22114C2.12828 7.30014 2.11328 7.38214 2.11328 7.46614V17.9961C2.11328 18.3621 2.33328 18.6921 2.67028 18.8331L11.7603 22.6631C11.7733 22.6681 11.7873 22.6661 11.7993 22.6701C11.9013 22.7081 12.0063 22.7341 12.1133 22.7341C12.2213 22.7341 12.3263 22.7081 12.4273 22.6701C12.4403 22.6661 12.4543 22.6681 12.4663 22.6631L21.5573 18.8331C21.8943 18.6921 22.1133 18.3621 22.1133 17.9961V7.46614C22.1133 7.38214 22.0993 7.30014 22.0773 7.22114Z" fill="white" />
                                    </svg>Get Our App</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BANNER::END  -->

    <!-- FACILITES_AREA::START  -->
    <div class="facilites_area">
        <div class="container">
            <div class="facilites_inner">
                <div class="row align-items-center">

                    @foreach (@$sections['services']->data ?? [] as $key=>$item)
                    <div class="col-xl-3 col-lg-3 col-md-6 ">
                        <div class="facilites_box d-flex align-items-center ">
                            <div class="facilites_box_icon">
                                <img src="{{ globalAsset(uploadPath($item['icon'], '90X60.webp')) }}" alt="Image">
                            </div>
                            <span class="horizontal_line"></span>
                            <div class="facilites_box_content">
                                <h4>{{ $item['title'] }}</h4>
                                <p>{{ $item['description'] }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>

        </div>
    </div>
    <!-- FACILITES_AREA::END  -->

    <!-- FEATURE::START  -->
    <div id="Features" class="teaching_area section_padding2 ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-8 col-xl-6">
                    <div class="section__title text-center mb_50">
                        <h3>{{ @$sections['feature']->name }}</h3>
                        <p>{{ @$sections['feature']->description }}</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">

                <!-- SINGLE_WIDGET -->
                @foreach (@$data['features'] as $item)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="feature_widget_box text-center mb_30">
                            <div class="icon">
                                <img height="40" src="{{ @globalAsset(@$item->upload->path, '40X40.webp') }}" alt="Photo">
                            </div>
                            <h4>{{ $item->title }}</h4>
                            <p>{{ $item->description }}</p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- FEATURE::END  -->

    <!-- PRICING::START  -->
    <div id="Pricing" class="pricing_area section_spacing gray_bg">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-xl-6">
                    <div class="section__title text-center mb_50">
                        <h3>{{ @$sections['package']->name }}</h3>
                        <p>{{ @$sections['package']->description }}</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center align-items-center">


                {{-- Default 2 active --}}
                @foreach (@$data['packages'] as $key=>$package)
                    <div class="col-xl-3 mb-5">
                        <div class="pricing_widget {{$package->popular == 1 ? 'active_price':'' }}"> <!-- active_price -->
                            <div class="pricing_widget_header">

                                @if ($package->popular == 1) <!-- when active -->
                                    <div class="d-flex justify-content-end">
                                        <span class="pricing_tag">MOST POPULAR</span>
                                    </div>
                                @endif

                                <h3>${{ $package->price }}
                                    <span>/
                                        @if ($package->duration == \App\Enums\PricingDuration::DAYS)
                                            {{ $package->duration_number }} {{ ___('common.days') }}
                                        @elseif ($package->duration == \App\Enums\PricingDuration::MONTHLY)
                                            {{ $package->duration_number }} {{ ___('common.monthly') }}
                                        @elseif ($package->duration == \App\Enums\PricingDuration::YEARLY)
                                            {{ $package->duration_number }} {{ ___('common.yearly') }}
                                        @else
                                            {{ ___('common.lifetime') }}
                                        @endif
                                    </span>
                                </h3>

                                <h4>{{ $package->name }}</h4>
                                <p>{{ $package->description }}</p>
                            </div>
                            <div class="pricing_widget_body">
                                <ul class="mb_30">
                                    <li><span><i class="fas fa-user"></i></span>Staff Limit: {{ $package->staff_limit }}</li>
                                    <li><span><i class="fas fa-user"></i></span>Student Limit: {{ $package->student_limit }}</li>
                                    @foreach (@$data['features'] as $item)
                                        <li><span><i class="fas {{ in_array($item->id, @$package->packageChilds->pluck('feature_id')->toArray()) ? 'fa-check' : 'fa-times' }}"></i></span>{{ $item->title }}</li>
                                    @endforeach
                                </ul>
                                @if (session()->has('subdomainForPackageUpgrade'))
                                    <a class="{{ $package->popular == 1 ? 'theme_btn_blue_line':'theme_btn_blue' }} w-100" href="upgrade-subscription/{{ $package->id }}/{{ session()->get('subdomainForPackageUpgrade') }}">Upgrade plan</a>
                                @else
                                    <a class="{{ $package->popular == 1 ? 'theme_btn_blue_line':'theme_btn_blue' }} w-100" href="{{ route('purchase-subscription', $package->id) }}">Choose plan</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach



            </div>
        </div>
    </div>
    <!-- PRICING::END   -->

    <!-- TESTIMONIAL::START  -->
    <div id="Testimonial" class="testmonial_area gray_bg section_spacing">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-8 col-xl-6">
                    <div class="section__title text-center mb_50">
                        <h3>{{ @$sections['testimonial']->name }}</h3>
                        <p>{{ @$sections['testimonial']->description }}</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-11">
                    <div class="testmonail_active owl-carousel mb_30">


                        @foreach (@$data['testimonials'] as $item)
                            <div class="single_testmonial">
                                <div class="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if ($i <= $item->rating && $item->rating != 0)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="fas fa-star in_active"></i>
                                        @endif
                                    @endfor
                                </div>
                                <p>“{{ $item->description }}”</p>
                                <div class="testmonial_header d-flex align-items-center gap_20">
                                    <div class="thumb">
                                        <img width="65" height="65" src="{{ @globalAsset(@$item->upload->path, '90X60.webp') }}" alt="Photo">
                                    </div>
                                    <div class="reviewer_name">
                                        <h4>{{ $item->name }}</h4>
                                        <span>{{ $item->link }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach



                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- TESTIMONIAL::END  -->

    <!-- CONTACT::START  -->
    <div id="Contact" class="cta_area gray_bg section_spacing2">
        <div class="container">
            <div class="row">
                <div class="col-xl-11">
                    <div class="row">
                        <div class="col-xl-6 mb_30">
                            <div class="section__title mb_50 max_555">
                                <h3>{{ @$sections['contact']->name }}</h3>
                                <p>{{ @$sections['contact']->description }}</p>
                            </div>
                            <div class="quote_boxes">
                                <div class="quote_box d-flex align-items-center w-100">
                                    <div class="icon">
                                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M2 8.19366V14.9065L7.65873 10.8645L2 8.19366ZM2 18.0842V16.7498L9.07743 11.6945L8.90461 11.4526L10.7314 12.3148C11.5346 12.6939 12.4654 12.6939 13.2686 12.3148L15.0954 11.4526L14.9226 11.6945L22 16.7498V18.0842C22 19.1888 21.1046 20.0842 20 20.0842H4C2.89543 20.0842 2 19.1888 2 18.0842ZM22 14.9065V8.19366L16.3413 10.8645L22 14.9065ZM20.6434 4.18996C20.9484 4.29352 21.2203 4.46868 21.4392 4.69542C21.6436 4.9482 21.766 5.27001 21.766 5.62042V6.64542L12.6284 10.9583C12.2305 11.1461 11.7695 11.1461 11.3716 10.9583L2.23401 6.64542V5.62042C2.23401 5.27001 2.35643 4.94819 2.56083 4.69541C2.77968 4.46867 3.05161 4.29352 3.35661 4.18996C3.46868 4.16266 3.58576 4.14819 3.70623 4.14819H20.2938C20.4142 4.14819 20.5313 4.16266 20.6434 4.18996Z" fill="#392C7D" />
                                        </svg>
                                    </div>
                                    <div class="quote_box_body">
                                        <h5>Email</h5>
                                        <p>{{ @$sections['contact']->data[0] }}</p>
                                    </div>
                                </div>
                                <div class="quote_box d-flex align-items-center w-100">
                                    <div class="icon">
                                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15.9996 8.06581L19.5352 4.53027" stroke="#392C7D" stroke-width="1.5" stroke-linecap="round" />
                                            <path d="M16.7069 4.53042L19.4248 4.53042C19.4858 4.53042 19.5353 4.5799 19.5353 4.64094L19.5353 7.35885" stroke="#392C7D" stroke-width="1.5" stroke-linecap="round" />
                                            <path d="M8.81246 7.06324L7.23283 4.37482C6.92409 3.84935 6.2541 3.66982 5.75283 4.01647C4.76655 4.69853 3.29662 5.89508 2.93095 7.17437C2.36331 9.16024 4.40957 13.8896 7.1916 16.6717C9.97371 19.4538 14.4618 21.2586 16.4478 20.6912C17.727 20.3257 18.9238 18.8564 19.6061 17.8703C19.953 17.369 19.7735 16.6989 19.2479 16.39L16.5595 14.8104C16.0494 14.5107 15.3944 14.6587 15.0627 15.1485L14.3236 16.2399C14.0037 16.7122 13.3828 16.8638 12.9049 16.5522C12.1352 16.0504 10.9373 15.1807 9.68936 13.9328C8.44161 12.685 7.57201 11.4872 7.07014 10.7176C6.75847 10.2396 6.91019 9.61845 7.38278 9.29866L8.47403 8.56024C8.96407 8.22864 9.1122 7.57339 8.81246 7.06324Z" fill="#392C7D" />
                                        </svg>

                                    </div>
                                    <div class="quote_box_body">
                                        <h5>Phone</h5>
                                        <p>{{ @$sections['contact']->data[1] }}</p>
                                    </div>
                                </div>
                                <div class="quote_box d-flex align-items-center w-100">
                                    <div class="icon">
                                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_4808_2553)">
                                                <path d="M12 21.0163L16.95 16.0663C17.9289 15.0873 18.5955 13.84 18.8656 12.4821C19.1356 11.1243 18.9969 9.71685 18.4671 8.43781C17.9373 7.15877 17.04 6.06556 15.8889 5.29642C14.7378 4.52728 13.3844 4.11676 12 4.11676C10.6156 4.11676 9.26222 4.52728 8.11109 5.29642C6.95996 6.06556 6.06275 7.15877 5.53292 8.43781C5.00308 9.71685 4.86442 11.1243 5.13445 12.4821C5.40449 13.84 6.07111 15.0873 7.05 16.0663L12 21.0163ZM12 23.8443L5.636 17.4803C4.37734 16.2216 3.52019 14.6179 3.17293 12.8721C2.82567 11.1263 3.00391 9.31668 3.6851 7.67216C4.36629 6.02763 5.51984 4.62203 6.99988 3.6331C8.47992 2.64417 10.22 2.11633 12 2.11633C13.78 2.11633 15.5201 2.64417 17.0001 3.6331C18.4802 4.62203 19.6337 6.02763 20.3149 7.67216C20.9961 9.31668 21.1743 11.1263 20.8271 12.8721C20.4798 14.6179 19.6227 16.2216 18.364 17.4803L12 23.8443ZM12 13.1163C12.5304 13.1163 13.0391 12.9055 13.4142 12.5305C13.7893 12.1554 14 11.6467 14 11.1163C14 10.5858 13.7893 10.0771 13.4142 9.70204C13.0391 9.32697 12.5304 9.11625 12 9.11625C11.4696 9.11625 10.9609 9.32697 10.5858 9.70204C10.2107 10.0771 10 10.5858 10 11.1163C10 11.6467 10.2107 12.1554 10.5858 12.5305C10.9609 12.9055 11.4696 13.1163 12 13.1163ZM12 15.1163C10.9391 15.1163 9.92172 14.6948 9.17158 13.9447C8.42143 13.1945 8 12.1771 8 11.1163C8 10.0554 8.42143 9.03797 9.17158 8.28783C9.92172 7.53768 10.9391 7.11625 12 7.11625C13.0609 7.11625 14.0783 7.53768 14.8284 8.28783C15.5786 9.03797 16 10.0554 16 11.1163C16 12.1771 15.5786 13.1945 14.8284 13.9447C14.0783 14.6948 13.0609 15.1163 12 15.1163Z" fill="#392C7D" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_4808_2553">
                                                    <rect width="24" height="24" fill="white" transform="translate(0 0.116211)" />
                                                </clipPath>
                                            </defs>
                                        </svg>

                                    </div>
                                    <div class="quote_box_body">
                                        <p>{{ @$sections['contact']->data[2] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 ">
                            <form class="form-area contact-form" id="contact_form" method="post">
                                <div class="quoteForm mb_30">

                                    <div class="single_select">
                                        <label class="primary_label2">Phone</label>
                                        <input name="phone" placeholder="Type phone number" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Type phone number'" class="primary_input mb_30 phone" required="">

                                    </div>
                                    <div class="single_select">
                                        <label class="primary_label2">Email Address</label>
                                        <input name="email" placeholder="Type e-mail address" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Type e-mail address'" class="primary_input mb_30 email" required="" type="email">

                                    </div>
                                    <div class="single_select">
                                        <label class="primary_label2">Message</label>
                                        <textarea class="primary_textarea mb_30 message" name="message" placeholder="What ca we help you with?" onfocus="this.placeholder = ''" onblur="this.placeholder = 'What ca we help you with?'" required=""></textarea>
                                    </div>
                                    <div class="mb_20">
                                        <label class="primary_checkbox d-flex mb_30 align-items-start">
                                            <input type="checkbox" name="agree" class="agree" >
                                            <span class="checkmark mr_10"></span>
                                            <span class="label_name">I’d like to occasionally receive other communication from Stellar, such as contact and product news</span>
                                        </label>
                                    </div>
                                    <button class="contact_btn theme_btn_blue small_btn6">Submit <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.2344 6.61621L19.1572 11.868C19.606 12.2659 19.606 12.9665 19.1572 13.3644L13.2344 18.6162" stroke="white" stroke-width="1.5" stroke-linecap="round" />
                                            <path d="M4 12.6162L19.4667 12.6162" stroke="white" stroke-width="1.5" stroke-linecap="round" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTACT::END  -->

    <!-- FAQ::START  -->
    <div id="Faq" class="faq_area section_spacing">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="section__title text-center mb_50">
                        <h3>{{ @$sections['faq']->name }}</h3>
                        <p>{{ @$sections['faq']->description }}</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="theme_according mb_30 grid_card_accordion" id="accordion1">

                        <div class="row">
                            @foreach (@$data['faqs'] as $item)
                                <div class="col-xl-6">
                                    <div class="card">
                                        <div class="card-header pink_bg" id="heading{{ $loop->iteration }}">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link text_white collapsed" data-toggle="collapse" data-target="#collapse{{ $loop->iteration }}" aria-expanded="false" aria-controls="collapse{{ $loop->iteration }}">{{ $item->question }}</button>
                                            </h5>
                                        </div>
                                        <div class="collapse" id="collapse{{ $loop->iteration }}" aria-labelledby="heading{{ $loop->iteration }}" data-parent="#accordion1">
                                            <div class="card-body">
                                                <p>{{ $item->answer }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FAQ::END   -->

@endsection
