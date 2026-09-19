@extends('student-panel.partials.master')

@section('title')
{{ ___('online-examination.online_examination') }}
@endsection

@section('content')
<div class="page-content">

    <!--  table content start -->
    <div class="table-content table-basic">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ ___('online-examination.online_examination') }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered class-table">
                        <thead class="thead">
                            <tr>
                                <th class="serial">{{ ___('common.sr_no') }}</th>
                                <th class="purchase">{{ ___('examination.subject') }}</th>
                                <th class="purchase">{{ ___('common.name') }}</th>
                                <th class="purchase">{{ ___('online-examination.Type') }}</th>
                                <th class="purchase">{{ ___('online-examination.Total Mark') }}</th>
                                <th class="purchase">{{ ___('online-examination.Result') }}</th>
                                <th class="purchase">{{ ___('online-examination.Exam Start') }}</th>
                                <th class="purchase">{{ ___('online-examination.Exam End') }}</th>
                                <th class="purchase">{{ ___('online-examination.Duration') }}</th>
                                <th class="purchase">{{ ___('common.status') }}</th>
                                <th class="action">{{ ___('common.action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            @forelse ($data['exams'] as $key => $row)
                                <tr id="row_{{ @$row->id }}">
                                    <td class="serial">{{ ++$key }}</td>

                                    <td>{{ @$row->onlineExam->subject->name }}</td>

                                    <td>{{ @$row->onlineExam->name }}</td>
                                    <td>{{ @$row->onlineExam->type->name }}</td>
                                    <td>{{ @$row->onlineExam->total_mark }}</td>
                                    <td>{{ @$row->onlineExam->studentAnswer->where('student_id', $data['student'])->first()->result ?? '' }}</td>
                                    <td>{{ date('d-m-Y H:i a', strtotime(@$row->onlineExam->start)) }}</td>
                                    <td>{{ date('d-m-Y H:i a', strtotime(@$row->onlineExam->end)) }}</td>
                                    <td>
                                        <?php
                                            $startDate = new DateTime(@$row->onlineExam->start);
                                            $endDate = new DateTime(@$row->onlineExam->end);
                                            $interval = date_diff($startDate,$endDate);
                                            echo $interval->format('%h Hour %i Minutes');
                                        ?>
                                    </td>
                                    <td>
                                        @if (in_array($data['student'], @$row->onlineExam->studentAnswer->pluck('student_id')->toArray()))
                                            <span class="badge-basic-success-text">{{ ___('online-examination.Submitted') }}</span>
                                        @else
                                            <span class="badge-basic-danger-text">{{ ___('online-examination.Pending') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!in_array($data['student'], @$row->onlineExam->studentAnswer->pluck('student_id')->toArray()))
                                            @php
                                                $currentTime = now()->format('Y-m-d H:i:s');
                                            @endphp
                                            @if (@$row->onlineExam->start <= $currentTime && $currentTime <= @$row->onlineExam->end)
                                                <a class="dropdown-item text-success" href="{{ route('student-panel-online-examination.view', @$row->onlineExam->id) }}"><span class="icon mr-8"><i class="fa-solid fa-eye"></i></span>{{ ___('online-examination.Start Now') }}</a>
                                            @else
                                                {{ ___('online-examination.Coming soon...') }}
                                            @endif
                                        @endif
                                        @if (optional(@$row->onlineExam->studentAnswer->where('student_id', $data['student'])->first())->result !== null)
                                            <a class="dropdown-item" href="{{ route('student-panel-online-examination.result-view', @$row->onlineExam->id) }}"><span class="icon mr-8"><i class="fa-solid fa-eye"></i></span>{{ ___('online-examination.view') }}</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center gray-color">
                                        <img src="{{ asset('images/no_data.svg') }}" alt="" class="mb-primary" width="100">
                                        <p class="mb-0 text-center">{{ ___('common.no_data_available') }}</p>
                                        <p class="mb-0 text-center text-secondary font-size-90"></p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!--  table end -->
                <!--  pagination start -->


                <!--  pagination end -->
            </div>
        </div>
    </div>
    <!--  table content end -->

</div>
@endsection