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
                            <li class="breadcrumb-item" aria-current="page"><a
                                    href="{{ route('student.index') }}">{{ ___('student_info.student_list') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ ___('common.add_new') }}</li>
                        </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}
        <div class="card ot-card">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body">
                <form action="{{ route('student.importSubmit') }}" enctype="multipart/form-data" method="post"
                    id="visitForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <div class="row">

                                <!-- Notice Section -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <code
                                        class="text-danger">{{ ___('student_info.Must be follw below instructions & Before Inserting data please download sample file and fill it as required') }}</code>
                                    <div>
                                        <a href="{{ route('student.sampleDownload') }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-download"></i> {{ ___('student_info.Sample File') }}
                                        </a>
                                    </div>
                                </div>

                                <!-- Instructions List -->

                                <code> {{ ___('student_info.Guardian Email must be unique') }}</code>

                                <code> {{ ___('student_info.Email must be unique') }}</code>

                                <code> {{ ___('student_info.Religion') }}: 1 = Islam, 2
                                    = Hindu, 3 = Christian</code>

                                <code>{{ ___('student_info.Gender') }}: 1 = Male, 2 =
                                    Female</code>

                                <code>{{ ___('student_info.Blood') }}: 1 = A+, 2 = A-,
                                    3 = B+, 4 = B-, 5 = O+, 6 = O-, 7 = AB+, 8 = AB-</code>

                                <code>
                                    {{ ___('student_info.Student Category') }}:
                                    @foreach ($data['categories'] as $key => $item)
                                        {{ $item->id }} = {{ $item->name }}
                                    @endforeach
                                </code>

                                <code>
                                    {{ ___('student_info.Attend School Previously') }}: 1 = Yes, 0 = No
                                </code>


                            </div>

                            <div class="row mt-10">
                                <div class="col-md-4">

                                    <label for="validationServer04" class="form-label">{{ ___('student_info.class') }}
                                        <span class="fillable">*</span></label>
                                    <select id="getSections"
                                        class="nice-select niceSelect bordered_style wide @error('class') is-invalid @enderror"
                                        name="class" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_class') }}</option>
                                        @foreach ($data['classes'] as $item)
                                            <option {{ old('class') == $item->id ? 'selected' : '' }}
                                                value="{{ $item->class->id }}">{{ $item->class->name }}
                                        @endforeach
                                        </option>
                                    </select>

                                    @error('class')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <div class="col-md-4">
                                    <label for="validationServer04" class="form-label">{{ ___('student_info.section') }}
                                        <span class="fillable">*</span></label>
                                    <select id="getSections"
                                        class="nice-select sections niceSelect bordered_style wide @error('section') is-invalid @enderror"
                                        name="section" id="validationServer04"
                                        aria-describedby="validationServer04Feedback">
                                        <option value="">{{ ___('student_info.select_section') }}</option>
                                    </select>
                                    @error('section')
                                        <div id="validationServer04Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>


                                <div class="col-md-4">
                                    <label for="exampleDataList" class="form-label ">{{ ___('common.File') }}
                                        {{ ___('common.(100 x 100 px)') }}<span class="fillable"> *</span></label>
                                    <div class="ot_fileUploader left-side mb-0">
                                        <input class="form-control" type="text" placeholder="{{ ___('common.File') }}"
                                            readonly="" id="placeholder">
                                        <button class="primary-btn-small-input" type="button">
                                            <label class="btn btn-lg ot-btn-primary"
                                                for="fileBrouse">{{ ___('common.browse') }}</label>
                                            <input type="file" class="d-none form-control" name="file"
                                                id="fileBrouse">
                                        </button>
                                    </div>
                                    @error('file')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-md-12 mt-24">
                                    <div class="text-end">
                                        <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                            </span>{{ ___('common.submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            var fileInp1 = document.getElementById("fileBrouse1");
            if (fileInp1) {
                fileInp1.addEventListener("change", showFileName);

                function showFileName(event) {
                    var fileInp = event.srcElement;
                    var fileName = fileInp.files[0].name;
                    document.getElementById("placeholder1").placeholder = fileName;
                }
            }

            function checkCheckboxState() {
                var isChecked = $('#previous_school').prop('checked');
                console.log(isChecked)
                if (isChecked) {
                    $('#previous_school_info').removeClass('d-none');
                    $('#previous_school_doc').removeClass('d-none');
                } else {
                    $('#previous_school_info').addClass('d-none');
                    $('#previous_school_doc').addClass('d-none');
                }
            }

            $('#previous_school').change(checkCheckboxState);
            checkCheckboxState();
        });
    </script>
@endpush
