<div class="preview_box_wrapper">
    <div class="preview_box  ">
        <div class="preview_box_inner d-flex flex-wrap flex-xxl-nowrap">
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
                        <h3>Student Name</h3>
                        @endif
                        @if($data['idcard']->class_name && $data['idcard']->section_name)
                            <span class="class_name">Class 6 (A)</span>
                        @elseif($data['idcard']->class_name)
                            <span class="class_name">Class: Class 6</span>
                        @elseif($data['idcard']->section_name)
                            <span class="class_name">Section: A</span>
                        @endif

                    </div>
                    <div class="student_info">
                        
                        @if($data['idcard']->student_name)
                        <p>Admission No: 123.456.789</p>
                        @endif
                        @if($data['idcard']->roll_no)
                        <p>Roll No: 123.456.789</p>
                        @endif
                        @if($data['idcard']->dob)
                        <p>Date of birth: MM/DD/YEAR </p>
                        @endif
                        @if($data['idcard']->blood_group)
                        <p>Blood Group: B+ </p>
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
                    <h5>EXPIRED: MM/DD/YEAR</h5>
                    @endif
                    <div class="qr_code">
                        @if($data['idcard']->qr_code)
                            <img src="{{ @globalAsset(@$data['idcard']->qrCode->path, '40X40.webp') }}" alt="">
                        @endif 
                    </div>
                </div>

                <div class="id_card_back_logo_img">
                    <img width="50%" src="{{  @globalAsset(setting('light_logo'), '154X38.webp')  }}" alt="#">
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

    </div>
</div>