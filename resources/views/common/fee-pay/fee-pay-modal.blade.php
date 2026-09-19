@include('common.fee-pay.fee-pay-style')

<div class="modal-content" id="modalWidth">
    <div class="modal-header modal-header-image">
        <h5 class="modal-title" id="modalLabel2">
            @php
                $amount = $feeAssignChildren->feesMaster?->amount + calculateTax($feeAssignChildren->feesMaster?->amount);
                if ($discount){
                    $amount -= calculateDiscount($feeAssignChildren->feesMaster?->amount, $discount->discount_percentage);
                }
                $fineAmount = 0;
                if (date('Y-m-d') > $feeAssignChildren->feesMaster?->due_date && $feeAssignChildren->fees_collect_count == 0) {
                    $fineAmount = $feeAssignChildren->feesMaster?->fine_amount;
                    $amount += $fineAmount;
                }
            @endphp
            {{ ___('fees.Fee Pay') }}
        </h5>

        <button type="button" class="m-0 btn-close d-flex justify-content-center align-items-center" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times text-white" aria-hidden="true"></i></button>
    </div>
    <form action="{{ $formRoute }}" method="POST" id="checkout-form">
        @csrf

        <input type="hidden" name="fees_assign_children_id" value="{{ $feeAssignChildren->id }}">
        <input type="hidden" name="student_id" value="{{ $feeAssignChildren->student_id }}">
        <div class="modal-body p-4">
            <div class="row mb-3">
                @if($discount)

                    <div class="col-12 mb-3">
                        <label>{{___('fees.Total Fees Amount')}}</label>
                        <input class="form-control ot-input bg-light"
                               value="{{$feeAssignChildren->feesMaster?->amount + calculateTax($feeAssignChildren->feesMaster?->amount)}}" readonly>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="text-success">{{___('fees.Early payment discount')}} ({{ucfirst($discount->name)}}) {{( $discount->discount_percentage)}}%</label>
                        <input class="form-control ot-input bg-light"
                               value="{{ calculateDiscount($feeAssignChildren->feesMaster?->amount, $discount->discount_percentage) }}" readonly>
                    </div>
                @endif
                <div class="col-12 mb-3">
                    <label for="exampleDataList" class="form-label">{{ ___('fees.Total Payable Amount') }} ({{ Setting('currency_symbol') }}) <span class="fillable">*</span></label>
                    <input class="form-control ot-input bg-light" value="{{ $amount }}" readonly>
                    <input type="hidden" name="amount" value="{{ $amount - $fineAmount }}">
                    <input type="hidden" name="fine_amount" value="{{ $fineAmount }}">
                </div>
                <div class="col-12 mb-3">
                    <label for="exampleDataList" class="form-label">{{ ___('fees.Date') }} <span class="fillable">*</span></label>
                    <input class="form-control ot-input" name="date" list="datalistOptions" id="exampleDataList" type="date" placeholder="{{ ___('fees.date') }}" value="{{ date('Y-m-d') }}" required readonly>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">{{ ___('fees.payment_method') }} <span class="fillable">*</span></label>
                    <div class="input-check-radio academic-section">
                        <div class="radio-inputs">
                            <label>
                                <input class="radio-input" type="radio" name="payment_method" value="Stripe" checked>
                                    <span class="radio-tile">
                                        <span class="radio-icon">
                                            <i class="lab la-stripe"></i>
                                        </span>
                                        <span class="radio-label">{{ ___('fees.Stripe') }}</span>
                                    </span>
                            </label>
                            <label>
                                <input class="radio-input" type="radio" name="payment_method" value="PayPal">
                                <span class="radio-tile">
                                    <span class="radio-icon">
                                        <i class="lab la-paypal"></i>
                                    </span>
                                    <span class="radio-label">{{ ___('fees.PayPal') }}</span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <div class="border rounded-3 payment_input_box" id="stripeOption">
                        <input type='hidden' name='stripeToken' id='stripe-token-id'>
                        <br>
                        <div id="card-element"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary py-2 px-4" data-bs-dismiss="modal">{{ ___('ui_element.cancel') }}</button>
            <button type="button" onclick="createToken()" class="btn ot-btn-primary" id='stripe-pay-btn'>{{ ___('ui_element.confirm') }}</button>
            <a href="{{ $paypalRoute }}?fees_assign_children_id={{ $feeAssignChildren->id }}" class="btn ot-btn-primary d-none" id='paypal-pay-btn'>{{ ___('ui_element.confirm') }}</a>
        </div>
    </form>
</div>

@include('common.fee-pay.fee-pay-script')
