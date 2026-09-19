
<!DOCTYPE html>
<html>
<head>
    <title>Attendance</title>
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
.table{
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
    border-radius:  0 0 10px 10px;
}
.title{
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
                        <img class="header_logo" src="{{ @globalAsset(setting('light_logo'), '154X38.webp') }}" alt="{{ __('light logo') }}">
                    </div>
                    <div class="report_header_content">
                        <h3>{{ setting('application_name') }}</h4>
                        <p>{{ setting('address') }}</p>
                    </div>
                </div>

                <p class="title">{{___('common.Class (Section)')}} : <strong>{{ @$data['class_name'] }} ({{ @$data['section_name'] }})</p></strong>

                <div class="table-responsive">
                    @if ( @$data['request']->view == '0')
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="table_th">{{ ___('common.Name') }}</th>
                                    <th class="table_th">{{ ___('common.Roll') }}</th>
                                    <th class="table_th">{{ ___('common.Admission no') }}</th>
                                    @foreach ($data['days'] as $day => $date)
                                        <th class="table_th">{{ ++$day }}</th>
                                    @endforeach
                                    <th class="table_th text-success">{{ ___('common.P') }}</th>
                                    <th class="table_th text-warning">{{ ___('common.L') }}</th>
                                    <th class="table_th text-danger">{{ ___('common.A') }}</th>
                                    <th class="table_th text-primary">{{ ___('common.F') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$data['students'] as $item)
                                    <tr>
                                        <td class="table_td">{{ @$item->student->first_name }} {{ @$item->student->last_name }}</td>
                                        <td class="table_td">{{ @$item->roll }}</td>
                                        <td class="table_td">{{ @$item->student->admission_no }}</td>
                                        @php
                                            $p = 0; $l = 0; $a = 0; $f = 0;
                                        @endphp
                                        @foreach ($data['days'] as $day => $date)
                                        @php
                                            $i = ++$day;
                                        @endphp
                                            <td class="table_td">
                                                @foreach ($data['attendances'] as $item2)
                                                    @if ($item->student_id == $item2->student_id && (int)substr($item2->date, -2) == $i)
                                                        @if (@$item2->attendance == App\Enums\AttendanceType::PRESENT)
                                                            <span class="text-success">{{ ___('common.P') }}</span>
                                                            @php
                                                                ++$p
                                                            @endphp
                                                        @elseif(@$item2->attendance == App\Enums\AttendanceType::LATE)
                                                            <span class="text-warning">{{ ___('common.L') }}</span>
                                                            @php
                                                                ++$l
                                                            @endphp
                                                        @elseif(@$item2->attendance == App\Enums\AttendanceType::ABSENT)
                                                            <span class="text-danger">{{ ___('common.A') }}</span>
                                                            @php
                                                                ++$a
                                                            @endphp
                                                        @elseif(@$item2->attendance == App\Enums\AttendanceType::HALFDAY)
                                                            <span class="text-primary">{{ ___('common.F') }}</span>
                                                            @php
                                                                ++$f
                                                            @endphp
                                                        @else
                                                            <span>{{ ___('common.H') }}</span>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                        @endforeach
                                        <td class="table_td"><span class="text-success">{{ $p }}</span></td>
                                        <td class="table_td"><span class="text-warning">{{ $l }}</span></td>
                                        <td class="table_td"><span class="text-danger">{{ $a }}</span></td>
                                        <td class="table_td"><span class="text-primary">{{ $f }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <table class="table">
                            <thead class="thead">
                                <tr>
                                    <th class="table_th">{{ ___('common.student_name') }}</th>
                                    <th class="table_th">{{ ___('common.Roll') }}</th>
                                    <th class="table_th">{{ ___('common.Admission no') }}</th>
                                    <th class="table_th">{{ ___('common.Attendance') }}</th>
                                     <th class="table_th">{{ ___('common.Date') }}</th>
                                    <th class="table_th">{{ ___('common.Note') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach (@$data['students'] as $item)
                                <tr id="document-file">
                                    <td class="table_td">{{ @$item->student->first_name }} {{ @$item->student->last_name }}</td>
                                    <td class="table_td">{{ @$item->roll }}</td>
                                    <td class="table_td">{{ @$item->student->admission_no }}</td>
                                    <td class="table_td">
                                        @if (@$item->attendance == App\Enums\AttendanceType::PRESENT)
                                            <span class="badge-basic-success-text">{{ ___('common.Present') }}</span>
                                        @elseif(@$item->attendance == App\Enums\AttendanceType::LATE)
                                            <span class="badge-basic-warning-text">{{ ___('common.Late') }}</span>
                                        @elseif(@$item->attendance == App\Enums\AttendanceType::ABSENT)
                                            <span class="badge-basic-danger-text">{{ ___('common.Absent') }}</span>
                                        @elseif(@$item->attendance == App\Enums\AttendanceType::HALFDAY)
                                            <span class="badge-basic-primary-text">{{ ___('common.half_day') }}</span>
                                        @endif
                                    </td>
                                    <td class="table_td">{{ dateFormat(@$item->date) }}</td>
                                    <td class="table_td">
                                        {{ old('note',@$item->note) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
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
