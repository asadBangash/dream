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

        <div class="row">
            <div class="col-12">
                <form action="{{ route('payment.report.search') }}" method="post" id="marksheed" enctype="multipart/form-data">
                    @csrf
                    <div class="card ot-card mb-24 position-relative z_1">
                        <div class="card-header d-flex align-items-center gap-4 flex-wrap">
                            <h3 class="mb-0">{{ ___('mainapp_common.Filtering') }}</h3>

                            <div class="card_header_right d-flex align-items-center gap-3 flex-fill justify-content-end flex-wrap">
                                <!-- table_searchBox -->


                                <div class="single_large_selectBox">
                                    <input type="text" class="form-control ot-input"
                                        value="{{ @$data['request']->dates }}" name="dates">
                                </div>


                                <button class="btn btn-lg ot-btn-primary" type="submit">
                                    {{___('mainapp_common.Search')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <!--  table content start -->
        <div class="table-content table-basic mt-20">
            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ ___('mainapp_subscriptions.Subscription List') }}</h4>
                    <a href="{{ route('subscription.create') }}" class="btn btn-lg ot-btn-primary">
                        <span class="">{{ ___('mainapp_common.Total')}}: {{ number_format(@$data['total'], 2) }}</span>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered subscription-table">
                            <thead class="thead">
                                <tr>
                                    <th class="serial">{{ ___('mainapp_common.sr_no') }}</th>
                                    <th class="purchase">{{ ___('mainapp_common.Sub domain key') }}</th>
                                    <th class="purchase">{{ ___('mainapp_common.Package') }}</th>
                                    <th class="purchase">{{ ___('mainapp_common.Trx ID') }}</th>
                                    <th class="purchase">{{ ___('mainapp_common.Method') }}</th>
                                    <th class="purchase">{{ ___('mainapp_common.Price') }}</th>
                                    <th class="action">{{ ___('mainapp_common.action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @forelse ($data['subscriptions'] ?? [] as $key => $row)
                                <tr id="row_{{ $row->id }}">
                                    <td class="serial">{{ ++$key }}</td>
                                    <td>{{ @$row->school->sub_domain_key }}</td>
                                    <td>{{ $row->package->name }}</td>
                                    <td>{{ $row->trx_id }}</td>
                                    <td>{{ $row->method }}</td>
                                    <td>{{ $row->package->price }}</td>

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
                                                    {{--@if ($row->status == App\Enums\SubscriptionStatus::PENDING)
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('subscription.reject', $row->id) }}"><span
                                                                    class="icon mr-8"><i
                                                                        class="fa-solid fa-pen-to-square"></i></span>
                                                                {{ ___('common.Reject') }}</a>
                                                        </li>
                                                    @endif --}}
                                                    {{-- <li>
                                                        <a class="dropdown-item" href="javascript:void(0);"
                                                            onclick="delete_row('subscription/delete', {{ $row->id }})">
                                                            <span class="icon mr-8"><i
                                                                    class="fa-solid fa-trash-can"></i></span>
                                                            <span>{{ ___('common.delete') }}</span>
                                                        </a>
                                                    </li> --}}
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

                    @isset($data['subscriptions'])

                    <div class="ot-pagination pagination-content d-flex justify-content-end align-content-center py-3">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-between">
                                {{$data['subscriptions']->appends(['dates' => $data['dates']])->links() }}
                            </ul>
                        </nav>
                    </div>
                    @endif

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
