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
                        <li class="breadcrumb-item">{{ $data['title'] }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}
        <!--  table content start -->
        <div class="table-content table-basic mt-20">
            <div class="row">
               <div class="col-3">
                   <div class="card">
                       <div class="card-header d-flex justify-content-between align-items-center">
                           <h4 class="mb-0">Add {{ $data['title'] }}</h4>
                       </div>
                       <div class="card-body">
                           <form action="{{ route('leave-type.store') }}" enctype="multipart/form-data" method="post"
                                 id="visitForm">
                               @csrf
                               <div class="row mb-3">
                                   <div class="col-lg-12">
                                       <div class="row">
                                           <div class="col-md-12 mb-3">
                                               <label for="exampleDataList" class="form-label ">{{ ___('common.name') }}
                                                   <span
                                                       class="fillable">*</span></label>
                                               <input class="form-control ot-input @error('name') is-invalid @enderror"
                                                      name="name"
                                                      list="datalistOptions" id="exampleDataList" type="text"
                                                      placeholder="{{ ___('common.enter_name') }}"
                                                      value="{{ $data['edit_type']?->name ?? '' }}">
                                               @error('name')
                                               <div id="validationServer04Feedback" class="invalid-feedback">
                                                   {{ $message }}
                                               </div>
                                               @enderror
                                           </div>

                                           <input type="hidden" name="type_id"  value="{{ $data['edit_type']?->id ?? '' }}">

                                           <div class="col-md-12 mb-3">
                                               <label for="validationServer04" class="form-label">{{ ___('common.status') }} <span class="fillable">*</span></label>
                                               <select class="nice-select niceSelect bordered_style wide @error('status') is-invalid @enderror"
                                                       name="status" id="validationServer04"
                                                       aria-describedby="validationServer04Feedback">
                                                   <option value="{{ App\Enums\Status::ACTIVE }}"
                                                       {{ $data['edit_type']?->active_status ?? '' == App\Enums\Status::ACTIVE ? 'selected' : '' }}>
                                                       {{ ___('common.active') }}
                                                   </option>
                                                   <option value="{{ App\Enums\Status::INACTIVE }}"
                                                       {{ $data['edit_type']?->active_status ?? '' == App\Enums\Status::INACTIVE ? 'selected' : '' }}>
                                                       {{ ___('common.inactive') }}
                                                   </option>
                                               </select>


                                               @error('status')
                                               <div id="validationServer04Feedback" class="invalid-feedback">
                                                   {{ $message }}
                                               </div>
                                               @enderror
                                           </div>

                                           <div class="col-md-12 mb-3">
                                               <label for="exampleDataList"
                                                      class="form-label ">{{ ___('fees.description') }}</label>
                                               <textarea
                                                   class="form-control ot-textarea mt-0 @error('description') is-invalid @enderror"
                                                   name="description"
                                                   list="datalistOptions" id="exampleDataList"
                                                   placeholder="{{ ___('fees.enter_description') }}">{{ $data['edit_type']?->short_desc ?? '' }}</textarea>
                                               @error('description')
                                               <div id="validationServer04Feedback" class="invalid-feedback">
                                                   {{ $message }}
                                               </div>
                                               @enderror
                                           </div>

                                           <div class="col-md-12 mt-24">
                                               <div class="text-end">
                                                   <button class="btn btn-lg ot-btn-primary"><span><i
                                                               class="fa-solid fa-save"></i>
                                 </span>{{ ___('common.submit') }}</button>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>

                {{--                second card--}}
               <div class="col-9">
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
                                       <th class="purchase">{{ ___('common.name') }} </th>
                                       <th class="purchase">{{ ___('common.short desc') }}</th>
                                       <th class="purchase">{{ ___('common.role') }}</th>
                                       <th class="purchase">{{ ___('common.status') }}</th>
                                       @if (hasPermission('id_card_update') || hasPermission('id_card_delete'))
                                           <th class="action">{{ ___('common.action') }}</th>
                                       @endif
                                   </tr>
                                   </thead>
                                   <tbody class="tbody">
                                   @forelse ($data['types'] ?? [] as $key => $row)
                                       <tr id="row_{{ $row->id }}">
                                           <td class="serial">{{ ++$key }}</td>
                                           <td>{{ $row->name }}</td>
                                           <td>{{ $row->short_desc }}</td>
                                           <td>
                                              {{ $row->role_name }}
                                           </td>
                                           <td>{{$row->status}}</td>
                                           @if (hasPermission('id_card_update') || hasPermission('id_card_delete'))
                                               <td class="action">
                                                   <div class="dropdown dropdown-action">
                                                       <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                               aria-expanded="false">
                                                           <i class="fa-solid fa-ellipsis"></i>
                                                       </button>
                                                       <ul class="dropdown-menu dropdown-menu-end ">
                                                           @if (hasPermission('id_card_update'))
                                                               <li>
                                                                   <a class="dropdown-item"
                                                                      href="{{ route('leave-type.edit', $row->id) }}"><span
                                                                           class="icon mr-8"><i
                                                                               class="fa-solid fa-pen-to-square"></i></span>
                                                                       {{ ___('common.edit') }}</a>
                                                               </li>
                                                           @endif
                                                           @if (hasPermission('id_card_delete'))
                                                               <li>
                                                                   <a class="dropdown-item" href="javascript:void(0);"
                                                                      onclick="delete_row('leave-type/delete', {{ $row->id }})">
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
                                                   {{ ___('common.please_add_new_entity_regarding_this_table') }}
                                               </p>
                                           </td>
                                       </tr>
                                   @endforelse
                                   </tbody>
                               </table>
                           </div>
                           <!--  table end -->
                           <!--  pagination start -->
                           <div class="pagination-area mt-20">
                               {{ $data['types']->links() }}
                           </div>
                           <!--  pagination end -->
                       </div>
                   </div>
               </div>
            </div>
        </div>
    </div>

    <div id="view-modal">
        <div class="modal fade" id="openIdCardPreviewModal" tabindex="-1" aria-labelledby="modalWidth"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" id="modalWidth">
                    <div class="modal-header modal-header-image">
                        <h5 class="modal-title" id="modalLabel2">
                            {{ ___('common.Preview') }}
                        </h5>
                        <button type="button" class="m-0 btn-close d-flex justify-content-center align-items-center"
                                data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times text-white"
                                                                              aria-hidden="true"></i></button>
                    </div>
                    <div class="modal-body p-5">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    @include('backend.partials.delete-ajax')
@endpush
