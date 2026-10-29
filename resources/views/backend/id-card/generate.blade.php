@extends('backend.master')

@section('title')
{{ @$data['title'] }}
@endsection

@section('css')
    <style>
        .dream-id-print-grid {
            justify-content: flex-start;
        }
    </style>
@endsection

@section('content')
<div class="page-content">
    {{-- bradecrumb Area S t a r t --}}
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="bradecrumb-title mb-1">{{ @$data['title'] }}</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">{{ ___('common.home') }}</a></li>
                        <li class="breadcrumb-item">{{ @$data['title'] }}</li>
                    </ol>
            </div>
        </div>
    </div>
    {{-- bradecrumb Area E n d --}}
    <div class="row">
        <div class="col-12">
            <form action="{{ route('idcard.generate.search') }}" method="post" id="marksheet" enctype="multipart/form-data">
                @csrf
                <div class="card ot-card mb-24 position-relative z_1">
                    <div class="card-header d-flex align-items-center gap-4 flex-wrap">
                        <h3 class="mb-0">{{ ___('common.Filtering') }}</h3>

                        <div class="card_header_right d-flex align-items-center gap-3 flex-fill justify-content-end flex-wrap">
                            <div class="single_large_selectBox">
                                <select class="nice-select niceSelect bordered_style wide id_card @error('id_card') is-invalid @enderror" name="id_card" id="idCardTemplateSelect">
                                    <option value="">{{ ___('examination.select idcard') }} *</option>
                                    @foreach ($data['id_cards'] as $item)
                                    <option value="{{ $item->id }}" data-card-type="{{ $item->card_type ?? 'student' }}" {{ old('id_card', request('id_card')) == $item->id ? 'selected' : '' }}>
                                        {{ $item->title }} ({{ \App\Enums\IdCardType::label($item->card_type ?? 'student') }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('id_card')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="idCardStudentFilters" class="d-flex align-items-center gap-3 flex-wrap">
                            <div class="single_large_selectBox">
                                <select id="getSections" class="class nice-select niceSelect bordered_style wide @error('class') is-invalid @enderror" name="class">
                                    <option value="">{{ ___('student_info.select_class') }} *</option>
                                    @foreach ($data['classes'] as $item)
                                    <option {{ old('class', request('class')) == $item->class->id ? 'selected' : '' }} value="{{ $item->class->id }}">{{ $item->class->name }}</option>
                                    @endforeach
                                </select>
                                @error('class')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="single_large_selectBox">
                                <select class="sections section nice-select niceSelect bordered_style wide @error('section') is-invalid @enderror" name="section">
                                    <option value="">{{ ___('student_info.select_section') }} *</option>

                                </select>
                                @error('section')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>



                            <div class="single_large_selectBox">
                                <select class="students nice-select niceSelect bordered_style wide @error('student') is-invalid @enderror" name="student">
                                    <option value="">{{ ___('student_info.select_student') }}</option>

                                </select>
                            </div>

                            </div>

                            <div id="idCardTeacherFilters" class="d-none single_large_selectBox">
                                <select class="staff nice-select niceSelect bordered_style wide @error('staff') is-invalid @enderror" name="staff">
                                    <option value="">{{ ___('staff.select_staff') ?? 'All teachers / Select staff' }}</option>
                                    @foreach ($data['staffs'] ?? [] as $staff)
                                        <option value="{{ $staff->id }}" {{ old('staff', request('staff')) == $staff->id ? 'selected' : '' }}>
                                            {{ trim($staff->first_name.' '.$staff->last_name) }} @if($staff->staff_id)(#{{ $staff->staff_id }})@endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button class="btn btn-lg ot-btn-primary" type="submit">
                                {{ ___('common.Search') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if(isset($data['idcard']))
        @php
            $previewIsTeacher = idCardIsTeacher($data['idcard']);
            $previewCount = $previewIsTeacher
                ? ($data['staff_members'] ?? collect())->count()
                : ($data['students'] ?? collect())->count();
        @endphp

        <div class="col-md-12">

            <div class="preview_box_wrapper ">
                @if($previewCount > 0)
                <div class="download_print_btns">
                    <button class="btn btn-lg ot-btn-primary" onclick="printDiv('printContent')">
                        {{___('common.print_now')}}
                        <span><i class="fa-solid fa-print"></i></span>
                    </button>
                </div>
                @endif

                <div class="preview_box print-view overflow-auto">
                    <div id="printContent" class="dream-id-preview-root">
                    @include('backend.id-card.printIdCard')
                    </div>
                   
                </div>

            </div>
        </div>

        @endif

    </div>
</div>
@endsection

@push('script')
<script>
    (function () {
        var $templateSelect = $('#idCardTemplateSelect');
        var $studentFilters = $('#idCardStudentFilters');
        var $teacherFilters = $('#idCardTeacherFilters');

        window.syncIdCardGenerateFilters = function () {
            if (!$templateSelect.length) {
                return;
            }
            var $opt = $templateSelect.find('option:selected');
            var isTeacher = $opt.attr('data-card-type') === 'teacher';

            $studentFilters.toggleClass('d-none', isTeacher).toggleClass('d-flex', !isTeacher);
            $teacherFilters.toggleClass('d-none', !isTeacher);

            $studentFilters.find('select').prop('disabled', isTeacher);
            $teacherFilters.find('select').prop('disabled', !isTeacher);
        };

        $(function () {
            syncIdCardGenerateFilters();
            $(document).on('change', '#idCardTemplateSelect', syncIdCardGenerateFilters);
            $(document).on('click', '.nice-select .option:not(.disabled)', function () {
                var $select = $(this).closest('.nice-select').prev('#idCardTemplateSelect');
                if ($select.length) {
                    setTimeout(syncIdCardGenerateFilters, 0);
                }
            });

            @if(old('class', request('class')))
            if ($('#getSections').val()) {
                $('#getSections').trigger('change');
            }
            @endif
        });
    })();
</script>
@endpush