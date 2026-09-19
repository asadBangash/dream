<style>
    .id_card_front {
        width: 250px;
        min-width: 250px;
        height: 387px;
        min-height: 387px;
        position: relative;
        border-radius: 8px;
        background: #FFF;
        box-shadow: 0px 4px 11px 0px rgba(0, 0, 0, 0.15);
        display: flex;
        justify-content: center;
        align-items: flex-end;
        width: 250px;
        min-width: 250px;
        min-height: 387px;
        height: 387px;
        overflow: hidden;

    }

    .shape_img_top {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 8px;
        min-height: 387px !important;
    }

    .shape_img_top img {
        border-radius: 8px;
        height: 100%;
        width: 100%;
        object-fit: cover;
        object-position: top;
    }

    .id_card_front_inner h3 {
        color: #003249;
        font-family: Lexend;
        font-size: 21.323px;
        font-style: normal;
        font-weight: 600;
        line-height: normal;
        margin-bottom: 8px;
    }

    .id_card_front_inner .class_name {
        color: #003249;
        font-family: Lexend;
        font-size: 12.794px;
        font-style: normal;
        font-weight: 300;
        line-height: normal;
        text-align: center;
        display: block;
        margin-bottom: 12px;
    }

    .student_info p {
        color: #003249;
        font-family: Lexend;
        font-size: 9.946px;
        font-style: normal;
        font-weight: 300;
        line-height: normal;
        margin-bottom: 4px;
    }

    .id_card_profile_img {
        width: 98.315px;
        height: 98.315px;
        transform: rotate(45deg);
        flex-shrink: 0;
        box-shadow: 0px 0px 4.569228172302246px rgba(0, 0, 0, 0.25);
        background: #fff;
        margin: 0 auto;
        position: relative;
        top: -20px;
        margin-bottom: 7px;

    }

    .id_card_profile_img img {
        width: calc(100% + 10px);
        height: calc(100% + 10px);
        transform: rotate(-45deg);
        clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
        position: relative;
        top: -5px;
        right: 5px;
    }

    .id_card_front_info {
        position: relative;
        z-index: 12;
        height: 100%;
        /* padding-top: 100px; */
        height: 387px;
        top: 95px;
        padding-top: 0;
        width: 250px !important;
        min-width: 250px !important;

    }

    .signature_image {
        max-width: 73px;
        margin: 0 auto;
        margin-top: 15px;
    }

    .signature_image img {
        max-width: 100%;
        height: 30px;
        object-fit: cover;
    }

    .id_card_back {
        width: 250px;
        min-width: 250px;
        height: 387px;
        position: relative;
        border-radius: 8px;
        background: #FFF;
        box-shadow: 0px 4px 11px 0px rgba(0, 0, 0, 0.15);
        display: flex;
        justify-content: center;
        align-items: flex-start;
        overflow: hidden;
    }

    .id_card_back .shape_img_top {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 8px;
    }

    .id_card_back .shape_img_top img {
        border-radius: 8px;
        height: 100%;
        width: 100%;
        object-fit: cover;
        object-position: bottom;
    }

    .id_card_back {
        padding: 38px 29px;
        text-align: center;
    }

    .id_card_back_info {
        position: relative;
        z-index: 12;
    }

    .id_card_back .id_card_back_info p {
        color: #003249;
        text-align: center;
        font-family: Lexend;
        font-size: 10.403px;
        font-style: normal;
        font-weight: 300;
        line-height: normal;

    }

    .id_card_back .id_card_back_info h5 {
        color: #003249;
        font-family: Lexend;
        font-size: 10.403px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        margin: 18px 0 25px 0;
    }

    .id_card_back .id_card_back_info .qr_code {
        width: 57.786px;
        height: 57.709px;
        margin: 0 auto;
    }

    .id_card_back .id_card_back_info .qr_code img {
        max-width: 100%;
    }

    .id_card_back_logo_img {
        position: absolute;
        left: 20px;
        bottom: 45px;
        z-index: 15;
        text-align: left;
    }

    .id_card_back_logo_img img {
        max-width: 100px;
        width: 100%;
        object-fit: cover;
    }

    .gap_12 {
        grid-gap: 12px;
    }

    .gray_card {}

    .gray_card .card-header h3 {
        color: #1A1D1F;
        font-family: Lexend;
        font-size: 18px;
        font-style: normal;
        font-weight: 600;
        line-height: 30px;
    }

    .gray_card .card-body {
        background: #F2F2F2;
        border-radius: 0;
    }

    .generated_card_wrapper {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        grid-gap: 24px;
    }

    @media (max-width: 767.98px) {
        .preview_box_wrapper {
            margin-top: 20px;
        }
    }

    @media (min-width: 320px) and (max-width: 575.98px) {
        .generated_card_wrapper {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
    }

    @media (min-width: 576px) and (max-width: 767.98px) {
        .generated_card_wrapper {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 768px) and (max-width: 991.98px) {
        .generated_card_wrapper {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (min-width: 992px) and (max-width: 1199.98px) {
        .generated_card_wrapper {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    .card_generated_img img {
        max-width: 100%;
        object-fit: cover;
    }

    .ot-btn-cancel {
        border-radius: 4px;
        background: rgba(4, 82, 204, 0.10);
        font-size: 13px;
        font-weight: 500;
    }

    .grid_cards_view {
        display: grid;
        width: 100%;
        grid-template-columns: repeat(auto-fill, minmax(396px, 1fr));
        grid-gap: 10px;
    }

    #printContent {
        width: 100%;
    }

    .preview_box_inner {
        display: flex;
        flex-wrap: wrap;
        grid-gap: 10px;
    }

    .id_card_front {
        width: 250px;
        height: 387px;
    }

    /* .student_info, .id_card_front_inner{
        position: relative;
        left: 60px;
        padding: 0 !important;
    } */
    .id_card_front_info {
        position: relative;
        z-index: 12;
        height: 100%;
        /* padding-top: 100px; */
        height: 387px;
        top: 95px;
        padding-top: 0;
        width: 160px !important;
        min-width: 160px !important;
    }

    .id_card_back .shape_img_top img {
        border-radius: 8px;
        height: 100%;
        width: 100%;
        object-fit: cover;
        object-position: bottom;
        width: 250px;
        height: 387px;
    }

    .id_card_back {
        height: 387px;
        width: 250px;
        max-width: 250px;
        padding: 0;
        min-width: 250px !important;
    }
    @media print {
        .grid_cards_view .preview_box_inner {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 10px;
        }
    }
</style>
<div class="grid_cards_view">
    @foreach($data['students'] as $row)
    <div class="preview_box_inner ">
        <!-- id_card_front  -->
        <div class="id_card_front">
            <div class="shape_img_top">
                @if($data['idcard']->frontside_bg_image)
                <img src="{{ @globalAsset(@$data['idcard']->frontendBg->path, '40X40.webp') }}" alt="">
                @else
                <img src="{{ asset('backend') }}/uploads/card-images/card-top-shape.png" alt="">
                @endif
            </div>
            <div class="id_card_front_info">
                <div class="id_card_front_inner">
                    <div class="id_card_profile_img">
                        <!-- <img src="{{ asset('backend') }}/uploads/card-images/card_profile.png" alt=""> -->
                        <img src="https://bennettfeely.com/clippy/pics/pittsburgh.jpg" alt="">
                    </div>
                    @if($data['idcard']->student_name)
                    <h3>{{$row->student->first_name.' '.$row->student->last_name}}</h3>
                    @endif
                    @if($data['idcard']->class_name && $data['idcard']->section_name)
                    <span class="class_name">{{$row->class->name}} ({{$row->section->name}})</span>
                    @elseif($data['idcard']->class_name)
                    <span class="class_name">Class: {{$row->class->name}}</span>
                    @elseif($data['idcard']->section_name)
                    <span class="class_name">Section: {{$row->section->name}}</span>
                    @endif
                </div>
                <div class="student_info">

                    @if($data['idcard']->student_name)
                    <p>Admission No: {{$row->student->admission_no}}</p>
                    @endif
                    @if($data['idcard']->roll_no)
                    <p>Roll No: {{$row->student->roll_no}}</p>
                    @endif
                    @if($data['idcard']->dob)
                    <p>Date of birth: {{date('m/d/Y', strtotime($row->student->dob))}} </p>
                    @endif
                    @if($data['idcard']->blood_group)
                    <p>Blood Group: {{$row->student->blood->name}} </p>
                    @endif

                    <div class="signature_image ">
                        @if($data['idcard']->signature)
                        <img src="{{ @globalAsset(@$data['idcard']->signatureImage->path, '40X40.webp') }}" alt="">
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- id_card_front  -->
        <div class="id_card_back">
            <div class="id_card_back_info">
                <p>{{$data['idcard']->backside_description}}</p>
                @if($data['idcard']->expired_date)
                <h5>EXPIRED: {{date('m/d/Y', strtotime($data['idcard']->expired_date))}}</h5>
                @endif
                <div class="qr_code">
                    @if($data['idcard']->qr_code)
                    <img src="{{ @globalAsset(@$data['idcard']->qrCode->path, '40X40.webp') }}" alt="">
                    @endif
                </div>
            </div>

            <div class="id_card_back_logo_img">
                <img width="50%" src="{{ @globalAsset(setting('light_logo'), '154X38.webp')  }}" alt="#">
            </div>
            <div class="shape_img_top">
                @if($data['idcard']->backside_bg_image)
                <img src="{{ @globalAsset(@$data['idcard']->backsideBg->path, '40X40.webp') }}" alt="">
                @else
                <img src="{{ asset('backend') }}/uploads/card-images/card-bottom-shape.png" alt="#">
                @endif

            </div>
        </div>
    </div>
    @endforeach
</div>