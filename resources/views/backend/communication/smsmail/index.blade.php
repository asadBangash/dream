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
                    <h4 class="bradecrumb-title mb-1">{{ $data['title'] }}</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('common.home') }}</a></li>
                        <li class="breadcrumb-item">{{ $data['title'] }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}
        
        <!--  table content start -->
        <div class="table-content table-basic mt-20">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $data['title'] }}</h4>
                    @if (hasPermission('sms_mail_send'))
                        <a href="{{ route('smsmail.create') }}" class="btn btn-lg ot-btn-primary">
                            <span><i class="fa-solid fa-plus"></i> </span>
                            <span class="">{{ ___('common.add') }}</span>
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered role-table sms-mail">
                            <thead class="thead">
                                <tr>
                                    <th class="serial">{{ ___('common.sr_no') }}</th>
                                    <th class="serial">{{ ___('common.title') }}</th>
                                    <th class="purchase">{{ ___('academic.type') }} </th>
                                    <th class="purchase">{{ ___('common.user_type') }}</th>
                                    <th class="purchase">{{ ___('account.description') }}</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @forelse ($data['smsmail'] ?? [] as $key => $row)
                                <tr id="row_{{ $row->id }}">
                                    <td class="serial">{{ ++$key }}</td>
                                    <td>{{ $row->title }}</td>
                                    <td>{{ $row->type }}</td>

                                    <td>
                                        {{$row->user_type_value}}
                                    </td>

                                    <td>
                                        @if($row->type == App\Enums\TemplateType::SMS) 

                                       {{ @$row->sms_description }}

                                        @else 
                                        
                                        {!! @$row->mail_description !!}

                                        {{ ___('common.attachment') }}: <a class="btn btn-sm ot-btn-primary" href="{{ @globalAsset($row->attachmentFile->path, '100X100.webp') }}" target="_blank"><i class="fa-solid fa-eye"></i>

                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="100%" class="text-center gray-color">
                                        <img src="{{ asset('images/no_data.svg') }}" alt="" class="mb-primary" width="100">
                                        <p class="mb-0 text-center">{{ ___('common.no_data_available') }}</p>
                                        <p class="mb-0 text-center text-secondary font-size-90">
                                            {{ ___('common.please_add_new_entity_regarding_this_table') }}</p>
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
                                    {!!$data['smsmail']->appends(\Request::capture()->except('page'))->links() !!}
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
    <script src="{{ global_asset('backend') }}/assets/js/__sms_mail.js"></script>
@endpush
