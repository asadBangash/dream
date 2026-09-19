@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
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
                    <h4 class="bradecrumb-title mb-1">{{ @$data['title'] }}</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ ___('common.home') }}</a></li>
                            <li class="breadcrumb-item">{{ @$data['title'] }}</li>
                        </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="row">
            <div class="col-lg-12">
                
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
                                @if (@$data['exam']->type)
                                    <div class="student_info_single">
                                        <span>{{___('student_info.Exam Type')}} :</span>
                                        <h5>{{ @$data['exam']->type->name }}</h5>
                                    </div>
                                @endif
                                <div class="student_info_single">
                                    <span>{{___('report.exam_name')}} :</span>
                                    <h5>{{ @$data['exam']->name }}</h5>
                                </div>
                                @if (@$data['exam']->subject)
                                    <div class="student_info_single">
                                        <span>{{ ___('online-examination.Subject') }} :</span>
                                        <h5>{{ @$data['exam']->subject->name }}, {{ ___('online-examination.Code') }}: {{ @$data['exam']->subject->code }}</h5>
                                    </div>
                                @endif
                                <div class="student_info_single">
                                    <span>{{ ___('online-examination.Mark') }} :</span>
                                    <h5>{{@$data['exam']->total_mark}}</h5>
                                </div>
                            </div>
                            <!-- student_info_wrapper part end -->
                            <div class="markseet_title">
                                <h5>{{ @$data['title'] }}</h5>
                            </div>
                            @php
                                $answers = @$data['answer']->allAnswers->pluck('question_bank_id')->toArray();
                            @endphp
                            
                            <div class="table-content table-basic">
                                <div class="card">
                                    <div class="card-body">
                                        <form class="confirmation" action="{{route('online-exam.mark-submit')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="online_exam_id" value="{{@$data['exam']->id}}">
                                            <input type="hidden" name="student_id" value="{{$student_id}}">
                                            @foreach (@$data['exam']->examQuestions as $key=>$item)
                                                <input type="hidden" name="answer_ids[]" value="{{$data['answer']->allAnswers->where('question_bank_id', @$item->question->id)->first()?->id}}">
                                                
                                                <div class="py-2 d-flex justify-content-between">
                                                    <h5 class="d-inline m-0">{{ ++$key }}. {{ @$item->question->question }}</h5>
                                                    <div >
                                                        @php
                                                            $evaluationMark = optional(@$data['answer']->allAnswers->where('question_bank_id', @$item->question->id)->first())->evaluation_mark;
                                                            $isChecked = $evaluationMark !== null && $evaluationMark !== 0;
                                                            $key--;
                                                        @endphp

                                                        <input class="form-check-input mr-32 mark-checkbox-value" type="hidden" name="marks[{{ $key }}][]" value="" {{ $isChecked ? 'disabled' : '' }}>
                                                        @if (in_array(@$item->question->id, $answers))
                                                            <input class="form-check-input mr-32 mark-checkbox" type="checkbox" name="marks[{{ $key }}][]" value="{{ @$item->question->mark }}" {{ $isChecked ? 'checked' : '' }}>
                                                        @endif
                                                        <h5 class="d-inline m-0">{{ @$item->question->mark }}</h5>
                                                    </div>
                                                </div>
                                                
                                                @if (@$item->question->type == 1)

                                                    @for($i = 0; $i < @$item->question->total_option; $i++)
                                                        {{++$i}}. {{@$item->question->questionOptions[--$i]->option}} <br>
                                                    @endfor
                                                    @if (in_array(@$item->question->id, $answers))
                                                        <strong class="text-danger">{{ ___('online-examination.Answer') }}:</strong> {{ $data['answer']->allAnswers->where('question_bank_id', @$item->question->id)->first()->answer }}. 
                                                    @endif <br>
                                                    <strong class="text-success">{{ ___('online-examination.Correct Answer') }}:</strong> {{@$item->question->answer}}.

                                                @elseif (@$item->question->type == 2)

                                                    @for($i = 0; $i < @$item->question->total_option; $i++)
                                                        {{++$i}}. {{@$item->question->questionOptions[--$i]->option}} <br>
                                                    @endfor
                                                    @if (in_array(@$item->question->id, $answers))
                                                        <strong class="text-danger">{{ ___('online-examination.Answer') }}:</strong> 
                                                        @foreach ($data['answer']->allAnswers->where('question_bank_id', @$item->question->id)->first()->answer as $ans)
                                                            {{$ans}}.
                                                        @endforeach
                                                    @endif
                                                    <br>
                                                    <strong class="text-success">{{ ___('online-examination.Correct Answer') }}:</strong> 
                                                    @foreach (@$item->question->answer as $ans)
                                                        {{$ans}}.
                                                    @endforeach
                                                    
                                                @elseif(@$item->question->type == 3)

                                                    {{ ___('online-examination.1') }} {{ ___('online-examination.True') }} <br>
                                                    {{ ___('online-examination.2') }} {{ ___('online-examination.False') }} <br>
                                                    @if (in_array(@$item->question->id, $answers))
                                                    <strong class="text-danger">{{ ___('online-examination.Answer') }}:</strong> 
                                                        @if ((int)$data['answer']->allAnswers->where('question_bank_id', @$item->question->id)->first()->answer == 1)
                                                            {{ ___('online-examination.1') }}
                                                        @else
                                                            {{ ___('online-examination.2') }}
                                                        @endif
                                                    @endif
                                                    <br>
                                                    <strong class="text-success">{{ ___('online-examination.Correct Answer') }}:</strong> {{@$item->question->answer}}

                                                @else
                                                    
                                                    @if (in_array(@$item->question->id, $answers))
                                                        <strong class="text-danger">{{ ___('online-examination.Answer') }}:</strong> {{ $data['answer']->allAnswers->where('question_bank_id', @$item->question->id)->first()->answer}}
                                                    @endif
                                                
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
        </div>
    </div>
@endsection

