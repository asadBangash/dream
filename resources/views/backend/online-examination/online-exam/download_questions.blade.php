
<!DOCTYPE html>
<html>
<head>
    <title>{{ ___('online-examination.Online Exam Question') }}</title>
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
    height: 45px;
}
.report_header_content {
    color: white;
}
.report_header_content h3 {
    font-size: 20px;
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
.markseet_title {
    text-align: center;
    font-size: 24px;
}
.markseet_text {
    text-align: center;
    font-size: 16px;
    padding-top: 1rem;
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
                        <h3>{{ setting('application_name') }}</h3>
                        <p>{{ setting('address') }}</p>
                    </div>
                </div>

                <div class="markseet_text">
                    {{ @$data->name }}<br>
                    @if (@$data->type)
                        {{ ___('online-examination.Type') }}: {{ @$data->type->name }}<br>
                    @endif
                    {{ ___('examination.class') }}: {{ @$data->class->name }}, {{ ___('examination.section') }}: {{ @$data->section->name }}<br>
                    @if (@$data->subject)
                        {{ ___('online-examination.Subject') }}: {{ @$data->subject->name }}, {{ ___('online-examination.Code') }}: {{ @$data->subject->code }} <br>
                    @endif
                    <div class="justify-content-between">
                        <span>{{ ___('online-examination.Mark') }}: {{@$data->total_mark}}</span>,
                        <span>{{ ___('online-examination.Time') }}: 
                        <small>
                            <?php
                                $startDate = new DateTime(@$data->start);
                                $endDate = new DateTime(@$data->end);
                                $interval = date_diff($startDate,$endDate);
                                echo $interval->format('%d Day %h Hour %i Minute');
                            ?>
                        </small></span>
                    </div>
                </div>
                <div class="markseet_title">
                    <h5>{{ ___('online-examination.Online Exam Question') }}</h5>
                </div>
                <div class="table-responsive">
                    <table>
                        @foreach (@$data->examQuestions as $key=>$item)
                            <tr>
                                <td><strong>{{ ++$key }}. {{ $item->question->question }}</strong></td>
                                <td style="text-align: end"><strong>{{ $item->question->mark }}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    @if ($item->question->type == 1)
            
                                        @for($i = 0; $i < $item->question->total_option; $i++)
                                            {{++$i}}. {{$item->question->questionOptions[--$i]->option}} <br>
                                        @endfor
            
                                    @elseif ($item->question->type == 2)
            
                                        @for($i = 0; $i < $item->question->total_option; $i++)
                                            {{++$i}}. {{$item->question->questionOptions[--$i]->option}} <br>
                                        @endfor 
            
                                    @elseif($item->question->type == 3)
            
                                        {{ ___('online-examination.1') }}. {{ ___('online-examination.True') }} <br>
                                        {{ ___('online-examination.2') }}. {{ ___('online-examination.False') }}
            
                                    @endif
                                </td>
                            </tr>
                        @endforeach
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













