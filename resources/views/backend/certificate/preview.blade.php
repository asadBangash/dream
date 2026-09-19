@php
    $words = explode(' ', $data['certificate']->title);
    // Get the first word (index 0) from the array
    $firstWord = $words[0];
    $restofWord = Str::replace($words[0], '', $data['certificate']->title);
@endphp

<div class="preview_box_wrapper ">
    <h4 class="preview_title">Format</h4>
    <div class="certificate_wrapper_preview_box">
        <div class="certificate_wrapper">
            <div class="certificate_wrapper_bg">

                @if($data['certificate']->frontside_bg_image)
                    <img src="{{ @globalAsset(@$data['certificate']->bgImage->path, '40X40.webp') }}" alt="">
                @else 
                    <img src="{{ asset('backend') }}/uploads/card-images/certificate_bg.png" alt="">
                @endif

            </div>
            @if($data['certificate']->logo)
            <div class="large_logo">
                <img src="{{  @globalAsset(setting('dark_logo'), '154X38.webp')  }}" alt="#">
            </div>
            @endif

            <div class="certificate_info">
                <h3>{{$firstWord}}</h3>
                <p class="subtext">{{$restofWord}}</p>
                <p class="subtext_short_description">{{ $data['certificate']->top_text }}</p>
                @if($data['certificate']->name)
                <div class="certificate__name">
                    <h2>Name Surname</h2>
                </div>
                @endif

                <p class="certificate_description">{!! $data['certificate']->description !!}</p>
            </div>
            <div class="signature_imgs">
                <div class="signature_single">
                    @if($data['certificate']->bottom_left_signature)
                    <div class="signature_img">
                        <img src="{{ @globalAsset(@$data['certificate']->leftSignature->path, '40X40.webp') }}" alt="">
                    </div>
                    @endif
                    <div class="border_1px"></div>
                    <span>{{$data['certificate']->bottom_left_text}}</span>
                </div>
                <div class="signature_single">
                    @if($data['certificate']->bottom_right_signature)
                    <div class="signature_img">
                        <img src="{{ @globalAsset(@$data['certificate']->rightSignature->path, '40X40.webp') }}" alt="">
                    </div>
                    @endif
                    <div class="border_1px"></div>
                    <span>{{$data['certificate']->bottom_right_text}}</span>
                </div>
            </div>
        </div>
    </div>
</div>