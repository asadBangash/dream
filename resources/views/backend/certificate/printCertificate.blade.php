<style>
    .certificate_wrapper {
        width: 900px;
        min-width: 565.22px;
        height: 500px;
        position: relative;
        border-radius: 8px;
        background: #FFF;
        box-shadow: 0px 4px 22px 0px rgba(0, 0, 0, 0.15);
        margin-bottom: 10px;
    }

    .certificate_wrapper_preview_box {
        display: flex;
        max-width: 100%;
        min-height: auto;
        justify-content: center;
        align-items: center;
        border-radius: 12px;
        background: #F2F2F2;
        overflow: auto;
    }

    .certificate_wrapper_preview_box .certificate_wrapper .certificate_info {
        position: relative;
        z-index: 12;
        max-width: 392px;
        margin: 0 auto;
        padding-top: 50px;
    }

    .certificate_wrapper_preview_box .certificate_wrapper .certificate_wrapper_bg {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        left: 0;
        top: 0;

    }

    .certificate_wrapper_preview_box .certificate_wrapper .certificate_wrapper_bg img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }

    .certificate_info h3 {
        color: #392C7D;
        font-family: Lexend;
        font-size: 32.61px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        text-align: center;
        margin-bottom: 3px;
    }

    .certificate_info .subtext {
        color: #392C7D;

        font-family: Lexend;
        font-size: 10.91px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        text-align: center;
    }

    .certificate_info .subtext_short_description {
        color: #15344D;
        font-family: Inter;
        font-size: 7.5px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        text-align: center;
        margin-bottom: 10px;
    }

    .certificate_info .certificate__name {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .certificate_info h2 {
        color: #15344D;
        font-family: Lexend;
        font-size: 31.107px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        text-align: center;
        position: relative;
        display: inline-block;
        margin: 0 auto;
        padding-bottom: 4px;
        margin-bottom: 17px;
    }

    .certificate_info h2::before {
        content: "";
        position: absolute;
        bottom: 0;
        border-bottom: 1px solid #392C7D;
        left: 20%;
        right: 20%;
    }

    .certificate_info .certificate_description {
        color: #939393;
        text-align: center;
        font-family: Lexend;
        font-size: 10px;
        font-style: normal;
        font-weight: 400;
        line-height: 16px;
        /* 160% */
    }

    .signature_imgs {
        position: absolute;
        display: flex;
        align-items: center;
        grid-gap: 59px;
        left: 0;
        right: 0;
        z-index: 1212;
        justify-content: center;
        bottom: 42px;
    }

    .signature_imgs .signature_single .signature_img {
        text-align: center;
    }

    .signature_imgs .signature_single .signature_img img {
        width: 73.945px;
        height: 29.258px;
        object-fit: cover;
        margin-bottom: 5px;
    }

    .signature_imgs .signature_single span {
        color: #15344D;
        font-family: Lexend;
        font-size: 6px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        text-transform: uppercase;
        text-align: center;
        display: block;
        display: block;
        padding-top: 5px;
    }

    .signature_imgs .border_1px {
        width: 92.48px;
        border-bottom: 1px solid #392C7D;
    }

    .certificate_wrapper .large_logo {
        position: absolute;
        top: 32px;
        right: 34px;
        width: 66px;
        height: 56px;
    }

    .certificate_wrapper .large_logo img {
        max-width: 100%;
    }

    .preview_box_wrapper .preview_title {
        color: #666;
        font-family: Roboto;
        font-size: 20px;
        font-style: normal;
        font-weight: 500;
        line-height: 24px;
        text-align: center;
        margin-bottom: 12px;
    }
</style>

@foreach($data['students'] as $row)
<div class="col-md-12">

    <div class="certificate_wrapper_preview_box p-4">
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
                    <h2>{{$row->student->first_name.' '.$row->student->last_name}}</h2>
                </div>
                @endif

                @php

                $data['description'] = $data['certificate']->description;
                $data['description'] = str_replace('[student_name]', $row->student->first_name.' '.$row->student->last_name, $data['description']);
                $data['description'] = str_replace('[class_name]', $row->class->name, $data['description']);
                $data['description'] = str_replace('[section_name]', $row->section->name, $data['description']);
                $data['description'] = str_replace('[school_name]', setting('application_name'), $data['description']);
                $data['description'] = str_replace('[session]', $data['session'], $data['description']);
                $data['description'] = str_replace('[school_address]', setting('address'), $data['description']);
                @endphp

                <p class="certificate_description">{!!$data['description']!!}</p>


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
@endforeach