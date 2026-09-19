    <!-- FOOTER::START  -->
    <footer class="home_three_footer">
        <div class="main_footer_wrap">
            <div class="container">
                 <div class="row">
                    <div class="col-xl-5 col-lg-4 col-md-6">
                        <div class="footer_widget">
                            <div class="footer_logo">
                                <a href="#">
                                    <img height="50" src="{{ @globalAsset(setting('light_logo'), '154X38.webp') }}" alt="Image">
                                </a>
                            </div>
                            <p class="description_text">{{ settingLocale('school_about') }}</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="footer_widget">
                            <div class="footer_title">
                                <h3>Product</h3>
                            </div>
                            <ul class="footer_links">
                                <li><a href="#Home">Home</a></li>
                                <li><a href="#Features">Features</a></li>
                                <li><a href="#Pricing">Pricing</a></li>
                                <li><a href="#Testimonial">Testimonial</a></li>
                                <li><a href="#Faq">FAQs</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4  col-md-6">
                        <div class="footer_widget">
                            <div class="footer_title">
                                <h3>subscribe to newsletter</h3>
                            </div>
                            <p class="subscribe_text">Join <span>{{ $subscriber }}</span> designers and get weekly inspiration</p>
                            <div class="subcribe-form mb_20 theme_mailChimp2" id="mc_embed_signup">
                                <form action="#" method="post" class="subscription relative">
                                    <input name="email" class="form-control email" placeholder="{{ ___('frontend.type_email_address') }}" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Type e-mail address'" class="primary_input mb_30 email" required="" type="email">
                                    <button type="submit" class="submit-btn">{{ ___('frontend.Subscribe') }}</button>
                                </form>
                            </div>
                            <div class="social__Links">
                                
                                {{-- @foreach (@$data['sections']['social_links']->data ?? [] as $item)
                                    <a target="_blank" href="{{ $item['link'] }}"><i class="{{ $item['icon'] }}"></i></a>
                                @endforeach --}}
                                 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright_area p-0">
            <div class="container">
                <div class="footer_border m-0"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="copy_right_text d-flex align-items-center gap_20 flex-wrap justify-content-center">
                            <p>@<span id="date_dynamic"> {{ Carbon\Carbon::now()->year }} </span> {{ setting('application_name') }}  All right Reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- FOOTER::END  -->