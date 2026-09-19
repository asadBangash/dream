@extends('mainapp::layouts.backend.master')

@section('title')
{{ ___('mainapp_dashboard.Dashboard') }}
@endsection

@section('content')
<div class="page-content">

    <div class="row">
        <div class="col-xl-3 col-lg-3 col-md-6">
            <div class="ot_crm_summeryBox d-flex align-items-center mb-24">
                <div class="icon">
                    <img class="img-fluid" src="{{ asset('backend/assets/images/dashboard/school.svg') }}" alt="crm_summery1">
                </div>
                <div class="summeryContent">
                    <h4>{{ ___('mainapp_dashboard.Total School') }}</h4>
                    <h1>{{ $data['totalSchool'] }}</h1>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6">
            <div class="ot_crm_summeryBox d-flex align-items-center mb-24">
                <div class="icon">
                    <img class="img-fluid" src="{{ asset('backend/assets/images/dashboard/feature.svg') }}" alt="crm_summery1">
                </div>
                <div class="summeryContent">
                    <h4>{{ ___('mainapp_dashboard.Total Feature') }}</h4>
                    <h1>{{ $data['totalFeature'] }}</h1>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6">
            <div class="ot_crm_summeryBox d-flex align-items-center mb-24">
                <div class="icon">
                    <img class="img-fluid" src="{{ asset('backend/assets/images/dashboard/package.svg') }}" alt="crm_summery1">
                </div>
                <div class="summeryContent">
                    <h4>{{ ___('mainapp_dashboard.Total Package') }}</h4>
                    <h1>{{ $data['totalPackage'] }}</h1>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-6">
            <div class="ot_crm_summeryBox d-flex align-items-center mb-24">
                <div class="icon">
                    <img class="img-fluid" src="{{ asset('backend/assets/images/dashboard/faq.svg') }}" alt="crm_summery1">
                </div>
                <div class="summeryContent">
                    <h4>{{ ___('mainapp_dashboard.Total FAQ') }}</h4>
                    <h1>{{ $data['totalFAQ'] }}</h1>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="ot_crm_summeryBox mb-24">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{___('mainapp_dashboard.Revenue')}}</h4>
                </div>
                <div id="barchart"></div>
             </div>
        </div>
        <div class="col-xl-4">
            <div class="ot_crm_summeryBox mb-24">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{___('mainapp_dashboard.Schools')}} </h4>
                </div>
                <div id="admission"></div>
             </div>
        </div>
    </div>


</div>

<input type="hidden" id="active-school" value="{{$data['activeSchools']}}">
<input type="hidden" id="inactive-school" value="{{$data['inactiveSchools']}}">


@endsection

@push('script')
<script>
    $(document).ready(function() {


        /* Chart Bar start */

        var optionsBar1 = {
            chart: {
                height: 380,
                width: "100%",
                type: "bar"
            },
            plotOptions: {
                bar: {
                    columnWidth: "20%",
                    horizontal: false,
                    borderRadius: 4,
                },
            },
            series: [
                {
                    name: "Earning",
                    data: [ <?php echo implode(', ', $data['incomes']); ?> ]
                    ,
                }
            ],
            stroke: {
                show: false,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: [ <?php echo implode(', ', $data['months']); ?> ],
            },

            grid: {
                borderColor: '#EFEFEF',
                xaxis: {
                    lines: {
                        show: false
                    }
                },
            },

            fill: {
                opacity: 1,
                colors: ['#5669FF']
            },
        };
        if($("#barchart").length){
            var chartBar = new ApexCharts(document.querySelector("#barchart"), optionsBar1);
        chartBar.render();
        }
    });
</script>
@endpush
