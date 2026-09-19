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

    .border_table tbody tr:nth-of-type(odd) {
        background: #F0F3F5;
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
        border-right: 1px solid #EAEAEA;
        border-color: #EAEAEA !important;
        font-weight: 700;
        font-size: 16px;
        color: #1A1A21;
        padding: 19.75px 16px;
        text-align: left;
        white-space: nowrap;
        vertical-align: middle;
        border-top: 1px solid;
    }

    .border_table tbody tr td,
    .border_table tfoot tr td {
        border-bottom: 1px solid #EAEAEA;
        text-align: left;
        padding: 30.5px 16px;
        border-right: 1px solid #EAEAEA;
        font-weight: 500;
        font-size: 18px;
        line-height: 22px;
        color: #424242;
        white-space: nowrap;
    }

    .border_table tr:nth-of-type(n) {
        border: 1px solid #EAEAEA;
        border-top: 0;
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
        background: #6B6B6B !important;
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
        justify-content: center;
        grid-gap: 12px;
    }

    .student_info {
        display: flex;
        align-items: center;
        grid-gap: 16px;
    }

    .student_info img {
        border-radius: 4px;
        width: 24px;
        height: 24px;
    }

    .student_info h5 {
        font-weight: 500;
        font-size: 18px;
        line-height: 22px;
        color: #424242;
        margin: 0;
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

    .td-text-center {
        text-align: center !important;
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
                <h4 class="bradecrumb-title mb-1">{{ ___('settings.merit_list') }}</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">{{ ___('common.home') }}</a></li>
                        <li class="breadcrumb-item">{{ ___('settings.merit_list') }}</li>
                    </ol>
            </div>
        </div>
    </div>
    {{-- bradecrumb Area E n d --}}

    <div class="row">
        <div class="col-12">
            <form action="{{ route('merit-list.search') }}" method="post" id="merit_list" enctype="multipart/form-data">
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
                                        <option {{ old('class', @$data['request']->class) == $item->id ? 'selected' : '' }}
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
                                        <option {{ old('section', @$data['request']->section) == $item->section->id ? 'selected' : '' }}
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
                                <select
                                    class="nice-select niceSelect bordered_style wide exam_types @error('exam_type') is-invalid @enderror"
                                    name="exam_type">
                                    <option value="">{{ ___('examination.select_exam_type') }} *</option>
                                    @foreach ($data['exam_types'] as $item)
                                        <option {{ old('exam_type', @$data['request']->exam_type) == $item->id ? 'selected' : '' }}
                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('exam_type')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="single_large_selectBox">
                                <select
                                    class="shift nice-select niceSelect bordered_style wide"
                                    name="shift" id="validationServer04"
                                    aria-describedby="validationServer04Feedback">
                                    <option value="">{{ ___('student_info.select_shift') }}</option>
                                    @foreach ($data['shifts'] as $item)
                                        <option {{ old('shift', @$data['request']->shift) == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button class="btn btn-lg ot-btn-primary" type="submit">
                                {{___('common.Search')}}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @if (@$data['resultData'])
            <div class="col-lg-12">
                @if (count(@$data['resultData']) > 0)
                <div class="download_print_btns ">
                    <button class="btn btn-lg ot-btn-primary" onclick="printDiv('printableArea')">
                        {{___('common.print_now')}}
                        <span><i class="fa-solid fa-print"></i></span>
                    </button>
                    <a class="btn btn-lg ot-btn-primary" href="{{ route('report-merit-list.pdf-generate', ['type'=>$data['request']->exam_type, 'class'=>$data['request']->class, 'section'=>$data['request']->section ]) }}">
                        {{___('common.Pdf Preview')}}
                        <span><i class="fa-brands fa-dochub"></i></span>
                    </a>
                </div>
                @endif
                <div class="routine_wrapper" id="printableArea">
                    <!-- routine_wrapper_header part here -->
                    <div class="routine_wrapper_header">
                        <div class="routine_wrapper_header_logo">
                            <img class="header_logo" src="{{ @globalAsset(setting('light_logo'), '154X38.webp') }}" alt="{{ __('light logo') }}">
                        </div>
                        <div class="vertical_seperator"></div>
                        <div class="routine_wrapper_header_content">
                            <h3>{{ setting('application_name') }}</h4>
                            <p>{{ setting('address') }}</p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table border_table mb_30">
                            <thead>
                                <tr>
                                    <th>{{___('common.#')}}</th>
                                    <th>{{___('student_info.student_name')}}</th>
                                    <th>{{___('student_info.admission_no')}}</th>
                                    <th>{{___('academic.class')}} ({{___('academic.section')}})</th>
                                    <th>{{___('report.Position')}}</th>
                                    <th>{{___('report.Result')}}</th>
                                    <th>{{___('report.Point')}}</th>
                                    <th>{{___('report.Grade')}}</th>
                                    <th>{{___('report.total_mark')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data['resultData'] as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ @$item->student->first_name }} {{ @$item->student->last_name }}</td>
                                    <td>{{ @$item->student->admission_no }}</td>
                                    <td>{{ @$item->student->session_class_student->class->name }} ({{ @$item->student->session_class_student->section->name }})</td>
                                    <td>{{ @$key }}</td>
                                    <td>{{ @$item->result }}</td>
                                    <td>{{ @$item->grade_point }}</td>
                                    <td>{{ @$item->grade_name }}</td>
                                    <td>{{ @$item->total_marks }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="td-text-center">
                                          @include('backend.includes.no-data')
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!--  pagination start -->

                <div class="ot-pagination pagination-content d-flex justify-content-end align-content-center py-3">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-between">
                            {!!$data['resultData']->appends(\Request::capture()->except('page'))->links() !!}
                        </ul>
                    </nav>
                </div>

                <!--  pagination end -->

            </div>
        @endif
    </div>
</div>
@endsection
