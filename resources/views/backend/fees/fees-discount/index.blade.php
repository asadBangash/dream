@php use Carbon\Carbon; @endphp
@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    <div class="page-content">

        {{-- bradecrumb Area S t a r t --}}
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="bradecrumb-title mb-1">{{ $data['title'] }}</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('common.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ ___('fee.Fees') }}</a></li>
                        <li class="breadcrumb-item">{{ $data['title'] }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        @if(hasPermission('siblings_discount'))
        <div class="card ot-card">
            <div class="card-header">
                <h5 class="mb-0">{{ ___('fees.Siblings Discount') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('fees-discount.store') }}" method="post">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">

                                <div class="d-flex align-items-end mb-3">
                                    <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                        <span
                                            class="card_visibility_box_item_title flex-fill">{{ ___('fees.Set up sibling-based discounts that scale with each child added') }}</span>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_applicable"
                                                {{ Setting('siblings_discount_applicable') == 1 ? 'checked' : '' }}>
                                        </div>

                                    </div>
                                </div>

                                <div class="d-flex align-items-start mb-3 justify-content-end">
                                    <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                        <a href="javascript:void(0)" id="add-fee-row" class="btn btn-sm ot-btn-primary">
                                            <span><i class="fa-solid fa-plus"></i> </span>
                                        </a>
                                    </div>
                                </div>

                                <div id="fee-items-container">
                                    @forelse($data['fees_discount'] as $index => $discount)
                                        <div
                                            class="row fee-item-row border rounded p-3 mb-3 bg-light position-relative">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">{{ ___('fees.Sibling Order') }}</label>
                                                <input
                                                    class="form-control @error('siblings_number.' . $index) is-invalid @enderror"
                                                    name="siblings_number[]" type="number"
                                                    value="{{ old('siblings_number.' . $index, $discount->siblings_number ?? '') }}"
                                                    placeholder="{{ ___('account.Enter Sibling Order') }}" min="1">
                                                @error('siblings_number.' . $index)
                                                <span class="invalid-feedback d-block"
                                                      role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">{{ ___('fees.Discount Title') }}</label>
                                                <input
                                                    class="form-control @error('discount_title.' . $index) is-invalid @enderror"
                                                    name="discount_title[]" type="text"
                                                    value="{{ old('discount_title.' . $index, $discount->discount_title ?? '') }}"
                                                    placeholder="{{ ___('common.Enter discount title') }}">
                                                @error('discount_title.' . $index)
                                                <span class="invalid-feedback d-block"
                                                      role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">{{ ___('fees.Discount Percentage') }}
                                                    (%)</label>
                                                <input
                                                    class="form-control @error('discount_percentage.' . $index) is-invalid @enderror"
                                                    name="discount_percentage[]" type="number"
                                                    value="{{ old('discount_percentage.' . $index, $discount->discount_percentage ?? '') }}"
                                                    placeholder="{{ ___('tax.Enter discount Percentage') }}" min="0">
                                                @error('discount_percentage.' . $index)
                                                <span class="invalid-feedback d-block"
                                                      role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <button type="button"
                                                    class="btn btn-danger btn-sm w-auto position-absolute top-0 end-0 mt-2 me-2 remove-fee-row z-2"
                                                    title="Remove">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    @empty
                                        @php $index = 0; @endphp
                                        <div
                                            class="row fee-item-row border rounded p-3 mb-3 bg-light position-relative">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">{{ ___('fees.Sibling Order') }}</label>
                                                <input
                                                    class="form-control @error('siblings_number.' . $index) is-invalid @enderror"
                                                    name="siblings_number[]" type="number"
                                                    value="{{ old('siblings_number.' . $index) }}"
                                                    placeholder="{{ ___('account.Enter Sibling Order') }}" min="1">
                                                @error('siblings_number.' . $index)
                                                <span class="invalid-feedback d-block"
                                                      role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">{{ ___('fees.Discount Title') }}</label>
                                                <input
                                                    class="form-control @error('discount_title.' . $index) is-invalid @enderror"
                                                    name="discount_title[]" type="text"
                                                    value="{{ old('discount_title.' . $index) }}"
                                                    placeholder="{{ ___('common.Enter discount title') }}">
                                                @error('discount_title.' . $index)
                                                <span class="invalid-feedback d-block"
                                                      role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">{{ ___('fees.Discount Percentage') }}
                                                    (%)</label>
                                                <input
                                                    class="form-control @error('discount_percentage.' . $index) is-invalid @enderror"
                                                    name="discount_percentage[]" type="number"
                                                    value="{{ old('discount_percentage.' . $index) }}"
                                                    placeholder="{{ ___('tax.Enter discount Percentage') }}" min="0">
                                                @error('discount_percentage.' . $index)
                                                <span class="invalid-feedback d-block"
                                                      role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <button type="button" class="btn btn-danger btn-sm remove-fee-row"
                                                    style="position: absolute; top: 10px; right: 10px; z-index: 10; width: auto; height: auto;">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    @endforelse
                                </div>

                                <div class="col-md-12 mt-24">
                                    <div class="text-end">
                                        <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                            </span>{{ ___('common.submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif

        @if(hasPermission('early_payment_discount'))
        <div class="card ot-card mt-3">
            <div class="card-header">
                <h5 class="mb-0">{{ ___('fees.Early Payment Discount') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('fees-discount.early-payment-discount') }}" method="post">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">

                                <div class="d-flex align-items-end mb-3">
                                    <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                        <span
                                            class="card_visibility_box_item_title flex-fill">{{ ___('fees.Set up early payment discounts') }}</span>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                   id="early_payment_discount_toggle"
                                                {{ Setting('early_payment_discount_applicable') == 1 ? 'checked' : '' }}>
                                        </div>

                                    </div>
                                </div>

                                <div class="d-flex align-items-start mb-3 justify-content-end">
                                    <div class="card_visibility_box_item d-flex align-items-center flex-wrap gap-3">
                                        <a href="javascript:void(0)" id="add-early-discount"
                                           class="btn btn-sm ot-btn-primary">
                                            <span><i class="fa-solid fa-plus"></i> </span>
                                        </a>
                                    </div>
                                </div>

                                <div id="early-payment-container">
                                    @forelse($data['early_payment_discount'] as $index => $discount)
                                        <div
                                            class="row fee-item-row border rounded p-3 mb-3 bg-light position-relative">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">{{ ___('fees.Discount Title') }}</label>
                                                <input
                                                    class="form-control @error('discount_title.' . $index) is-invalid @enderror"
                                                    name="discount_title[]" type="text"
                                                    value="{{ old('discount_title.' . $index, $discount->name ?? '') }}"
                                                    placeholder="{{ ___('common.Enter discount title') }}">
                                                @error('discount_title.' . $index)
                                                <span class="invalid-feedback d-block"
                                                      role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">{{ ___('fees.Start Date') }}</label>
                                                <input
                                                    class="form-control @error('start_date.' . $index) is-invalid @enderror"
                                                    name="start_date[]" type="date"
                                                    value="{{ old('start_date.' . $index, isset($discount->start_date) ? Carbon::parse($discount->start_date)->format('Y-m-d') : '') }}"
                                                    placeholder="{{ ___('tax.Enter start date') }}">
                                                @error('start_date.' . $index)
                                                <span class="invalid-feedback d-block"
                                                      role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">{{ ___('fees.End Date') }}</label>
                                                <input
                                                    class="form-control @error('end_date.' . $index) is-invalid @enderror"
                                                    name="end_date[]" type="date"
                                                    value="{{ old('end_date.' . $index, isset($discount->end_date) ? Carbon::parse($discount->end_date)->format('Y-m-d') : '') }}"
                                                    placeholder="{{ ___('tax.Enter end date') }}">
                                                @error('end_date.' . $index)
                                                <span class="invalid-feedback d-block"
                                                      role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">{{ ___('fees.Discount Percentage') }}
                                                    (%)</label>
                                                <input
                                                    class="form-control @error('discount_percentage.' . $index) is-invalid @enderror"
                                                    name="discount_percentage[]" type="number"
                                                    value="{{ old('discount_percentage.' . $index, $discount->discount_percentage ?? '') }}"
                                                    placeholder="{{ ___('tax.Enter discount Percentage') }}" min="0">
                                                @error('discount_percentage.' . $index)
                                                <span class="invalid-feedback d-block"
                                                      role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <button type="button"
                                                    class="btn btn-danger btn-sm w-auto position-absolute top-0 end-0 mt-2 me-2 remove-fee-row z-2"
                                                    title="Remove">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    @empty
                                        {{-- For the first empty row, fallback to old input --}}
                                        @php $index = 0; @endphp
                                        <div
                                            class="row fee-item-row border rounded p-3 mb-3 bg-light position-relative">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">{{ ___('fees.Discount Title') }}</label>
                                                <input
                                                    class="form-control @error('discount_title.' . $index) is-invalid @enderror"
                                                    name="discount_title[]" type="text"
                                                    value="{{ old('discount_title.' . $index) }}"
                                                    placeholder="{{ ___('common.Enter discount title') }}">
                                                @error('discount_title.' . $index)
                                                <span class="invalid-feedback d-block"
                                                      role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">{{ ___('fees.Start Date') }}</label>
                                                <input
                                                    class="form-control @error('start_date.' . $index) is-invalid @enderror"
                                                    name="start_date[]" type="date"
                                                    value="{{ old('start_date.' . $index) }}"
                                                    placeholder="{{ ___('tax.Enter start date') }}">
                                                @error('start_date.' . $index)
                                                <span class="invalid-feedback d-block"
                                                      role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">{{ ___('fees.End Date') }}</label>
                                                <input
                                                    class="form-control @error('end_date.' . $index) is-invalid @enderror"
                                                    name="end_date[]" type="date"
                                                    value="{{ old('end_date.' . $index) }}"
                                                    placeholder="{{ ___('tax.Enter end date') }}">
                                                @error('end_date.' . $index)
                                                <span class="invalid-feedback d-block"
                                                      role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">{{ ___('fees.Discount Percentage') }}
                                                    (%)</label>
                                                <input
                                                    class="form-control @error('discount_percentage.' . $index) is-invalid @enderror"
                                                    name="discount_percentage[]" type="number"
                                                    value="{{ old('discount_percentage.' . $index) }}"
                                                    placeholder="{{ ___('tax.Enter discount Percentage') }}" min="0">
                                                @error('discount_percentage.' . $index)
                                                <span class="invalid-feedback d-block"
                                                      role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <button type="button"
                                                    class="btn btn-danger btn-sm w-auto position-absolute top-0 end-0 mt-2 me-2 remove-fee-row z-2"
                                                    title="Remove">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    @endforelse
                                </div>

                                <div class="col-md-12 mt-24">
                                    <div class="text-end">
                                        <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                            </span>{{ ___('common.submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif


    </div>

@endsection
@push('script')
    <script>
        document.getElementById('add-fee-row').addEventListener('click', function () {
            const container = document.getElementById('fee-items-container');
            const firstRow = container.querySelector('.fee-item-row');
            const newRow = firstRow.cloneNode(true);

            // Clear input values in the clone
            newRow.querySelectorAll('input').forEach(input => input.value = '');

            // Show the remove button in the cloned row
            const removeBtn = newRow.querySelector('.remove-fee-row');
            if (removeBtn) {
                removeBtn.classList.remove('d-none');
            }

            container.appendChild(newRow);
        });

        document.getElementById('add-early-discount').addEventListener('click', function () {
            const container = document.getElementById('early-payment-container');
            const firstRow = container.querySelector('.fee-item-row');
            const newRow = firstRow.cloneNode(true);

            // Clear input values in the clone
            newRow.querySelectorAll('input').forEach(input => input.value = '');

            // Show the remove button in the cloned row
            const removeBtn = newRow.querySelector('.remove-fee-row');
            if (removeBtn) {
                removeBtn.classList.remove('d-none');
            }

            container.appendChild(newRow);
        });

        // Event delegation to handle delete
        document.getElementById('fee-items-container').addEventListener('click', function (e) {
            if (e.target.closest('.remove-fee-row')) {
                const row = e.target.closest('.fee-item-row');
                row.remove();
            }
        });

        document.getElementById('early-payment-container').addEventListener('click', function (e) {
            if (e.target.closest('.remove-fee-row')) {
                const row = e.target.closest('.fee-item-row');
                row.remove();
            }
        });

        $(document).ready(function () {
            $('#is_applicable').on('change', function () {
                const isChecked = $(this).is(':checked') ? 1 : 0;

                $.ajax({
                    url: '{{ route('fees-discount.toggle-applicable') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        value: isChecked
                    },
                    success: function (response) {
                        toastr.success(response.message);
                    },
                    error: function (xhr) {
                        console.error("Toggle update failed:", xhr.responseText);
                    }
                });
            });
        });


        $(document).ready(function () {
            $('#early_payment_discount_toggle').on('change', function () {
                const isChecked = $(this).is(':checked') ? 1 : 0;

                $.ajax({
                    url: '{{ route('fees-discount.early-payment-toggle') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        value: isChecked
                    },
                    success: function (response) {
                        toastr.success(response.message);
                    },
                    error: function (xhr) {
                        console.error("Toggle update failed:", xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush
