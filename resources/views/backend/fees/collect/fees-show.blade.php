<div class="modal-content" id="modalWidth">
    <div class="modal-header modal-header-image">
        <h5 class="modal-title" id="modalLabel2">
            {{ ___('fees.fees_collect') }}
        </h5>
        <button type="button" class="m-0 btn-close d-flex justify-content-center align-items-center"
            data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times text-white" aria-hidden="true"></i></button>
    </div>
    <form action="{{ route('fees-collect.store') }}" enctype="multipart/form-data" method="post" id="visitForm">
        @csrf
        <input type="hidden" name="student_id" value="{{$data['student_id']}}" />
    <div class="modal-body p-5">

        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="exampleDataList" class="form-label ">{{ ___('fees.due_date') }} <span
                                class="fillable">*</span></label>
                        <input class="form-control ot-input @error('date') is-invalid @enderror" name="date"
                            list="datalistOptions" id="exampleDataList" type="date"
                            placeholder="{{ ___('fees.enter_date') }}" value="{{ old('date') }}" required>
                        @error('date')
                            <div id="validationServer04Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ ___('fees.payment_method') }} <span class="fillable">*</span></label>
                        <div class="input-check-radio academic-section @error('payment_method') is-invalid @enderror">
                        @foreach (\Config::get('site.payment_methods') as $key=>$item)

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" {{$key == 1 ? 'checked':''}} value="{{$key}}" id="flexCheckDefault{{$key}}" />
                                <label class="form-check-label ps-2 pe-5" for="flexCheckDefault{{$key}}">{{ ___($item) }}</label>
                            </div>
                        @endforeach
                    </div>

                </div>

                    @if($data['is_siblings_discount'])
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="">Siblings discount ({{ $data['siblings_discount_name'] }})</label>
{{--                                Siblings discount (first sibling - 10%)--}}
                                <span class="text-success"></span>
                            </div>

                            <div class="col-md-3">
                                <div class="d-flex align-items-center gap-2">
                                    <input type="number" class="form-control ot-input me-2" name="discount_amount_value" value="{{ @$data['siblings_discount_percentage']??'' }}">
                                    <button class="btn ot-btn-success" type="button" id="applyDiscount">
                                        {{ ___('common.apply') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif


                    {{--                    <div class="row">--}}
{{--                        <div class="col-md-3 mb-3">--}}
{{--                            <label for="discountType" class="form-label">Discount Type</label>--}}
{{--                            <select class="form-select" id="discountType" name="discount_type" aria-label="Default select example">--}}
{{--                                <option value="" selected disabled>Select Type</option>--}}
{{--                                <option value="percentage">Percentage</option>--}}
{{--                                <option value="fixed">Fixed</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}

{{--                        <div class="col-md-3 mb-3" id="discountAmountGroup">--}}
{{--                            <label for="discountAmount" class="form-label">Discount Amount</label>--}}
{{--                            <input type="number" class="form-control" id="discountAmount" name="discount_amount" placeholder="Enter discount amount">--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    @if(($data['early_payment_discount_percentage'] ?? 0) > 0)
                        <div class="text-center">
{{--                            Early payment discount (super early-10%)  --}}
                        <span class="text-success">{{$data['early_payment_discount_percentage']}}% {{___('fees.discount for '). $data['discount_name'].(' discount applied')}}</span>
                        </div>
                    @endif
                </div>
        </div>
        </div>
        <div class="table-responsive table_height_450 niceScroll">
            <table class="table table-bordered role-table" id="students_table">
                <thead class="thead">
                    <tr>
                        <th class="purchase">{{ ___('fees.group') }}</th>
                        <th class="purchase">{{ ___('fees.type') }}</th>
                        <th class="purchase">{{ ___('fees.due_date') }}</th>
                        <th class="purchase">{{ ___('fees.amount') }} ({{ Setting('currency_symbol') }})</th>
                        <th class="purchase">{{ ___('fees.Discount') }} ({{ Setting('currency_symbol') }})</th>
                        @if(($data['early_payment_discount_percentage'] ?? 0) > 0)
                            <th class="purchase">{{ ucfirst($data['discount_name']) }} ({{ Setting('currency_symbol') }})</th>
                        @endif
                        <th class="purchase">{{ ___('tax.Tax') }} ({{ Setting('currency_symbol') }})</th>
                    </tr>
                </thead>
                <tbody class="tbody">
                    @php
                        $total = 0;
                    @endphp
                    @foreach (@$data['fees_assign_children'] as $item)


                    @if($item->fees_collect_count == 0)
                    @php
                        $earlyPaymentDiscount =  calculateDiscount(@$item->feesMaster->amount, $data['early_payment_discount_percentage']?? 0);
                        $siblingsDiscount = calculateDiscount(@$item->feesMaster->amount, $data['siblings_discount_percentage']);
                        $fineAmount = 0;
                        $totalAddition = 0;
                        $totalDeduction = 0;
                        $taxAmount = calculateTax($item->feesMaster->amount);
                        if(date('Y-m-d') > $item->feesMaster->date) {
                            $fineAmount = @$item->feesMaster->fine_amount;
                        }

                        $totalAddition += $fineAmount + $taxAmount;
                        $totalDeduction += $earlyPaymentDiscount + $siblingsDiscount;
                        $total += (@$item->feesMaster->amount + $totalAddition) - $totalDeduction;

                    @endphp
                    <input type="hidden" name="fees_assign_childrens[]" value="{{$item->id}}">
                    <input type="hidden" name="amounts[]" value="{{$item->feesMaster->amount}}">
                    <input type="hidden" name="early_payment_percentage" value="{{$data['early_payment_discount_percentage']?? 0}}">
                    @if(date('Y-m-d') > $item->feesMaster->date)
                        <input type="hidden" name="fine_amounts[]" value="{{$item->feesMaster->fine_amount}}">
                    @else
                        <input type="hidden" name="fine_amounts[]" value="0">
                    @endif
                    <tr
                        data-amount="{{ @$item->feesMaster->amount }}"
                        data-fine="{{ date('Y-m-d') > $item->feesMaster->date ? @$item->feesMaster->fine_amount : 0 }}"
                        data-tax="{{ calculateTax(@$item->feesMaster->amount) }}"
                    >
                        <td>{{ @$item->feesMaster->group->name }}</td>
                        <td>{{ @$item->feesMaster->type->name }}</td>
                        <td>{{ dateFormat(@$item->feesMaster->date) }}</td>
                        <td>
                            {{ @$item->feesMaster->amount }}
                            @if(date('Y-m-d') > $item->feesMaster->date)
                                <span class="text-danger">+ {{ @$item->feesMaster->fine_amount }}</span>
                            @endif
                        </td>
                        <td class="discount-cell">{{$data['discount_amount']}}</td>
                        @if(($data['early_payment_discount_percentage'] ?? 0) > 0)
                            <td>{{ $earlyPaymentDiscount }}</td>
                        @endif
                        <td>{{ calculateTax(@$item->feesMaster->amount) }}</td>
                    </tr>

                    @endif
                    @endforeach

                    <tr>
                        <td></td>
                        <td></td>
                        <td><strong>{{ ___('common.total payable') }}</strong></td>
                        <td id="totalPayable">{{ @$total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary py-2 px-4"
            data-bs-dismiss="modal">{{ ___('ui_element.cancel') }}</button>
            @if($total != 0)
        <button type="submit" class="btn ot-btn-primary"
            >{{ ___('ui_element.confirm') }}</button>
            @endif
    </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#applyDiscount').on('click', function () {
        let userDiscountPercentage = parseFloat($('input[name="discount_amount_value"]').val()) || 0;
        let earlyDiscountPercentage = parseFloat($('input[name="early_payment_percentage"]').val()) || 0;

        let total = 0;

        $('#students_table tbody tr').each(function () {
            let $row = $(this);

            let baseAmount = parseFloat($row.data('amount')) || 0;
            let fineAmount = parseFloat($row.data('fine')) || 0;
            let taxAmount = parseFloat($row.data('tax')) || 0;

            let subtotal = baseAmount + fineAmount;

            let earlyDiscountAmount = (subtotal * earlyDiscountPercentage) / 100;
            let userDiscountAmount = (subtotal * userDiscountPercentage) / 100;

            let finalAmount = subtotal - earlyDiscountAmount - userDiscountAmount;

            let rowTotal = finalAmount + taxAmount;
            total += rowTotal;

            $row.find('.discount-cell').text(userDiscountAmount.toFixed(2));
        });

        $('#totalPayable').text(total.toFixed(2));
    });


</script>

