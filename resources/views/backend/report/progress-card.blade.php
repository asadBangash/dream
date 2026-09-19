@extends('backend.master')

@section('title')
    {{ ___('common.Online Class Routine 2023') }}
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
        max-width: 900px;
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
        {{-- bradecrumb Area S t a r t --}}
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="bradecrumb-title mb-1">{{ ___('settings.progress_card') }}</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ ___('common.home') }}</a></li>
                            <li class="breadcrumb-item">{{ ___('settings.progress_card') }}</li>
                        </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="row">
            <div class="col-12">
                <form action="{{ route('report-progress-card.search') }}" method="post" id="marksheet" enctype="multipart/form-data">
                    @csrf
                    <div class="card ot-card mb-24 position-relative z_1">
                        <div class="card-header d-flex align-items-center gap-4 flex-wrap">
                            <h3 class="mb-0">{{ ___('common.Filtering') }}</h3>
                            
                            <div
                                class="card_header_right d-flex align-items-center gap-3 flex-fill justify-content-end flex-wrap">
                                <!-- table_searchBox -->

                                <div class="single_large_selectBox">
                                    <select id="getSections" class="class nice-select niceSelect bordered_style wide @error('class') is-invalid @enderror"
                                        name="class">
                                        <option value="">{{ ___('student_info.select_class') }} *</option>
                                        @foreach ($data['classes'] as $item)
                                            <option {{ old('class', @$data['student']->session_class_student->class->id) == $item->id ? 'selected' : '' }}
                                                value="{{ $item->class->id }}">{{ $item->class->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('class')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="single_large_selectBox">
                                    <select class="sections section nice-select niceSelect bordered_style wide @error('section') is-invalid @enderror"
                                        name="section">
                                        <option value="">{{ ___('student_info.select_section') }} *</option>
                                        @foreach ($data['sections'] as $item)
                                            <option {{ old('section', @$data['student']->session_class_student->section->id) == $item->section->id ? 'selected' : '' }}
                                                value="{{ $item->section->id }}">{{ $item->section->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('section')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="single_large_selectBox">
                                    <select class="students nice-select niceSelect bordered_style wide @error('student') is-invalid @enderror"
                                        name="student">
                                        <option value="">{{ ___('student_info.select_student') }} *</option>
                                        @foreach ($data['students'] as $item)
                                            <option {{ old('student', @$data['student']->id) == $item->student_id ? 'selected' : '' }}
                                                value="{{ $item->student_id }}">{{ $item->student->first_name }} {{ $item->student->last_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('student')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button class="btn btn-lg ot-btn-primary" type="submit">
                                    {{___('common.Search')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @if (@$data['marks_registers'])
                <div class="col-lg-12">
                    <div class="download_print_btns ">
                        <button class="btn btn-lg ot-btn-primary" onclick="printDiv('printableArea')">
                            {{___('common.print_now')}}
                            <span><i class="fa-solid fa-print"></i></span>
                        </button>
                        <a class="btn btn-lg ot-btn-primary" href="{{ route('report-progress-card.pdf-generate', ['class'=>$data['request']->class, 'section'=>$data['request']->section, 'student'=>$data['request']->student ]) }}">
                            {{___('common.Pdf Preview')}}
                            <span><i class="fa-brands fa-dochub"></i></span>
                        </a>
                    </div>
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
                                    <h3>{{___('common.Progress Card Report')}}</h3>
                                    <p>{{___('common.Name')}}: {{ @$data['student']->first_name }} {{ @$data['student']->last_name }}
                                    <br> {{___('common.Class(Section)')}}: {{ @$data['student']->session_class_student->class->name }}
                                    ({{ @$data['student']->session_class_student->section->name }}) , {{___('common.Roll No')}} : {{@$data['student']->session_class_student->roll}}</p>
                                </div>
                            </div>
                            <div class="routine_wrapper_body">
                                <!-- student_info_wrapper part end -->
                                <div class="markseet_title">
                                    <h5>{{___('report.grade_sheet')}}</h5>
                                </div>
                                <div class="table-responsive">
                                    <table class="table border_table mb-0">
                                        <thead>
                                            <tr>
                                                <th class="marked_bg">{{___('report.subject_code')}}</th>
                                                <th class="marked_bg">{{___('report.subject_name')}}</th>
                                                @foreach (@$data['exams'] as $item)
                                                    <th class="marked_bg">{{$item->exam_type->name}} <small>{{___('report.mark_grade')}}</small></th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (@$data['subjects'] as $item)
                                                <tr>
                                                    <td>
                                                        <div class="classBox_wiz">
                                                            <h5>{{ $item->subject->code }}</h5>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="classBox_wiz">
                                                            <h5>{{ $item->subject->name }}</h5>
                                                        </div>
                                                    </td>
                                                    @foreach (@$data['exams'] as $key=>$exam)
                                                        <td>
                                                            @foreach ($data['marks_registers'][$key] as $result)
                                                                @if ($result->subject_id == $item->subject->id)
                                                                    <div class="classBox_wiz">
                                                                        @php
                                                                            $n = 0;
                                                                        @endphp
                                                                        @foreach ($result->marksRegisterChilds as $mark)
                                                                                @php
                                                                                    $n += $mark->mark;
                                                                                @endphp
                                                                        @endforeach
                                                                        <h5>{{$n}} - {{ markGrade($n) }}</h5>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <table class="table border_table mt-5">
                                    <thead>
                                        <tr>
                                            <th>{{___('report.exam_name')}}</th>
                                            <th>{{___('report.Result')}}</th>
                                            <th>{{___('report.GPA')}}</th>
                                            <th>{{___('report.total_mark')}}</th>
                                            <th>{{___('report.avg_marks')}}</th>
                                            <th>{{___('report.avg_grade')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['exams'] as $key=>$item)
                                            <tr>
                                                <td>{{ $item->exam_type->name }}</td>
                                                <td>{{ $data['result'][$key] }}</td>
                                                <td>{{ $data['result'][$key] == 'Failed' ? '0.00' : $data['gpa'][$key] }}</td>
                                                <td>{{ $data['total_marks'][$key] }}</td>
                                                <td>{{ substr($data['avg_marks'][$key],0,5) }}</td>
                                                <td>{{ $data['result'][$key] == 'Failed' ? 'F' : markGrade((int)$data['avg_marks'][$key]) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="print_copyright_text d-flex">
                                <img src="{{ globalAsset(setting('favicon')) }}" alt="Icon">
                                <p>{{ setting('footer_text') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
