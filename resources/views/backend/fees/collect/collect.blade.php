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
                            <li class="breadcrumb-item" aria-current="page"><a
                                    href="{{ route('fees-collect.index') }}">{{ $data['title'] }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ ___('common.details') }}</li>
                        </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <div class="d-flex justify-content-between align-content-center mb-3">
                            <div class="align-self-center">
                                <h5 class="title">{{ ___('student_info.admission_no') }}</h5>
                                <p class="paragraph">{{ @$data['student']->admission_no }}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-content-center mb-3">
                            <div class="align-self-center">
                                <h5 class="title">{{ ___('student_info.student_name') }}</h5>
                                <p class="paragraph">{{ @$data['student']->first_name }}
                                    {{ @$data['student']->last_name }}</p>
                                <input type="hidden" name="student_id" id="student_id"
                                    value="{{ $data['student']->id }}" />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="d-flex justify-content-between align-content-center mb-3">
                            <div class="align-self-center">
                                <h5 class="title">{{ ___('academic.class') }}</h5>
                                <p class="paragraph">{{ @$data['student']->sessionStudentDetails->class->name }}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-content-center mb-3">
                            <div class="align-self-center">
                                <h5 class="title">{{ ___('academic.section') }}</h5>
                                <p class="paragraph">{{ @$data['student']->sessionStudentDetails->section->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="d-flex justify-content-between align-content-center mb-3">
                            <div class="align-self-center">
                                <h5 class="title">{{ ___('student_info.roll_no') }}</h5>
                                <p class="paragraph">{{ @$data['student']->roll_no }}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-content-center mb-3">
                            <div class="align-self-center">
                                <h5 class="title">{{ ___('common.date_of_birth') }}</h5>
                                <p class="paragraph">{{ dateFormat(@$data['student']->dob) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="d-flex justify-content-between align-content-center mb-3">
                            <div class="align-self-center">
                                <h5 class="title">{{ ___('student_info.guardian_name') }}</h5>
                                <p class="paragraph">{{ @$data['student']->parent->guardian_name }}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-content-center mb-3">
                            <div class="align-self-center">
                                <h5 class="title">{{ ___('student_info.mobile_number') }}</h5>
                                <p class="paragraph">{{ @$data['student']->mobile }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-header d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">{{___('fees.fees_details')}}</h4>
                    @if (hasPermission('fees_collect_create'))
                        <a href="#" class="btn btn-lg ot-btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalCustomizeWidth" onclick="feesCollect()">
                            <span><i class="fa-solid fa-plus"></i> </span>
                            <span class="">{{ ___('fees.Collect') }}</span>
                        </a>
                    @endif
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered role-table" id="students_table">
                        <thead class="thead">
                            <tr>
                                <th class="purchase mr-4">{{ ___('common.All') }} <input class="form-check-input all"
                                        type="checkbox"></th>
                                <th class="purchase">{{ ___('fees.group') }}</th>
                                <th class="purchase">{{ ___('fees.type') }}</th>
                                <th class="purchase">{{ ___('fees.due_date') }}</th>
                                <th class="purchase">{{ ___('fees.amount') }} ({{ Setting('currency_symbol') }})</th>
                                <th class="purchase">{{ ___('fees.Discount')}} ({{ Setting('currency_symbol') }})</th>
                                <th class="purchase">{{ ___('tax.Tax')}} ({{ Setting('currency_symbol') }})</th>
                                <th class="purchase">{{ ___('fees.Payable') }} ({{ Setting('currency_symbol') }})</th>
                                <th class="purchase">{{ ___('common.status') }}</th>
                                <th class="purchase">{{ ___('fees.fine_type') }}</th>
                                <th class="purchase">{{ ___('fees.percentage') }}</th>
                                <th class="purchase">{{ ___('fees.Fine') }} ({{ Setting('currency_symbol') }})</th>
                                @if (hasPermission('fees_collect_delete'))
                                    <th class="purchase">{{ ___('common.action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="tbody">

                            @foreach (@$data['fees_assigned'] as $item)
                                <tr>
                                    <td><input class="form-check-input child" type="checkbox" name="fees_assign_childrens[]"
                                            value="{{ $item->id }}"></td>
                                    <input type="hidden" name="discount_amount" value="{{ calculateDiscount(@$item->feesMaster->amount, @$item->feesDiscount->discount_percentage)}}">
                                    <input type="hidden" name="discount_name" value="{{@$item->feesDiscount->feesDiscount->title}}">
                                    <input type="hidden" name="discount_percentage" value="{{@$item->feesDiscount->discount_percentage}}">
                                    <td>{{ @$item->feesMaster->group->name }}</td>
                                    <td>{{ @$item->feesMaster->type->name }}</td>
                                    <td>{{ dateFormat(@$item->feesMaster->due_date) }}</td>
                                    <td>{{ @$item->feesMaster->amount }}

                                        @if (date('Y-m-d') > $item->feesMaster->date && $item->fees_collect_count == 0)
                                            <span class="text-danger">+ {{ @$item->feesMaster->fine_amount }}</span>
                                        @elseif($item->fees_collect_count == 1 && $item->feesMaster->date < $item->feesCollect->date)
                                            <span class="text-danger">+ {{ @$item->feesMaster->fine_amount }}</span>
                                        @endif

                                    </td>
                                    <td>
                                        {{ calculateDiscount(@$item->feesMaster->amount, @$item->feesDiscount->discount_percentage)}}
                                    </td>
                                    <td>{{ calculateTax(@$item->feesMaster->amount) }}</td>
                                    <td>{{ @$item->feesMaster->amount + calculateTax(@$item->feesMaster->amount) - calculateDiscount(@$item->feesMaster->amount, @$item->feesDiscount->discount_percentage)}}</td>
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

                                    @if (hasPermission('fees_collect_delete'))
                                        <td class="action">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end ">
                                                    @if ($item->fees_collect_count)
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0);"
                                                                onclick="delete_row('fees-collect/delete', {{ @$item->feesCollect->id }}, true)">
                                                                <span class="icon mr-8"><i
                                                                        class="fa-solid fa-trash-can"></i></span>
                                                                <span>{{ ___('common.Revert Payment') }}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="view-modal">
        <div class="modal fade" id="modalCustomizeWidth" tabindex="-1" aria-labelledby="modalWidth"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                {{--  --}}
            </div>
        </div>
    </div>
@endsection
@push('script')
    @include('backend.partials.delete-ajax')
@endpush
