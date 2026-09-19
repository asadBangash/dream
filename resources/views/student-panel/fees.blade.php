@extends('student-panel.partials.master')

@section('title')
{{ ___('common.Fees List') }}
@endsection

@section('content')
<div class="page-content">

    <!--  table content start -->
    <div class="table-content table-basic">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ ___('fees.fees_list') }}</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered class-table">
                        <thead class="thead">
                            <tr>
                                <th class="purchase">{{ ___('fees.group') }}</th>
                                <th class="purchase">{{ ___('fees.type') }}</th>
                                <th class="purchase">{{ ___('fees.due_date') }}</th>
                                <th class="purchase">{{ ___('fees.amount') }} ({{ Setting('currency_symbol')}}) + {{___('tax.Tax')}} + {{___('fees.Fine')}}</th>
                                <th class="purchase">{{ ___('fees.Sub total') }}</th>
                                <th class="purchase">{{ ___('common.status') }}</th>
                                <th class="purchase">{{ ___('fees.fine_type') }}</th>
                                <th class="purchase">{{ ___('fees.percentage') }}</th>
                                <th class="purchase">{{ ___('fees.fine_amount') }} ({{ Setting('currency_symbol') }})</th>
                                <th class="purchase">{{ ___('fees.payment_info') }}</th>
                                <th class="purchase">{{ ___('fees.Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">

                            @forelse (@$data['fees_assigned'] as $item)
                                <tr>
                                    <td>{{ @$item->feesMaster->group->name }}</td>
                                    <td>{{ @$item->feesMaster->type->name }}</td>
                                    <td>{{ dateFormat(@$item->feesMaster->due_date) }}</td>
                                    <td>{{ @$item->feesMaster->amount }}
                                        <span class="text-danger"> + {{ calculateTax(@$item->feesMaster->amount) }}</span>

                                        @if (date('Y-m-d') > $item->feesMaster->due_date && $item->fees_collect_count == 0)
                                            <span class="text-danger">+ {{ @$item->feesMaster->fine_amount }}</span>
                                        @elseif($item->fees_collect_count == 1 && $item->feesMaster->due_date < $item->feesCollect->date)
                                            <span class="text-danger">+ {{ @$item->feesMaster->fine_amount }}</span>
                                        @endif

                                    </td>
                                    <td>
                                        {{@$item->feesMaster->amount + calculateTax(@$item->feesMaster->amount)}}
                                    </td>
                                    <td>
                                        @if ($item->fees_collect_count)
                                            <span class="badge-basic-success-text">{{ ___('fees.Paid') }}</span>
                                        @else
                                            <span class="badge-basic-danger-text">{{ ___('fees.Unpaid') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (@$item->fine_type == 0)
                                            <span class="badge-basic-info-text">{{ ___('fees.none') }}</span>
                                        @elseif(@$item->fine_type == 1)
                                            <span class="badge-basic-info-text">{{ ___('fees.percentage') }}</span>
                                        @elseif(@$item->fine_type == 2)
                                            <span class="badge-basic-info-text">{{ ___('fees.fixed') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ @$item->feesMaster->percentage }}</td>
                                    <td>
                                        @if(date('Y-m-d') > @$item->feesMaster->due_date)
                                            {{ @$item->feesMaster->fine_amount }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    <td>
                                        @if (@$item->feesCollect)
                                            <b class="text-primary me-2">{{ @$item->feesCollect->payment_gateway }}</b>
                                            <b class="text-success">#{{ @$item->feesCollect->transaction_id }}</b>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$item->fees_collect_count)
                                            <a
                                                href="#"
                                                class="btn btn-sm ot-btn-primary px-3"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalCustomizeWidth"
                                                onclick="feePayByStudentModal(`{{ $item->id }}`)"
                                            >
                                                <span class="">{{ ___('fees.Pay') }}</span>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center gray-color">
                                        <img src="{{ asset('images/no_data.svg') }}" alt="" class="mb-primary" width="100">
                                        <p class="mb-0 text-center">{{ ___('common.no_data_available') }}</p>
                                        <p class="mb-0 text-center text-secondary font-size-90">
                                            {{ ___('common.please_add_new_entity_regarding_this_table') }}
                                        </p>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <!--  table end -->
                <!--  pagination start -->
                <div class="ot-pagination pagination-content d-flex justify-content-end align-content-center py-3">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-between">
                            {!!$data['fees_assigned']->appends(\Request::capture()->except('page'))->links() !!}
                        </ul>
                    </nav>
                </div>
                <!--  pagination end -->
            </div>
        </div>
    </div>
    <!--  table content end -->



    <div id="view-modal">
        <div class="modal fade" id="modalCustomizeWidth" tabindex="-1" aria-labelledby="modalWidth" aria-hidden="true">
            <div class="modal-dialog">
                {{-- CONTENT WILL BE LOAD HERE DYNAMICALLY --}}
            </div>
        </div>
    </div>
</div>
@endsection




@push('script')
    <script src="https://js.stripe.com/v3/"></script>
@endpush
