@extends('parent-panel.partials.master')

@section('title')
{{ ___('common.Class Routine') }}
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
        max-width: 100%;
        margin: auto;
        background: #fff;
        padding: 20px;
        border-radius: 5px;
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

    .routine_header {}

    .routine_header h3 {
        font-size: 24px;
        font-weight: 500;
    }

    .routine_header p {
        font-size: 14px;
        font-weight: 400;
        margin-bottom: 15px !important;
    }

    /* border_table  */
    .border_table {}

    .border_table thead {}

    .border_table thead tr th {
        padding: 5px;
        font-size: 12px;
        border-right: 1px solid #F0F3F5;
        border-color: #fff !important;
        font-weight: 700;
        font-size: 18px;
        color: #424242;
        padding: 32px 15px;
        text-align: center;
        background: #F0F3F5;
        white-space: nowrap
    }

    .border_table tbody tr td,
    .border_table tfoot tr td {
        border-bottom: 1px solid #F0F3F5;
        text-align: center;
        font-size: 12px;
        padding: 5px;
        border-right: 1px solid #F0F3F5;
    }

    .border_table tr:nth-of-type(n) {
        border: 0;
    }

    .border_table tbody tr th {
        background: #F0F3F5;
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
    }

    .classBox_wiz {
        min-height: 129px;
        vertical-align: middle;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 15px;
    }

    .classBox_wiz h5 {
        font-weight: 600;
        font-size: 18px;
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
        background: #392C7D !important;
        color: #FFFFFF !important;
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
        justify-content: start;
        grid-gap: 12px;
        background: #F3F3F3;
        padding: 20px;
        flex-wrap: wrap;
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

    .print_copyright_text {
        display: flex;
        align-items: center;
        padding-bottom: 10px;
    }

    .vertical_seperator {
        border-right: 1px solid #FFFFFF;
        height: 93px;
        margin: 0 30px 0 40px;
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

    <div class="col-md-12 p-0">
        <form action="{{ route('parent-panel-class-routine.search') }}" method="post" id="marksheed" enctype="multipart/form-data">
            @csrf
            <div class="card ot-card mb-24 position-relative z_1">
                <div class="card-header d-flex align-items-center gap-4 flex-wrap">
                    <h3 class="mb-0">{{ ___('common.Filtering') }}</h3>

                    <div class="card_header_right d-flex align-items-center gap-3 flex-fill justify-content-end flex-wrap">
                        <!-- table_searchBox -->

                        <div class="single_large_selectBox">
                            <select class="nice-select niceSelect bordered_style wide @error('student') is-invalid @enderror" name="student">
                                <option value="">{{ ___('student_info.select_student') }}</option>
                                @foreach ($data['students'] as $item)
                                <option {{ old('student', Session::get('student_id')) == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->first_name }} {{ $item->last_name }}
                                    @endforeach
                            </select>
                            @error('student')
                            <div id="validationServer04Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <button class="btn btn-lg ot-btn-primary" type="submit">
                            {{ ___('common.Search') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @if (@$data['result'])
        @if (@$data['result']->count() > 0)
            <div class="download_print_btns ">
                <button class="btn btn-lg ot-btn-primary" onclick="printDiv('printableArea')">
                    {{___('common.print_now')}}
                    <span><i class="fa-solid fa-print"></i></span>
                </button>
                <a class="btn btn-lg ot-btn-primary" href="{{ route('parent-panel-class-routine.pdf-generate', ['student' => @$data['request']->student]) }}">
                    {{___('common.pdf_download')}}
                    <span><i class="fa-brands fa-dochub"></i></span>
                </a>
            </div>
            <div class="routine_wrapper" id="printableArea">
                <!-- routine_wrapper_header part here -->
                <div class="routine_wrapper_header">
                    <div class="routine_wrapper_header_logo">
                        <img class="header_logo" src="{{ @globalAsset(setting('light_logo'), '154X38.webp') }}" alt="{{ __('light logo') }}">
                    </div>
                    <div class="vertical_seperator"></div>
                    <div class="routine_wrapper_header_content">
                        <h3>Class Routine</h3>
                        {{-- <p> Name: Abbdullah Noman <br> Class: 10 , Roll No : 23 , Group: Science</p> --}}
                    </div>
                </div>
                <!-- routine_print part end -->
                <div class="table-responsive">
                    <table class="table border_table mb_30">
                        <thead>
                            <tr>
                                <th class="marked_bg">Day/Time</th>
                                @foreach ($data['time'] as $item)
                                <th>{{ $item->timeSchedule->start_time }} - {{ $item->timeSchedule->end_time }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $n = 0;
                            @endphp
                            @foreach (\Config::get('site.days') as $key=>$item)
                            <tr>
                                <th>{{ ___($item) }}</th>
                                @if (isset($data['result'][$n]))
                                    @if ($data['result'][$n]->day == $key)
                                        @foreach ($data['time'] as $key=>$item0)
                                            <td>
                                                @foreach ($data['result'][$n]->classRoutineChildren as $item)
                                                    @if ($item->time_schedule_id == $item0->time_schedule_id)
                                                        <div class="classBox_wiz">
                                                            <h5>{{ $item->subject->name }}</h5>
                                                            <p>
                                                                @foreach ($data['result'][$n]->TeacherName->subjectTeacher as $item2)
                                                                @if ($item2->subject_id == $item->subject->id)
                                                                {{$item2->teacher->first_name}} {{$item2->teacher->last_name}}
                                                                @endif
                                                                @endforeach
                                                            </p>
                                                            <p>Room No: {{ $item->classRoom->room_no }}</p>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </td>
                                        @endforeach
                                    @php
                                    ++$n;
                                    @endphp
                                    @else
                                        @foreach ($data['time'] as $item)
                                            <td></td>
                                        @endforeach
                                    @endif
                                @else
                                    @foreach ($data['time'] as $item)
                                        <td></td>
                                    @endforeach
                                @endif
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
                <div class="print_copyright_text d-flex ">
                    <img src="{{ globalAsset(setting('favicon')) }}" alt="Icon">
                    <p>{{ setting('footer_text') }}</p>
                </div>
            </div>
        @else
            <div class="table-content table-basic">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ ___('settings.class_routine') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center gray-color">
                            <img src="{{ asset('images/no_data.svg') }}" alt="" class="mb-primary" width="100">
                            <p class="mb-0 text-center">{{ ___('common.no_data_available') }}</p>
                            <p class="mb-0 text-center text-secondary font-size-90">
                                {{ ___('common.please_add_new_entity_regarding_this_table') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
    
</div>
@endsection