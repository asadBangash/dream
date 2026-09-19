@extends('student-panel.partials.master')
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
                    
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered role-table">
                            <thead class="thead">
                                <tr>
                                    <th class="serial">{{ ___('common.sr_no') }}</th>
                                    <th class="serial">{{ ___('common.title') }}</th>
                                    <th class="purchase">{{ ___('academic.class') }} ({{ ___('academic.section') }})</th>
                                    <th class="purchase">{{ ___('academic.subject') }}</th>
                                    <th class="purchase">{{ ___('online-examination.Start') }}</th>
                                    <th class="purchase">{{ ___('online-examination.End') }}</th>
                                    <th class="purchase">{{ ___('common.description') }}</th>
                                    <th class="purchase">{{ ___('common.status') }}</th>
                                    
                                        <th class="action">{{ ___('common.action') }}</th>
                                  
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @forelse ($data['gmeets'] ?? [] as $key => $row)
                                <tr id="row_{{ $row->id }}">
                                    <td class="serial">{{ ++$key }}</td>
                                    <td>{{ $row->title }}</td>
                                    <td>{{ $row->class->name }} ({{ $row->section->name }})</td>
                                    <td>{{ @$row->subject->name }}</td>
                                    <td>{{ date('d-m-Y H:i a', strtotime(@$row->start)) }}</td>
                                    <td>{{ date('d-m-Y H:i a', strtotime(@$row->end)) }}</td>
                                    <td>{{ @$row->description }}</td>
                                    <td>
                                        @if (App\Enums\GmeetStatus::PENDING == $row->status)
                                            <span class="badge-basic-warning-text">{{ ___('online-examination.pending') }}</span>
                                        @elseif (App\Enums\GmeetStatus::CANCEL == $row->status)
                                            <span class="badge-basic-danger-text">{{ ___('online-examination.cancel') }}</span>
                                        @elseif (App\Enums\GmeetStatus::START == $row->status)
                                            <span class="badge-basic-info-text">{{ ___('online-examination.start') }}</span>
                                        @else
                                            <span class="badge-basic-danger-text">{{ ___('online-examination.finished') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                    
                                
                                        <a class="dropdown-item text-success" href="{{$row->gmeet_link}}" target="_blank"
                                            >
                                            <span class="icon mr-8"><i
                                                    class="fa-solid fa-video-camera"></i></span>
                                            <span>{{ ___('common.Live') }}</span>
                                        </a>
                                                   
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
                                    {!!$data['gmeets']->appends(\Request::capture()->except('page'))->links() !!}
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
