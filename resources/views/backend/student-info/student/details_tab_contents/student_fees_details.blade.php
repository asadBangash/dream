<div class="p-3">
    <div class="row g-4">
        <!-- Overview Section -->
        <div class="col-12">
            <div class="card border shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">{{ ___('student.Fees Overview') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        @php $currency = setting('currency_symbol'); @endphp

                        <div class="col-md-2 col-6 mb-3">
                            <div class="fw-bold text-muted">{{ ___('student.Total Fees') }}</div>
                            <div class="h6">{{ $currency }} {{ @$data->feesMasters->sum('amount') }}</div>
                        </div>

                        <div class="col-md-2 col-6 mb-3">
                            <div class="fw-bold text-muted">{{ ___('student.Total Paid') }}</div>
                            <div class="h6">{{ $currency }} {{ @$data->feesPayments->sum('amount') }}</div>
                        </div>

                        <div class="col-md-2 col-6 mb-3">
                            <div class="fw-bold text-muted">{{ ___('student.Total Due') }}</div>
                            <div class="h6 text-danger">{{ $currency }} {{ $fees['fees_due'] }}</div>
                        </div>

                        <div class="col-md-2 col-6 mb-3">
                            <div class="fw-bold text-muted">{{ ___('student.Total Discount') }}</div>
                            <div class="h6 text-success">{{ $currency }} {{ @$fees['fees_discounts']->sum('discount_amount') }}</div>
                        </div>

                        <div class="col-md-2 col-6 mb-3">
                            <div class="fw-bold text-muted">{{ ___('student.Total Fine') }}</div>
                            <div class="h6 text-warning">{{ $currency }} {{ @$data->feesMasters->sum('fine_amount') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="col-12">
            <div class="card border shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ ___('fees.fees_details') }}</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="students_table">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th>{{ ___('common.Si') }}</th>
                                <th>{{ ___('fees.group') }}</th>
                                <th>{{ ___('fees.type') }}</th>
                                <th>{{ ___('fees.due_date') }}</th>
                                <th>{{ ___('fees.amount') }} ({{ $currency }})</th>
                                <th>{{ ___('fees.Discount') }} ({{ $currency }})</th>
                                <th>{{ ___('tax.Tax') }} ({{ $currency }})</th>
                                <th>{{ ___('fees.Payable') }} ({{ $currency }})</th>
                                <th>{{ ___('common.status') }}</th>
                                <th>{{ ___('fees.fine_type') }}</th>
                                <th>{{ ___('fees.percentage') }}</th>
                                <th>{{ ___('fees.Fine') }} ({{ $currency }})</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (@$fees['fees_assigned'] ?? [] as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ @$item->feesMaster->group->name }}</td>
                                    <td>{{ @$item->feesMaster->type->name }}</td>
                                    <td>{{ dateFormat(@$item->feesMaster->due_date) }}</td>
                                    <td>
                                        {{ @$item->feesMaster->amount }}
                                        @if (date('Y-m-d') > $item->feesMaster->date && $item->fees_collect_count == 0)
                                            <span class="text-danger">+{{ @$item->feesMaster->fine_amount }}</span>
                                        @elseif($item->fees_collect_count == 1 && $item->feesMaster->date < $item->feesCollect->date)
                                            <span class="text-danger">+{{ @$item->feesMaster->fine_amount }}</span>
                                        @endif
                                    </td>
                                    <td>{{ calculateDiscount(@$item->feesMaster->amount, @$item->feesDiscount->discount_percentage) }}</td>
                                    <td>{{ calculateTax(@$item->feesMaster->amount) }}</td>
                                    <td>
                                        {{ @$item->feesMaster->amount + calculateTax(@$item->feesMaster->amount) - calculateDiscount(@$item->feesMaster->amount, @$item->feesDiscount->discount_percentage) }}
                                    </td>
                                    <td>
                                        @if ($item->fees_collect_count)
                                            <span class="badge bg-success">{{ ___('fees.Paid') }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ ___('fees.Unpaid') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (@$item->fine_type == 0)
                                            <span class="badge bg-info">{{ ___('fees.none') }}</span>
                                        @elseif(@$item->fine_type == 1)
                                            <span class="badge bg-warning">{{ ___('fees.percentage') }}</span>
                                        @elseif(@$item->fine_type == 2)
                                            <span class="badge bg-warning">{{ ___('fees.fixed') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ @$item->feesMaster->percentage }}</td>
                                    <td>
                                        @if (date('Y-m-d') > @$item->feesMaster->due_date)
                                            {{ @$item->feesMaster->fine_amount }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Placeholder -->
        <div id="view-modal">
            <div class="modal fade" id="modalCustomizeWidth" tabindex="-1" aria-labelledby="modalWidth" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    {{-- Modal content will be injected dynamically --}}
                </div>
            </div>
        </div>
    </div>
</div>
