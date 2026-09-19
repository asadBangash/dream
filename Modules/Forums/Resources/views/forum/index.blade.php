@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@section('content')
    <div class="page-content">

        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="bradecrumb-title mb-1">{{ $data['title'] }}</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('common.home') }}</a>
                            </li>
                            <li class="breadcrumb-item">{{ $data['title'] }}</li>
                        </ol>
                </div>
            </div>
        </div>


        <div class="col-12">
            <form action="{{ route('forum.index') }}" method="get" id="marksheed" enctype="multipart/form-data">
                <div class="card ot-card mb-24 position-relative z_1">
                    <div class="card-header d-flex align-items-center gap-4 flex-wrap">
                        <h3 class="mb-0">{{ ___('common.Filtering') }}</h3>

                        <div
                            class="card_header_right d-flex align-items-center gap-3 flex-fill justify-content-end flex-wrap">
                            <!-- table_searchBox -->
                            @if ($data['superadmin'])
                            <div class="single_large_selectBox">
                                <select class="class nice-select niceSelect bordered_style wide" name="publisher">
                                    <option value="">{{ ___('common.Select Publisher') }}</option>
                                    @foreach ($data['roles'] as $key => $value)
                                        <option {{ request('publisher') == $key ? 'selected' : '' }} value="{{ $key }}">
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <div class="single_large_selectBox">
                                <select class="nice-select niceSelect bordered_style wide" name="status">
                                    <option
                                        value=""
                                        {{ request('status') === null || request('status') === '' ? 'selected' : '' }}>
                                        {{ ___('common.Select Status') }}
                                    </option>
                                    <option
                                        value="1"
                                        {{ request('status') === '1' ? 'selected' : '' }}>
                                        {{ ___('common.Active') }}
                                    </option>
                                    <option
                                        value="0"
                                        {{ request('status') === '0' ? 'selected' : '' }}>
                                        {{ ___('common.Inactive') }}
                                    </option>
                                </select>
                            </div>


                            <div class="single_large_selectBox">
                                <select class="nice-select niceSelect bordered_style wide" name="published_status">
                                    <option
                                        value=""
                                        {{ request('published_status') === null || request('published_status') === '' ? 'selected' : '' }}>
                                        {{ ___('common.Publish Status') }}
                                    </option>
                                    <option
                                        value="1"
                                        {{ request('published_status') === '1' ? 'selected' : '' }}>
                                        {{ ___('common.Published') }}
                                    </option>
                                    <option
                                        value="0"
                                        {{ request('published_status') === '0' ? 'selected' : '' }}>
                                        {{ ___('common.Unpublished') }}
                                    </option>
                                </select>
                            </div>

                            <div class="single_large_selectBox">
                                <select class="nice-select niceSelect bordered_style wide" name="approval_status">
                                    <option value="">{{ ___('common.Approval Status') }}</option>
                                    <option
                                        {{ request('approval_status') == \App\Enums\ApprovalStatus::APPROVED ? 'selected' : ''}} value="{{ \App\Enums\ApprovalStatus::APPROVED }}">{{ \App\Enums\ApprovalStatus::APPROVED }}</option>
                                    <option
                                        {{ request('approval_status') == \App\Enums\ApprovalStatus::PENDING ? 'selected' : ''}} value="{{ \App\Enums\ApprovalStatus::PENDING }}">{{ \App\Enums\ApprovalStatus::PENDING }}</option>
                                    <option
                                        {{ request('approval_status') == \App\Enums\ApprovalStatus::REJECTED ? 'selected' : ''}} value="{{ \App\Enums\ApprovalStatus::REJECTED }}">{{ \App\Enums\ApprovalStatus::REJECTED }}</option>
                                </select>
                            </div>
                            <div class="single_large_selectBox">
                                <input class="form-control ot-input"
                                       name="keyword" list="datalistOptions" id="exampleDataList"
                                       placeholder="{{ ___('student_info.enter_keyword') }}"
                                       value="{{ old('keyword', request('keyword')) }}">
                            </div>

                            <button class="btn btn-lg ot-btn-primary" type="submit">
                                {{___('common.Search')}}
                            </button>
                            @if (request()->query())
                                <a href="{{ url()->current() }}" class="btn btn-lg ot-btn-danger">
                                    <i class="fa fa-times"></i>
                                </a>
                            @endif
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
                    {{--                    @if (hasPermission('forum_list'))--}}
                    <a href="{{ route('forum.create') }}" class="btn btn-lg ot-btn-primary">
                        <span><i class="fa-solid fa-plus"></i> </span>
                        <span class="">{{ ___('common.add') }}</span>
                    </a>
                    {{--                    @endif--}}
                </div>
                @if (@$data['forums'])
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered role-table">
                                <thead class="thead">
                                    <tr>
                                        <th class="serial" style="width: 5%;">{{ ___('common.sr_no') }}</th>
                                        <th class="purchase" style="width: 20%;">{{ ___('settings.Forum') }}</th>
                                        <th class="purchase" style="width: 15%;">{{ ___('settings.Target Roles') }}</th>
                                        <th class="purchase" style="width: 10%;">{{ ___('settings.Approval Status') }}</th>
                                        <th class="purchase" style="width: 10%;">{{ ___('settings.Publish Status') }}</th>
                                        <th class="purchase" style="width: 15%;">{{ ___('settings.Publisher') }}</th>
                                        <th class="purchase" style="width: 15%;">{{ ___('settings.Published At') }}</th>
                                        <th class="purchase" style="width: 5%;">{{ ___('settings.Views') }}</th>
                                        <th class="purchase" style="width: 5%;">{{ ___('common.status') }}</th>
                                        @if (hasPermission('student_update') || hasPermission('student_delete'))
                                            <th class="action" style="width: 5%;">{{ ___('common.action') }}</th>
                                        @endif
                                    </tr>
                                </thead>

                                <tbody class="tbody">
                                {{-- @dd($data['students']) --}}
                                @forelse ($data['forums'] as $key => $row)
                                    <tr id="row_{{ @$row->id }}">
                                        <td class="serial">{{ ++$key }}</td>
                                        <td class="serial">{{ \Illuminate\Support\Str::limit(strip_tags($row->description), 20) }}</td>

                                        <td>
                                            @foreach ($row->roles() ?? [] as $roleName)
                                                <span class="badge-basic-primary-text">{{ $roleName }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <span
                                                class="{{ $row->approval_status == \App\Enums\ApprovalStatus::REJECTED ? 'badge-basic-danger-text' : ($row->approval_status == \App\Enums\ApprovalStatus::PENDING ? 'badge-basic-warning-text' : 'badge-basic-success-text') }}  text-capitalize">
                                                {{ $row->approval_status }}
                                            </span>
                                            @if( $row->approval_status == \App\Enums\ApprovalStatus::REJECTED)
                                                <span class="px-1">{{ ___('common.By') }}</span>
                                                <b>{{ @$row->rejector->name }}</b>
                                            @elseif( $row->approval_status == \App\Enums\ApprovalStatus::APPROVED)
                                                <span class="px-1">{{ ___('common.By') }}</span>
                                                <b>{{ @$row->approver->name }}</b>
                                            @elseif( $row->approval_status == \App\Enums\ApprovalStatus::PENDING)
                                                <span class="px-1">{{$row->pending? ___('common.By'):'' }}</span>
                                                <b>{{ @$row->pending->name }}</b>
                                            @endif
                                        </td>
                                        <td>
                                            @if (@$row->is_published)
                                                <span
                                                    class="badge-basic-success-text">{{ ___('common.Published') }}</span>
                                            @else
                                                <span
                                                    class="badge-basic-danger-text">{{ ___('common.Unpublished') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="">
                                                <a href="">
                                                    <div class="user-card">
                                                        <div class="user-avatar">
                                                            <img
                                                                src="{{ @globalAsset(@$row->creator->upload->path, '40X40.webp') }}"
                                                                alt="{{ @$row->creator->name }}">
                                                        </div>
                                                        <div class="user-info">
                                                            {{ @$row->creator->name }}
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </td>

                                        <td>{{ dateFormat($row->created_at) }}</td>

                                        <td>{{ number_format($row->views_count) }}</td>

                                        <td>
                                            @if (@$row->status == App\Enums\Status::ACTIVE)
                                                <span class="badge-basic-success-text">{{ ___('common.active') }}</span>
                                            @else
                                                <span
                                                    class="badge-basic-danger-text">{{ ___('common.inactive') }}</span>
                                            @endif
                                        </td>
                                        @if (hasPermission('forum_list') || hasPermission('forum_list'))
                                            <td class="action">
                                                <div class="dropdown dropdown-action">
                                                    <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                        <i class="fa-solid fa-ellipsis"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end ">
                                                        @if (hasPermission('forum_list'))
                                                            <li>
                                                                <a class="dropdown-item"
                                                                   href="{{ route('forum.edit', @$row->id) }}"><span
                                                                        class="icon mr-8"><i
                                                                            class="fa-solid fa-pen-to-square"></i></span>
                                                                    {{ ___('common.edit') }}</a>
                                                            </li>
                                                        @endif

                                                        @if (hasPermission('forum_list'))
                                                            <li>
                                                                <a class="dropdown-item"
                                                                   href="{{ route('forum.show', @$row->id) }}"><span
                                                                        class="icon mr-8"><i
                                                                            class="fa-solid fa-eye"></i></span>
                                                                    {{ ___('common.View') }}
                                                                </a>
                                                            </li>
                                                        @endif
                                                        @if (hasPermission('forum_list') && auth()->user()->role_id == \App\Enums\RoleEnum::SUPERADMIN)
                                                            @if($row->approval_status != 'approved')
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                       href="{{ route('forum.changeStatus', ['id' => @$row->id,'status' => 'approved']) }}"><span
                                                                            class="icon mr-8"><i
                                                                                class="fa-solid fa-check-double"></i></span>
                                                                        {{ ___('common.Approved') }}</a>
                                                                </li>
                                                            @endif
                                                            @if($row->approval_status != 'rejected')
                                                            <li>
                                                                <a class="dropdown-item"
                                                                   href="{{ route('forum.changeStatus', ['id' => @$row->id,'status' => 'rejected']) }}"><span
                                                                        class="icon mr-8"><i
                                                                        class="fa-solid fa-times-circle"></i></span>
                                                                    {{ ___('common.Rejected') }}</a>
                                                            </li>
                                                            @endif
                                                            @if($row->approval_status != 'pending')
                                                            <li>
                                                                <a class="dropdown-item"
                                                                   href="{{ route('forum.changeStatus', ['id' => @$row->id,'status' => 'pending']) }}"><span
                                                                        class="icon mr-8"><i
                                                                            class="fa-solid fa-ban"></i></span>
                                                                    {{ ___('common.Pending') }}</a>
                                                            </li>
                                                            @endif
                                                            @if (@$row->is_published)
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                       href="{{ route('forum.changeStatus', ['id' => @$row->id,'status' => 'unpublished']) }}"><span
                                                                            class="icon mr-8"><i
                                                                                class="fa-solid fa-download"></i></span>
                                                                        {{ ___('common.Unpublished') }}</a>
                                                                </li>
                                                            @else
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                       href="{{ route('forum.changeStatus', ['id' => @$row->id,'status' => 'published']) }}"><span
                                                                            class="icon mr-8"><i
                                                                                class="fa-solid fa-upload"></i></span>
                                                                        {{ ___('common.Published') }}</a>
                                                                </li>
                                                            @endif

                                                        @endif
                                                        @if (hasPermission('forum_list'))
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0);"
                                                                   onclick="delete_row('forums/delete', {{ @$row->id }})">
                                                                <span class="icon mr-8"><i
                                                                        class="fa-solid fa-trash-can"></i></span>
                                                                    <span>{{ ___('common.delete') }}</span>
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center gray-color">
                                            <img src="{{ asset('images/no_data.svg') }}" alt="" class="mb-primary"
                                                 width="100">
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

                        <div
                            class="ot-pagination pagination-content d-flex justify-content-end align-content-center py-3">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-between">
                                    {!!$data['forums']->appends(\Request::capture()->except('page'))->links() !!}
                                </ul>
                            </nav>
                        </div>

                        <!--  pagination end -->
                    </div>
                @else
                    <div class="text-center gray-color p-5">
                        <img src="{{ asset('images/no_data.svg') }}" alt="" class="mb-primary" width="100">
                        <p class="mb-0 text-center">{{ ___('common.no_data_available') }}</p>
                        <p class="mb-0 text-center text-secondary font-size-90">
                            {{ ___('common.please_add_new_entity_regarding_this_table') }}</p>
                    </div>
                @endif

            </div>
        </div>
        <!--  table content end -->

    </div>
@endsection

@push('script')
    @include('backend.partials.delete-ajax')
@endpush







