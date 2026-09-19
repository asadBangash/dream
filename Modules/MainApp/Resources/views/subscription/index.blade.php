@extends('mainapp::layouts.backend.master')
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
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('mainapp_common.home') }}</a></li>
                        <li class="breadcrumb-item">{{ ___('mainapp_subscriptions.Subscription List') }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

        <!--  table content start -->
        <div class="table-content table-basic mt-20">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ ___('mainapp_subscriptions.Subscription List') }}</h4>
                    <a href="{{ route('subscription.create') }}" class="btn btn-lg ot-btn-primary">
                        <span><i class="fa-solid fa-plus"></i> </span>
                        <span class="">{{ ___('mainapp_schools.add') }}</span>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered subscription-table">
                            <thead class="thead">
                                <tr>
                                    <th class="serial">{{ ___('mainapp_common.sr_no') }}</th>
                                    <th class="purchase">{{ ___('mainapp_subscriptions.Sub domain key') }}</th>
                                    <th class="purchase">{{ ___('mainapp_subscriptions.Package') }}</th>
                                    <th class="purchase">{{ ___('mainapp_common.Price') }}</th>
                                    <th class="purchase">{{ ___('mainapp_subscriptions.Purchase Date') }}</th>
                                    <th class="purchase">{{ ___('mainapp_subscriptions.Date of Expire') }}</th>
                                    <th class="purchase">{{ ___('mainapp_subscriptions.Trx ID') }}</th>
                                    <th class="purchase">{{ ___('mainapp_subscriptions.Method') }}</th>
                                    <th class="purchase">{{ ___('mainapp_common.status') }}</th>
                                    <th class="purchase">{{ ___('mainapp_subscriptions.Payment status') }}</th>
                                    <th class="action">{{ ___('mainapp_common.action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @forelse ($data['subscriptions'] as $key => $row)
                                <tr id="row_{{ $row->id }}">
                                    <td class="serial">{{ ++$key }}</td>
                                    <td>{{ @$row->school->sub_domain_key }}</td>
                                    <td>{{ $row->package->name }}</td>
                                    <td>{{ $row->package->price }}</td>
                                    <td>{{ dateFormat(@$row->created_at) }}</td>
                                    <td>{{ $row->expiry_date ? dateFormat(@$row->expiry_date) : ___('mainapp_subscriptions.Lifetime') }}</td>
                                    <td>{{ $row->trx_id }}</td>
                                    <td>{{ $row->method }}</td>
                                    <td>
                                        @if ($row->status == App\Enums\SubscriptionStatus::APPROVED)
                                            <span class="badge-basic-success-text">{{ ___('mainapp_subscriptions.Approved') }}</span>
                                        @elseif ($row->status == App\Enums\SubscriptionStatus::REJECT)
                                            <span class="badge-basic-danger-text">{{ ___('mainapp_subscriptions.Reject') }}</span>
                                        @else
                                            <span class="badge-basic-warning-text">{{ ___('mainapp_subscriptions.Pending') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row->payment_status == 1)
                                            <span class="badge-basic-success-text">{{ ___('mainapp_subscriptions.Paid') }}</span>
                                        @else
                                            <span class="badge-basic-danger-text">{{ ___('mainapp_subscriptions.Unpaid') }}</span>
                                        @endif
                                    </td>

                                    <td class="action">
                                        @if ($row->status != App\Enums\SubscriptionStatus::REJECT)
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>

                                                <ul class="dropdown-menu dropdown-menu-end ">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('subscription.edit', $row->id) }}"><span
                                                                    class="icon mr-8"><i
                                                                        class="fa-solid fa-edit"></i></span>
                                                                {{ ___('mainapp_common.edit') }}</a>
                                                        </li>

                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="100%" class="text-center gray-color">
                                        <img src="{{ asset('images/no_data.svg') }}" alt="" class="mb-primary" width="100">
                                        <p class="mb-0 text-center">{{ ___('mainapp_common.no_data_available') }}</p>
                                        <p class="mb-0 text-center text-secondary font-size-90">
                                            {{ ___('mainapp_common.please_add_new_entity_regarding_this_table') }}</p>
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
                                    {!!$data['subscriptions']->links() !!}
                                </ul>
                            </nav>
                        </div>

                    <!--  pagination end -->
                </div>
            </div>
        </div>
        <!--  table content end -->

    </div>
@endsection

@push('script')
    @include('backend.partials.delete-ajax')
@endpush
