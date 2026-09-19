@extends('student-panel.partials.master')

@section('title')
    {{ ___('common.Online Exam View') }}
@endsection
<style>
    body {
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        margin: 0;
        padding: 0;
        -webkit-print-color-adjust: exact !important;
    }

    table {
        border-collapse: collapse;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        margin: 0;
        color: #000;
    }

    .routine_wrapper {
        max-width: 1200px;
        margin: auto;
        background: #fff;
        padding: 0px;
        border-radius: 8px;
        background: #ECECEC;
    }

    .routine_wrapper_body {
        padding: 36px;
    }

    .table {
        width: 100%;
        margin-bottom: 1rem;
        color: #212529;
    }

    .border_none {
        border: 0px solid transparent;
        border-top: 0px solid transparent !important;
    }

    .routine_part_iner {
        background-color: #fff;
    }

    .routine_part_iner h4 {
        font-size: 30px;
        font-weight: 500;
        margin-bottom: 40px;

    }

    .routine_part_iner h3 {
        font-size: 25px;
        font-weight: 500;
        margin-bottom: 5px;

    }

    .table_border thead {
        background-color: #F6F8FA;
    }

    .table td,
    .table th {
        padding: 0px 0;
        vertical-align: top;
        border-top: 0 solid transparent;
        color: #000;
    }

    .table_border tr {
        border-bottom: 1px solid #000 !important;
    }

    th p span,
    td p span {
        color: #212E40;
    }

    .table th {
        color: #000;
        font-weight: 300;
        border-bottom: 1px solid #000 !important;
        background-color: #fff;
    }

    p {
        font-size: 14px;
        color: #000;
        font-weight: 400;
    }

    h5 {
        font-size: 12px;
        font-weight: 500;
    }

    h6 {
        font-size: 10px;
        font-weight: 300;
    }

    .mt_40 {
        margin-top: 40px;
    }

    .table_style th,
    .table_style td {
        padding: 20px;
    }

    .routine_info_table td {
        font-size: 10px;
        padding: 0px;
    }

    .routine_info_table td h6 {
        color: #6D6D6D;
        font-weight: 400;
    }

    .text_right {
        text-align: right;
    }

    .virtical_middle {
        vertical-align: middle !important;
    }

    .border_bottom {
        border-bottom: 1px solid #000;
    }

    .line_grid {
        display: grid;
        grid-template-columns: 100px auto;
        grid-gap: 10px;
    }

    .line_grid span {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    p {
        margin: 0;
        color: #000;
    }

    .font_18 {
        font-size: 18px;
    }

    .mb-0 {
        margin-bottom: 0;
    }

    .mb_30 {
        margin-bottom: 30px !important;
    }

    .mb_40 {
        margin-bottom: 40px !important;
    }

    .mb_10 {
        margin-bottom: 10px !important;
    }

    .mb_20 {
        margin-bottom: 20px !important;
    }

    .bold_text {
        font-weight: 600;
    }

    .border_table {
        /* border: 1px solid #000; */
    }

    .title_header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 40px 0 15px 0;
    }

    .border_table tr:nth-of-type(n) {
        border: 1px solid #000;
    }

    .border_table tfoot tr:first-of-type {
        border: 0;
    }

    .border_table tfoot tr:first-of-type td {
        border: 0;
    }

    .routine_header h3 {
        font-size: 24px;
        font-weight: 500;
    }

    .routine_header p {
        font-size: 14px;
        font-weight: 400;
        margin-bottom: 15px !important;
    }

    .border_table thead tr th {
        border-right: 0;
        border-color: transparent !important;
        text-align: left;
        background: #EAEAEA;
        white-space: nowrap;
        background: #E6E6E6 !important;
        color: #1A1A21 !important;
        font-size: 16px;
        font-weight: 500;
        text-transform: capitalize;
        padding: 8px 12px;
    }

    .border_table tbody tr td,
    .border_table tfoot tr td {
        border-bottom: 0;
        text-align: center;
        font-size: 12px;
        padding: 5px;
        border-right: 0;
    }

    .border_table tr:nth-of-type(n) {
        border: 0;
    }

    .border_table tr:nth-of-type(odd) {
        border: 0;
        background: #F8F8F8;
    }

    .border_table tr:nth-of-type(even) {
        border: 0;
        background: #EFEFEF;
    }

    .border_table tbody tr th {
        background: #EAEAEA;
        border: 1px solid #FFFFFF;
        font-weight: 700;
        font-size: 18px;
        line-height: 30px;
        border-color: #fff !important;
        color: #424242;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 140px;
        padding: 2px 6px;
    }

    .classBox_wiz {
        min-height: 26px;
        vertical-align: middle;
        display: flex;
        align-items: center;
        padding: 8px 6px;
    }

    .classBox_wiz h5 {
        font-weight: 400;
        font-size: 16px;
        line-height: 22px;
        color: #424242;
        margin: 0 0 5px 0;
        white-space: nowrap
    }

    .classBox_wiz p {
        font-weight: 500;
        font-size: 14px;
        line-height: 18px;
        color: #6B6B6B;
        margin: 0 0 5px 0;
    }

    .marked_bg {
        background: #E6E6E6 !important;
        color: #1A1A21 !important;
        font-size: 16px;
        font-weight: 500;
        text-transform: capitalize;
        padding: 8px 12px;
    }

    .break_text {
        min-height: 129px;
        vertical-align: middle;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 15px;
    }

    .break_text h5 {
        font-weight: 600;
        font-size: 18px;
        line-height: 22px;
        color: #424242;
        transform: rotate(-30deg);
    }

    .download_print_btns {
        display: flex;
        align-items: center;
        justify-content: center;
        grid-gap: 12px;
        padding-bottom: 60px;
    }

    .student_info_wrapper {
        background: #F5F5F5;
        border-radius: 8px;
        padding: 20px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .student_info_single {
        width: 45%;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        white-space: nowrap;
        margin-bottom: 8px;
    }

    .student_info_single span {
        min-width: 170px;
        color: #424242;
        font-size: 16px;
        line-height: 24px;
        text-transform: capitalize;
    }

    .student_info_single h5 {
        margin: 0;
        color: #1A1A21;
        font-weight: 400;
        font-size: 16px;
    }

    .routine_wrapper_header {
        background: #392C7D;
        padding: 32px 36px;
        border-radius: 8px 8px 0 0;
        margin-bottom: 0;
        flex-wrap: wrap;
        grid-gap: 20px;
    }

    .routine_wrapper_header h3 {
        font-weight: 500;
        font-size: 36px;
        line-height: 40px;
        color: #FFFFFF;
        margin: 0;
    }

    .routine_wrapper_header h4 {
        font-size: 24px;
        color: #FF5170;
        font-weight: 500;
        margin: 7px 0 7px 0;
    }

    .routine_wrapper_header p {
        font-weight: 400;
        font-size: 14px;
        color: #D6D6D6;
        margin: 0;
    }

    .routine_wrapper_header_logo .header_logo {
        max-width: 193px;
    }

    .routine_wrapper_header {
        display: flex;
        align-items: center;
    }

    .vertical_seperator {
        border-right: 1px solid #FFFFFF;
        height: 93px;
        margin: 0 30px 0 40px;
    }

    .markseet_title h5 {
        color: #242424;
        font-weight: 600;
        font-size: 24px;
        line-height: 36px;
        margin: 30px 0 30px 0;
        display: block;
        padding: 26px 0 12px 0;
        text-align: center;
    }

    @media (max-width: 768px) {
        .student_info_single {
            width: 100%;
        }

        .vertical_seperator {
            display: none !important;
        }

        .routine_wrapper {
            width: 100%;
        }

        .routine_wrapper_body {
            padding: 0;
        }

        .student_info_single {
            flex-wrap: wrap;
        }

        .download_print_btns {
            margin-top: 30px;
        }

        .routine_wrapper_header {
            padding: 20px 20px;
        }

        .routine_wrapper_header h3 {
            font-size: 24px;
        }
    }

    /* routine_wrapper_header  */
    .routine_wrapper_header {
        background: #392C7D;
        padding: 32px 36px;
        border-radius: 16px 16px 0 0;
        margin-bottom: 0;
        flex-wrap: wrap;
        grid-gap: 20px;
        margin-bottom: 20px;
        justify-content: center;
    }

    .routine_wrapper_header h3 {
        font-weight: 500;
        font-size: 36px;
        line-height: 40px;
        color: #FFFFFF;
        margin: 0;
    }

    .routine_wrapper_header h4 {
        font-size: 24px;
        color: #FF5170;
        font-weight: 500;
        margin: 7px 0 7px 0;
    }

    .routine_wrapper_header p {
        font-weight: 500;
        font-size: 18px;
        line-height: 30px;
        color: #FFFFFF;
        margin: 0;
    }

    .routine_wrapper_header_logo .header_logo {
        max-width: 193px;
    }

    .routine_wrapper_header {
        display: flex;
        align-items: center;
    }

    .routine_wrapper_header {
        padding: 30px 20px;
    }

    .routine_wrapper_header h3 {
        font-size: 24px;
    }

    .print_copyright_text {
        flex-direction: column;
        align-items: center;
        justify-content: center;
        grid-gap: 10px;
        margin: 20px 0;

    }
    
    .print_copyright_text{
        display: flex;
        align-items: center;
        padding-bottom: 10px;
    }

    .download_print_btns {
        display: flex;
        align-items: center;
        justify-content: start;
        grid-gap: 12px;
        background: #F3F3F3;
        padding: 20px;
        flex-wrap: wrap;
    }

    .vertical_seperator {
        border-right: 1px solid #FFFFFF;
        height: 93px;
        margin: 0 30px 0 40px;
    }
    .print_copyright_text{
        display: flex;
        align-items: center;
        padding-bottom: 10px;
    }
    @media (max-width: 768px) {
        .student_info_single {
            width: 100%;
        }

        .vertical_seperator {
            display: none !important;
        }

        .routine_wrapper {
            width: 100%;
        }

        .routine_wrapper_body {
            padding: 0;
        }

        .student_info_single {
            flex-wrap: wrap;
        }

        .download_print_btns {
            margin-top: 30px;
        }

        .routine_wrapper_header {
            padding: 20px 20px;
        }

        .routine_wrapper_header h3 {
            font-size: 24px;
        }
    }
</style>

@section('content')
    <div class="page-content">

        <div class="card ot-card mb-24" id="printableArea">

            <div class="routine_wrapper">
                <!-- routine_wrapper_header part here -->
                <div class="routine_wrapper_header">
                    <div class="routine_wrapper_header_logo">
                        <img class="header_logo" src="{{ @globalAsset(setting('light_logo'), '154X38.webp') }}"
                            alt="{{ __('light logo') }}">
                    </div>
                    <div class="vertical_seperator"></div>
                    <div class="routine_wrapper_header_content">
                        <h3>{{ setting('application_name') }}</h4>
                        <p>{{ setting('address') }}</p>
                    </div>
                </div>
                <div class="routine_wrapper_body">
                    <div class="student_info_wrapper">
                        @if (@$data->type)
                            <div class="student_info_single">
                                <span>{{___('online-examination.Exam Type')}} :</span>
                                <h5>{{ @$data->type->name }}</h5>
                            </div>
                        @endif
                        <div class="student_info_single">
                            <span>{{___('online-examination.Exam Name')}} :</span>
                            <h5>{{ @$data->name }}</h5>
                        </div>
                        @if (@$data->subject)
                            <div class="student_info_single">
                                <span>{{___('online-examination.Subject Name')}} :</span>
                                <h5>{{ @$data->subject->name }}</h5>
                            </div>
                            <div class="student_info_single">
                                <span>{{___('online-examination.Subject Code')}} :</span>
                                <h5>{{ @$data->subject->code }}</h5>
                            </div>
                        @endif
                        <div class="student_info_single">
                            <span>{{___('online-examination.Last')}} :</span>
                            <h5>
                                <span class="digital-clock text-danger">
                                    
                                </span>
                                <input type="hidden" id="end_time" value="{{@$data->end}}">    
                            </h5>
                        </div>
                        <div class="student_info_single">
                            <span>{{___('online-examination.Time')}} :</span>
                            <h5>
                                <span>
                                    <?php
                                        $startDate = new DateTime(@$data->start);
                                        $endDate = new DateTime(@$data->end);
                                        $interval = date_diff($startDate,$endDate);
                                        echo $interval->format('%d Day %h Hour %i Minute');
                                    ?>
                                </span>    
                            </h5>
                        </div>
                        
                    </div>
                    <!-- student_info_wrapper part end -->
                    <div class="markseet_title">
                        <h5>{{___('online-examination.Exam Question/Answer sheet')}}</h5>
                    </div>
                    <div class="table-responsive">
                        <div class="card p-4">
                            <div class="card-body">
                                <form class="confirmation" action="{{route('student-panel-online-examination.answer-submit')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="online_exam_id" value="{{@$data->id}}">
                                    @foreach (@$data->examQuestions as $key=>$item)
                                        <div class="py-2 d-flex justify-content-between">
                                            <h5 class="d-inline m-0">{{ ++$key }}. {{ $item->question->question }}</h5>
                                            <h5 class="d-inline m-0">{{ $item->question->mark }}</h5>
                                        </div>
                
                                        @if ($item->question->type == 1)
                
                                            @for($i = 0; $i < $item->question->total_option; $i++)
                                                <div class="form-check py-1">
                                                    <input class="form-check-input" type="radio" name="answer[{{$item->question->id}}]" id="item{{$key.''.$item->question->id.''.$i}}" value="{{++$i}}">
                                                    <label class="form-check-label ps-2 pe-5" for="item{{$key.''.$item->question->id.''.--$i}}">{{++$i}}. {{$item->question->questionOptions[--$i]->option}}</label>
                                                </div>
                                            @endfor
                
                                        @elseif ($item->question->type == 2)
                
                                            @for($i = 0; $i < $item->question->total_option; $i++)
                                                <div class="form-check py-1">
                                                    <input class="form-check-input" type="checkbox" name="answer[{{$item->question->id}}][{{$i}}]" id="item{{$key.''.$item->question->id.''.$i}}" value="{{++$i}}">
                                                    <label class="form-check-label ps-2 pe-5" for="item{{$key.''.$item->question->id.''.--$i}}">{{++$i}}. {{$item->question->questionOptions[--$i]->option}}</label>
                                                </div>
                                            @endfor
                
                                        @elseif($item->question->type == 3)
                
                                            <div class="form-check py-1">
                                                <input class="form-check-input" type="radio" name="answer[{{$item->question->id}}]" id="item{{$key.''.$item->question->id}}1" value="1">
                                                <label class="form-check-label ps-2 pe-5" for="item{{$key.''.$item->question->id}}1">{{ ___('online-examination.1') }}. {{ ___('online-examination.True') }}</label>
                                            </div>
                                            <div class="form-check py-1">
                                                <input class="form-check-input" type="radio" name="answer[{{$item->question->id}}]" id="item{{$key.''.$item->question->id}}0" value="0">
                                                <label class="form-check-label ps-2 pe-5" for="item{{$key.''.$item->question->id}}0">{{ ___('online-examination.2') }}. {{ ___('online-examination.False') }}</label>
                                            </div>
                
                                        @else
                                            <textarea class="m-0 form-control" name="answer[{{$item->question->id}}]" placeholder="Answer:"></textarea>
                                        @endif
                                    @endforeach
                
                                    <div class="col-md-12 mt-24">
                                        <div class="text-end">
                                            <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                                </span>{{ ___('common.submit') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="print_copyright_text d-flex">
                    <img src="{{ globalAsset(setting('favicon')) }}" alt="Icon">
                    <p>{{ setting('footer_text') }}</p>
                </div>
            </div>
        </div>
        
    </div>
@endsection














@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            clockUpdate();
            setInterval(clockUpdate, 1000);
        })

        var end = $('#end_time').val();
        var eh = parseInt(end.slice(11, 13));
        var em = parseInt(end.slice(14, 16));
        var es = parseInt(end.slice(17, 19));

        function clockUpdate() {
            var start_time = new Date();
            var end_time = $('#end_time').val();
            var diff =  new Date(end_time) - new Date( start_time);  

            var seconds = Math.floor(diff/1000);
            var minutes = Math.floor(seconds/60); 
            seconds = seconds % 60;
            var hours = Math.floor(minutes/60);
            minutes = minutes % 60;

            $('.digital-clock').text((hours < 10 ? '0' : '') + hours + " Hour " + (minutes < 10 ? '0' : '') + minutes + " Minute (" + (seconds < 10 ? '0' : '') + seconds+"s)")
        }
    </script>
@endpush