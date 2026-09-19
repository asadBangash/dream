
<!DOCTYPE html>
<html>
<head>
    <title>Marksheet</title>
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
                @if ($data['result'])
                    <p class="title">{{___('common.Class (Section)')}} : <strong>{{$data['result'][0]->student->session_class_student->class->name}} ({{$data['result'][0]->student->session_class_student->section->name}})</p></strong>
                @endif
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="table_th">{{___('common.#')}}</th>
                                <th class="table_th">{{___('common.Name')}}</th>
                                <th class="table_th">{{___('common.Admission No')}}</th>
                                <th class="table_th">{{___('common.Fees type')}}</th>
                                <th class="table_th">{{___('common.Amount')}} ({{ Setting('currency_symbol') }})</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['result'] as $key=>$item)
                            <tr>
                                <td class="table_td">{{ ++$key }}</td>
                                <td class="table_td">{{ $item->student->first_name }} {{ $item->student->last_name }}</td>
                                <td class="table_td">{{ $item->student->admission_no }}</td>
                                <td class="table_td">{{ $item->feesMaster->type->name }}</td>
                                <td class="table_td">
                                    {{ @$item->feesMaster->amount }}

                                    @if (date('Y-m-d') > $item->feesMaster->date && $item->fees_collect_count == 0)
                                        <span class="text-danger">+ {{ @$item->feesMaster->fine_amount }}</span>
                                    @elseif($item->fees_collect_count == 1 && $item->feesMaster->date < $item->feesCollect->date)
                                        <span class="text-danger">+ {{ @$item->feesMaster->fine_amount }}</span>
                                    @endif
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
