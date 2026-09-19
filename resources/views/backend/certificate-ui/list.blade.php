@extends('backend.master')

@section('title', 'Certificate')

@section('content')
<div class="page-content">

    {{-- bradecrumb Area S t a r t --}}
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="bradecrumb-title mb-1">{{ ___('common.Certificate') }}</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('common.home') }}</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('blood-groups.index') }}">{{ ___('settings.Certificate') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ ___('common.Lists') }}</li>
                    </ol>
            </div>
        </div>
    </div>
    {{-- bradecrumb Area E n d --}}

    <div class="col-12">
        <form action="{{ route('student.search') }}" method="post" id="marksheed" enctype="multipart/form-data">
            @csrf
            <div class="card ot-card mb-24 position-relative z_1">
                <div class="card-header d-flex align-items-center gap-4 flex-wrap">
                    <h3 class="mb-0">{{ ___('common.Filtering') }}</h3>

                    <div class="card_header_right d-flex align-items-center gap-3 flex-fill justify-content-end flex-wrap">
                        <div class="single_large_selectBox">
                            <input class="form-control ot-input" name="keyword" list="datalistOptions" id="exampleDataList" placeholder="{{ ___('student_info.enter_keyword') }}" value="{{ old('keyword', @$data['request']->keyword) }}">
                        </div>
                        <!-- table_searchBox -->
                        <div class="single_small_selectBox">
                            <select id="getSections" class="class nice-select niceSelect bordered_style wide @error('class') is-invalid @enderror" name="class">
                                <option value="Class 9">Class 9</option>
                                <option value="Class 9">Class 10</option>
                                <option value="Class 9">Class 11</option>
                            </select>
                            @error('class')
                            <div id="validationServer04Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="single_small_selectBox">
                            <select id="getSections" class="class nice-select niceSelect bordered_style wide @error('class') is-invalid @enderror" name="class">
                                <option value="Class 9">Section B</option>
                                <option value="Class 9">Section B</option>
                                <option value="Class 9">Section B</option>
                            </select>
                            @error('class')
                            <div id="validationServer04Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button class="btn btn-lg ot-btn-primary" type="submit">
                            Search
                        </button>
                    </div>
                </div>
            </div>

            <!--  table content start -->
            <div class="table-content table-basic mt-20">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Certificate</h4>
                        <a href="{{ route('student.create') }}" class="btn btn-lg ot-btn-primary">
                            <span><i class="fa-solid fa-plus mr-2"></i> </span>
                            <span class="">{{ ___('common.Create') }}</span>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered role-table">
                                <thead class="thead">
                                    <tr>
                                        <th class="serial">Serial</th>
                                        <th class="purchase">Student Name</th>
                                        <th class="purchase">Class(Section)</th>
                                        <th class="purchase">ID No.</th>
                                        <th class="purchase">Activate Date</th>
                                        <th class="purchase">Validity</th>
                                        <th class="purchase">Prepared By</th>
                                        <th class="purchase">Status</th>
                                        <th class="purchase">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    <tr>
                                        <td class="serial">01</td>
                                        <td class="serial">Wade Warren</td>
                                        <td class="serial">One (A)</td>
                                        <td class="serial">12345678</td>
                                        <td class="serial">01/02/2023</td>
                                        <td class="serial">01/02/2025</td>
                                        <td class="serial">Admin 1</td>
                                        <td class="serial">
                                            <span class="badge-basic-success-text">
                                                Active
                                            </span>
                                        </td>
                                        <td class="serial">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end ">
                                                    <li>
                                                        <a class="dropdown-item" href="#"><span class="icon mr-8"><i class="fa-solid fa-pen-to-square"></i></span>
                                                            {{ ___('common.View Certificate') }}</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);">
                                                            <span class="icon mr-8"><i class="fa-solid fa-trash-can"></i></span>
                                                            <span>{{ ___('common.Delete') }}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="serial">01</td>
                                        <td class="serial">Wade Warren</td>
                                        <td class="serial">One (A)</td>
                                        <td class="serial">12345678</td>
                                        <td class="serial">01/02/2023</td>
                                        <td class="serial">01/02/2025</td>
                                        <td class="serial">Admin 1</td>
                                        <td class="serial">
                                            <span class="badge-basic-success-text">
                                                Active
                                            </span>
                                        </td>
                                        <td class="serial">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end ">
                                                    <li>
                                                        <a class="dropdown-item" href="#"><span class="icon mr-8"><i class="fa-solid fa-pen-to-square"></i></span>
                                                            {{ ___('common.View Certificate') }}</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);">
                                                            <span class="icon mr-8"><i class="fa-solid fa-trash-can"></i></span>
                                                            <span>{{ ___('common.Delete') }}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="serial">01</td>
                                        <td class="serial">Wade Warren</td>
                                        <td class="serial">One (A)</td>
                                        <td class="serial">12345678</td>
                                        <td class="serial">01/02/2023</td>
                                        <td class="serial">01/02/2025</td>
                                        <td class="serial">Admin 1</td>
                                        <td class="serial">
                                            <span class="badge-basic-success-text">
                                                Active
                                            </span>
                                        </td>
                                        <td class="serial">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end ">
                                                    <li>
                                                        <a class="dropdown-item" href="#"><span class="icon mr-8"><i class="fa-solid fa-pen-to-square"></i></span>
                                                            {{ ___('common.View Certificate') }}</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);">
                                                            <span class="icon mr-8"><i class="fa-solid fa-trash-can"></i></span>
                                                            <span>{{ ___('common.Delete') }}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="serial">01</td>
                                        <td class="serial">Wade Warren</td>
                                        <td class="serial">One (A)</td>
                                        <td class="serial">12345678</td>
                                        <td class="serial">01/02/2023</td>
                                        <td class="serial">01/02/2025</td>
                                        <td class="serial">Admin 1</td>
                                        <td class="serial">
                                            <span class="badge-basic-success-text">
                                                Active
                                            </span>
                                        </td>
                                        <td class="serial">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end ">
                                                    <li>
                                                        <a class="dropdown-item" href="#"><span class="icon mr-8"><i class="fa-solid fa-pen-to-square"></i></span>
                                                            {{ ___('common.View Certificate') }}</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);">
                                                            <span class="icon mr-8"><i class="fa-solid fa-trash-can"></i></span>
                                                            <span>{{ ___('common.Delete') }}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="serial">01</td>
                                        <td class="serial">Wade Warren</td>
                                        <td class="serial">One (A)</td>
                                        <td class="serial">12345678</td>
                                        <td class="serial">01/02/2023</td>
                                        <td class="serial">01/02/2025</td>
                                        <td class="serial">Admin 1</td>
                                        <td class="serial">
                                            <span class="badge-basic-success-text">
                                                Active
                                            </span>
                                        </td>
                                        <td class="serial">
                                            <div class="dropdown dropdown-action">
                                                <button type="button" class="btn-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end ">
                                                    <li>
                                                        <a class="dropdown-item" href="#"><span class="icon mr-8"><i class="fa-solid fa-pen-to-square"></i></span>
                                                            {{ ___('common.View Certificate') }}</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0);">
                                                            <span class="icon mr-8"><i class="fa-solid fa-trash-can"></i></span>
                                                            <span>{{ ___('common.Delete') }}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--  table end -->
                    </div>
                </div>
            </div>
            <!--  table content end -->
        </form>
    </div>

</div>
@endsection