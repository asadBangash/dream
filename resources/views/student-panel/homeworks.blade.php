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
                    @if (hasPermission('homework_create'))
                        <a href="{{ route('homework.create') }}" class="btn btn-lg ot-btn-primary">
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
                                    <th class="purchase">{{ ___('academic.subject') }}</th>
                                    <th class="purchase">{{ ___('academic.date') }}</th>
                                    
                                    <th class="purchase">{{ ___('academic.marks') }}</th>
                                    <th class="purchase">{{ ___('academic.document') }}</th>
                                    <th class="purchase">{{ ___('academic.submission_date') }}</th>
                                        <th class="action">{{ ___('common.action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="tbody">
                                @forelse ($data['homeworks'] as $key => $row)
                                <tr id="row_{{ $row->id }}">
                                    <td class="serial">{{ ++$key }}</td>
                                    <td>{{ $row->subject->name }}</td>
                                    <td>{{ $row->date }}</td>
                                    
                                    <td>{{ $row->marks }}</td>
                                    <td><a class="btn btn-lg ot-btn-primary radius_30px small_add_btn" href="{{ @globalAsset($row->upload->path, '100X100.webp') }}" target="_blank"><i class="fa-solid fa-eye"></i></a></td>
                                    <td>{{ $row->submission_date }} 
                                        @if($row->check_submitted) 
                                        <span class="badge-basic-success-text">{{ ___('online-examination.Submitted') }}</span>
                                        <a class="btn btn-lg ot-btn-primary radius_30px small_add_btn" href="{{ @globalAsset($row->check_submitted->homeworkUpload->path, '100X100.webp') }}" target="_blank">
                                            <i class="fa-solid fa-eye"></i>
                                        </a><br>
                                        <span class="badge-basic-success-text">{{ ___('online-examination.Evaluated Marks') }}: {{$row->check_submitted->marks}} </span>
                                        @else
                                        <span class="badge-basic-danger-text">{{ ___('online-examination.Not Submitted Yest') }}</span>
                                        @endif
                                    </td>
                                    <td class="action">
                                        <div class="dropdown dropdown-action">
                                            <button type="button" class="btn-dropdown" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end ">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="" data-bs-toggle="modal"
                                                        data-bs-target="#modalSubmitHomework" onclick="openHomeworkModal({{$row->id}})"><span
                                                            class="icon mr-8"><i
                                                                class="fa-solid fa-save"></i></span>
                                                        {{ ___('common.Submit') }}</a>
                                                        
                                                </li>
                                            </ul>
                                        </div>
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
                                    {!!$data['homeworks']->appends(\Request::capture()->except('page'))->links() !!}
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
        <div class="modal fade" id="modalSubmitHomework" tabindex="-1" aria-labelledby="modalWidth"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content" id="modalWidth">
                    <div class="modal-header modal-header-image">
                        <h5 class="modal-title" id="modalLabel2">
                            {{ ___('common.Homework') }}
                        </h5>
                        <button type="button" class="m-0 btn-close d-flex justify-content-center align-items-center"
                            data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times text-white" aria-hidden="true"></i></button>
                    </div>
                    <form action="{{ url('stundet/panel/homework/submit') }}" enctype="multipart/form-data" method="post" id="homework-submit-form">
                        @csrf
                        <input type="hidden" name="homework_id" id="homework_id">
                    <div class="modal-body p-5">
                
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="exampleDataList"
                                            class="form-label ">{{ ___('common.homework') }}<span
                                                class="fillable"> *</span></label>
        
        
                                        <div class="ot_fileUploader left-side mb-1">
                                            <input class="form-control" type="text"
                                                placeholder="{{ ___('common.image') }}" readonly="" id="placeholder">
                                            <button class="primary-btn-small-input" type="button">
                                                <label class="btn btn-lg ot-btn-primary"
                                                    for="fileBrouse">{{ ___('common.browse') }}</label>
                                                <input type="file" class="d-none form-control homework-file" name="homework"
                                                    id="fileBrouse" accept="image/*, .pdf, .doc, docx">
                                            </button>
                                        </div>
                                        <span id="homework_error" class="text-danger"></span>
        
                                    </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary py-2 px-4"
                            data-bs-dismiss="modal">{{ ___('ui_element.cancel') }}</button>
                            
                        <button type="button" class="btn ot-btn-primary" onclick="return homeworkSubmit(event)">{{ ___('ui_element.confirm') }}</button>
                      
                    </div>
                </form>
                </div>
                
            </div>
        </div>
    </div>

@endsection

@push('script')
    @include('backend.partials.delete-ajax')
@endpush
