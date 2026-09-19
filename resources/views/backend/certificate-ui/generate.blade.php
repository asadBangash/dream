@extends('backend.master')

@section('title', 'Id Card')

@section('content')
<div class="page-content">

    {{-- bradecrumb Area S t a r t --}}
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="bradecrumb-title mb-1">{{ ___('common.Id Card') }}</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('common.home') }}</a></li>
                        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('blood-groups.index') }}">{{ ___('settings.Lists') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ ___('common.Generate Id Card') }}</li>
                    </ol>
            </div>
        </div>
    </div>
    {{-- bradecrumb Area E n d --}}

    <div class="col-12">
        <form >
            @csrf
            <div class="card ot-card mb-24 position-relative z_1">
                <div class="card-header d-flex align-items-center gap-4 flex-wrap">
                    <h3 class="mb-0">{{ ___('common.Generate Certificate') }}</h3>

                    <div class="card_header_right d-flex align-items-center gap-3 flex-fill justify-content-end flex-wrap">
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
                        <div class="single_small_selectBox">
                            <select id="getSections" class="class nice-select niceSelect bordered_style wide @error('class') is-invalid @enderror" name="class">
                                <option value="Class 9">Certificate</option>
                                <option value="Class 9">Certificate</option>
                                <option value="Class 9">Certificate</option>
                            </select>
                            @error('class')
                            <div id="validationServer04Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="single_small_selectBox">
                            <select id="getSections" class="class nice-select niceSelect bordered_style wide @error('class') is-invalid @enderror" name="class">
                                <option value="Class 9">Grid Gap (px) </option>
                                <option value="Class 9">Grid Gap (px) </option>
                                <option value="Class 9">Grid Gap (px) </option>
                            </select>
                            @error('class')
                            <div id="validationServer04Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button class="btn btn-lg ot-btn-primary">
                            Generate Certificate
                        </button>
                    </div>
                </div>
            </div>
            <div class="table-content table-basic">
                <div class="card gray_card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">Id Card</h3>
                        <h3 class="mb-0">20</h3>
                    </div>
                    <div class="card-body rounded-0">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="generated_card_wrapper">
                                    <div class="card_generated_img">
                                        <img src="{{ asset('backend') }}/uploads/card-images/certificate.png" alt="">
                                    </div>
                                    <div class="card_generated_img">
                                        <img src="{{ asset('backend') }}/uploads/card-images/certificate.png" alt="">
                                    </div>
                                    <div class="card_generated_img">
                                        <img src="{{ asset('backend') }}/uploads/card-images/certificate.png" alt="">
                                    </div>
                                    <div class="card_generated_img">
                                        <img src="{{ asset('backend') }}/uploads/card-images/certificate.png" alt="">
                                    </div>
                                    <div class="card_generated_img">
                                        <img src="{{ asset('backend') }}/uploads/card-images/certificate.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection