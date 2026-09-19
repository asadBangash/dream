<!DOCTYPE html>
<html>

<head>
    <title>Progress Card</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact !important;
        }

        .report {
            background: white;
        }

        .report_header {
            background: #392C7D;
            border-radius: 10px 10px 0 0;
            padding: 10px;
        }

        .report_header_logo {
            float: left;
            padding: 10px;
            border-right: #E6E6E6 3px solid;
            margin-right: 10px;
        }

        .report_header_logo img {
            height: 65px;
        }

        .report_header_content {
            color: white;
        }

        .report_header_content h3 {
            font-size: 24px;
            margin: 0;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            width: 100%;
        }

        .table_th {
            border-right: 0;
            border-color: transparent !important;
            text-align: left;
            background: #E6E6E6 !important;
            font-size: 16px;
            font-weight: 500;
            text-transform: capitalize;
            padding: 8px 4px;
        }

        .table_td {
            border-right: 0;
            border-color: transparent !important;
            text-align: left;
            font-size: 14px;
            padding: 8px 4px;
        }

        .table tr:nth-of-type(odd) {
            padding: 0;
            border-color: white;
            background: #F8F8F8;
        }

        .table tr:nth-of-type(even) {
            border: 0;
            border-color: white;
            background: #EFEFEF;
        }

        .footer {
            padding: 5px;
            text-align: center;
            background: #E6E6E6 !important;
            border-radius: 0 0 10px 10px;
        }

        .title {
            padding: 10px 0px;
            margin: 10px 0px;
            font-size: 16px;
            text-align: center;
            background: #E6E6E6;
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-lg-12">
            <div class="report">
                <div class="report_header">
                    <div class="report_header_logo">
                        <img class="header_logo" src="{{ @globalAsset(setting('light_logo'), '154X38.webp') }}"
                            alt="{{ __('light logo') }}">
                    </div>
                    <div class="report_header_content">
                        <h3>{{ setting('application_name') }}</h4>
                            <p>{{ setting('address') }}</p>
                    </div>
                </div>
                <p class="title">{{ ___('common.Name') }}: <strong>{{ @$data['student']->first_name }}
                        {{ @$data['student']->last_name }}</strong> {{ ___('common.Class(Section)') }}:
                    <strong>{{ @$data['student']->session_class_student->class->name }}
                        ({{ @$data['student']->session_class_student->section->name }})</strong>,
                    {{ ___('common.Roll No') }} :
                    <strong>{{ @$data['student']->session_class_student->roll }}</strong></p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="table_th">{{ ___('common.Subject Code') }}</th>
                                <th class="table_th">{{ ___('common.Subject Name') }}</th>
                                @foreach (@$data['exams'] as $item)
                                    <th class="table_th">{{ $item->exam_type->name }}
                                        <small>{{ ___('common.(Mark-Grade)') }}</small></th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (@$data['subjects'] as $item)
                                <tr>
                                    <td class="table_td">
                                        {{ $item->subject->code }}
                                    </td>
                                    <td class="table_td">
                                        {{ $item->subject->name }}
                                    </td>
                                    @foreach (@$data['exams'] as $key => $exam)
                                        <td class="table_td">
                                            @foreach ($data['marks_registers'][$key] as $result)
                                                @if ($result->subject_id == $item->subject->id)
                                                    @php
                                                        $n = 0;
                                                    @endphp
                                                    @foreach ($result->marksRegisterChilds as $mark)
                                                        @php
                                                            $n += $mark->mark;
                                                        @endphp
                                                    @endforeach
                                                    {{ $n }} - {{ markGrade($n) }}
                                                @endif
                                            @endforeach
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="title">{{ ___('common.Results') }}</p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="table_th">{{ ___('common.Exam Name') }}</th>
                                <th class="table_th">{{ ___('common.Result') }}</th>
                                <th class="table_th">{{ ___('common.GPA') }}</th>
                                <th class="table_th">{{ ___('common.Total Marks') }}</th>
                                <th class="table_th">{{ ___('common.Avg. Marks') }}</th>
                                <th class="table_th">{{ ___('common.Avg. Grade') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['exams'] as $key => $item)
                                <tr>
                                    <td class="table_td">{{ $item->exam_type->name }}</td>
                                    <td class="table_td">{{ $data['result'][$key] }}</td>
                                    <td class="table_td">
                                        {{ $data['result'][$key] == 'Failed' ? '0.00' : $data['gpa'][$key] }}</td>
                                    <td class="table_td">{{ $data['total_marks'][$key] }}</td>
                                    <td class="table_td">{{ substr($data['avg_marks'][$key], 0, 5) }}</td>
                                    <td class="table_td">
                                        {{ $data['result'][$key] == 'Failed' ? 'F' : markGrade((int) $data['avg_marks'][$key]) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="footer">
                    <img src="{{ globalAsset(setting('favicon')) }}" alt="Icon">
                    <p>{{ setting('footer_text') }}</p>
                </div>
            </div>


        </div>
    </div>
</body>

</html>
