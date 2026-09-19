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
                    @if (hasPermission('id_card_create'))
                        <a href="{{ route('idcard.create') }}" class="btn btn-lg ot-btn-primary">
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
                                    <th class="purchase">{{ ___('common.title') }} </th>
                                    <th class="purchase">{{ ___('common.expired_date') }}</th>
                                    <th class="purchase">{{ ___('common.visibility') }}</th>
                                    <th class="purchase">{{ ___('common.preview') }}</th>
                                    @if (hasPermission('id_card_update') || hasPermission('id_card_delete'))
                                        <th class="action">{{ ___('common.action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @forelse ($data['id_cards'] ?? [] as $key => $row)
                                <tr id="row_{{ $row->id }}">
                                    <td class="serial">{{ ++$key }}</td>
                                    <td>{{ $row->title }}</td>
                                    <td>{{ $row->expired_date }}</td>
           
                                    <td>
                                        <div class="id-card-visibility">
                                        {{ ___('common.student_name') }}: 
                                       
                                            <input class="toggle-checkbox" type="checkbox" name="section_name" {{$row->student_name == true ? 'checked':''}}  id="toggle1">
                                            <label class="slider-btn" for="toggle1"></label>
                                        </div>
                                        <br>
                                        <div class="id-card-visibility">
                                        {{ ___('common.admission_no') }}: 
                                       
                                        <input class="toggle-checkbox" type="checkbox" name="section_name" {{$row->admission_no == true ? 'checked':''}}  id="toggle2">
                                            <label class="slider-btn" for="toggle2"></label>
                                        </div>
                                        <br>

                                        <div class="id-card-visibility">
                                        
                                        {{ ___('common.roll_no') }}: 
                                        <input class="toggle-checkbox" type="checkbox" name="section_name" {{$row->roll_no == true ? 'checked':''}}  id="toggle3">
                                            <label class="slider-btn" for="toggle3"></label>
                                        </div>
                                        <br>
                                        <div class="id-card-visibility">
                                        {{ ___('common.class_name') }}: 
                                        <input class="toggle-checkbox" type="checkbox" name="section_name" {{$row->class_name == true ? 'checked':''}} disabled id="toggle4">
                                            <label class="slider-btn" for="toggle4"></label>
                                        </div>
                                        <br> 
                                        <div class="id-card-visibility">   
                                        {{ ___('common.section_name') }}: 
                                        <input class="toggle-checkbox" type="checkbox" name="section_name" {{$row->section_name == true ? 'checked':''}} disabled id="toggle5">
                                            <label class="slider-btn" for="toggle5"></label>
                                        </div>
                                        <br>  
                                        <div class="id-card-visibility">  
                                        {{ ___('common.blood_group') }}: 
                                        <input class="toggle-checkbox" type="checkbox" name="section_name" {{$row->blood_group == true ? 'checked':''}} disabled id="toggle6">
                                            <label class="slider-btn" for="toggle6"></label>
                                        </div>
                                        <br>    
                                        <div class="id-card-visibility">  
                                        {{ ___('common.date_of_birth') }}: 
                                        <input class="toggle-checkbox" type="checkbox" name="dob" {{$row->dob == true ? 'checked':''}} disabled id="toggle7">
                                            <label class="slider-btn" for="toggle7"></label>
                                        </div>
                                        <br>    
                                    </td>
                                    <td>
                                        <a class="btn btn-sm ot-btn-primary"
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#openIdCardPreviewModal" onclick="openIdCardPreviewModal({{$row->id}})"><span
                                                                class="icon mr-8"><i
                                                                    class="fa-solid fa-eye"></i></span>
                                                            {{ ___('common.preview') }}</a>
                                    </td>
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
                                                                href="{{ route('idcard.edit', $row->id) }}"><span
                                                                    class="icon mr-8"><i
                                                                        class="fa-solid fa-pen-to-square"></i></span>
                                                                {{ ___('common.edit') }}</a>
                                                        </li>
                                                    @endif
                                                    @if (hasPermission('id_card_delete'))
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0);"
                                                                onclick="delete_row('idcard/delete', {{ $row->id }})">
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
                                    {!!$data['id_cards']->appends(\Request::capture()->except('page'))->links() !!}
                                </ul>
                            </nav>
                        </div>

                    <!--  pagination end -->
                </div>
            </div>
        </div>
        <!--  table content end -->

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
                            data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times text-white" aria-hidden="true"></i></button>
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
