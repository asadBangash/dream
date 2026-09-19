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

        <div class="col-12">
            <form action="{{ route('gmeet.search') }}" method="post" id="marksheet" class="exam_assign" enctype="multipart/form-data">
                @csrf
                <div class="card ot-card mb-24 position-relative z_1">
                    <div class="card-header d-flex align-items-center gap-4 flex-wrap">
                        <h3 class="mb-0">{{ ___('common.Filtering') }}</h3>

                        <div
                            class="card_header_right d-flex align-items-center gap-3 flex-fill justify-content-end flex-wrap">
                            <!-- table_searchBox -->

                            <div class="single_large_selectBox">
                                <select id="getSections" class="class nice-select niceSelect bordered_style wide @error('class') is-invalid @enderror"
                                    name="class">
                                    <option value="">{{ ___('student_info.select_class') }} </option>
                                    @foreach ($data['classes'] as $item)
                                        <option value="{{ @$item->class->id }}">{{ @$item->class->name }}</option>
                                    @endforeach
                                </select>
                                @error('class')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="single_large_selectBox">
                                <select id="getSubjects"  class="sections section nice-select niceSelect bordered_style wide @error('section') is-invalid @enderror"
                                    name="section">
                                    <option value="">{{ ___('student_info.select_section') }} </option>
                                </select>
                                @error('section')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="single_large_selectBox">
                                <select class="subjects nice-select niceSelect bordered_style wide @error('subject') is-invalid @enderror"
                                    name="subject">
                                    <option value="">{{ ___('academic.select_subject') }} </option>

                                </select>
                                @error('subject')
                                    <div id="validationServer04Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button class="btn btn-lg ot-btn-primary" type="submit">
                                {{___('common.Search')}}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!--  table content start -->
        <div class="table-content table-basic mt-20">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $data['title'] }}</h4>
                    @if (hasPermission('gmeet_create'))
                        <a href="{{ route('gmeet.create') }}" class="btn btn-lg ot-btn-primary">
                            <span><i class="fa-solid fa-plus"></i> </span>
                            <span class="">{{ ___('common.add') }}</span>
                        </a>
                    @endif
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
                                    <th class="purchase">{{ ___('account.description') }}</th>
                                    <th class="purchase">{{ ___('common.status') }}</th>
                                    @if (hasPermission('gmeet_update') || hasPermission('gmeet_delete'))
                                        <th class="action">{{ ___('common.action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @forelse ($data['gmeets'] ?? [] as $key => $row)
                                <tr id="row_{{ $row->id }}">
                                    <td class="serial">{{ ++$key }}</td>
                                    <td>{{ $row->title }}</td>
                                    <td>{{ @$row->class->name }} ({{ @$row->section->name }})</td>
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
                                            <span class="badge-basic-success-text">{{ ___('online-examination.finished') }}</span>
                                        @endif
                                    </td>
                                    @if (hasPermission('gmeet_update') || hasPermission('gmeet_delete'))
                                        <td class="action">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end ">
                                                    @if (hasPermission('gmeet_update'))
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('gmeet.edit', $row->id) }}"><span
                                                                    class="icon mr-8"><i
                                                                    class="fa-solid fa-pen-to-square"></i></span>
                                                                {{ ___('common.edit') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (hasPermission('gmeet_delete'))
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0);"
                                                                onclick="delete_row('liveclass/gmeet/delete', {{ $row->id }})">
                                                                <span class="icon mr-8"><i
                                                                        class="fa-solid fa-trash-can"></i></span>
                                                                <span>{{ ___('common.delete') }}</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                    <li>
                                                        <a class="dropdown-item" href="{{$row->gmeet_link}}" target="_blank"
                                                            >
                                                            <span class="icon mr-8"><i
                                                                    class="fa-solid fa-video-camera"></i></span>
                                                            <span>{{ ___('common.Live') }}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    @endif
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
