@extends('student-panel.partials.master')
@section('title')
    {{ @$title }}
@endsection
@push('css')
        <style>
            .file-upload-container {
                border: 2px dashed #ccc;
                padding: 20px;
                text-align: center;
                position: relative;
                border-radius: 5px;
                margin: 2px auto;
                font-family: Arial, sans-serif;
            }

            /* Label for the file input */
            .file-upload-label {
                display: flex;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                cursor: pointer;
            }

            /* Icon */
            .file-upload-label i {
                font-size: 40px;
                color: #888;
            }

            /* Button for browsing files */
            .browse-btn {
                background-color: #6c757d;
                color: white;
                padding: 8px 12px;
                margin-top: 8px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            .browse-btn:hover {
                background-color: #5a6268;
            }

            /* File count display */
            .file-count {
                position: absolute;
                top: 10px;
                right: 10px;
                font-size: 14px;
                color: #666;
            }

            /* Preview container */
            .file-preview {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 15px;
                justify-content: start;
            }

            /* Preview box for each file */
            .file-preview-item {
                position: relative;
                width: 100px;
                text-align: center;
                font-size: 12px;
            }

            /* Image preview */
            .file-preview-item img {
                width: 100px;
                height: 80px;
                object-fit: cover;
                border-radius: 4px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            }

            /* Icon for non-image files */
            .file-preview-item .file-icon {
                font-size: 40px;
                color: #888;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 100px;
                height: 80px;
            }

            /* Close button for each file */
            .file-preview-item .close-btn {
                position: absolute;
                top: -8px;
                right: -8px;
                background-color: #dc3545;
                color: white;
                border: none;
                border-radius: 50%;
                width: 20px;
                height: 20px;
                font-size: 12px;
                cursor: pointer;
            }

        </style>
@endpush
@section('content')
    <div class="page-content">

        {{-- bradecrumb Area S t a r t --}}
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="bradecrumb-title mb-1">{{ $title }}</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('common.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student-panel-memory.index') }}">{{ ___('common.Memories') }}</a>
                        </li>
                        <li class="breadcrumb-item">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div>
        {{-- bradecrumb Area E n d --}}

    <!--  table content start -->
        <div class="table-content table-basic mt-20">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $title }}</h4>
                        <a href="{{ route('student-panel-memory.index') }}" class="btn btn-lg ot-btn-primary">
                            <span><i class="fa-solid fa-arrow-left"></i> </span>
                            <span class="">{{ ___('common.Back') }}</span>
                        </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('student-panel-memory.store') }}" class="row" method="post" enctype="multipart/form-data">
                        @csrf()
                        <div class="col-lg-3">
                            <label for="title" class="form-label">{{ ___('common.Title') }} <span class="fillable">*</span></label>
                            <input name="title" id="title" placeholder="{{ ___('common.Title') }}"
                                   class="email form-control ot-input mb_30" type="text" value="{{ old('title') }}">
                                   @error('title')  <span class="text-danger">{{ $message }}</span> @enderror

                        </div>
                        <div class="col-md-3">
                            <label for="exampleDataList" class="form-label ">{{ ___('common.Feature Image') }}<span class="fillable">*</span></label>
                            <div class="ot_fileUploader left-side mb-3">
                                <input class="form-control" type="text"
                                       placeholder="{{ ___('common.image') }}" readonly="" id="placeholder">
                                <button class="primary-btn-small-input" type="button">
                                    <label class="btn btn-lg ot-btn-primary"
                                           for="fileBrouse">{{ ___('common.browse') }}</label>
                                    <input type="file" class="d-none form-control" name="image"
                                           id="fileBrouse" accept="image/*">
                                </button>
                            </div>
                            @error('image')  <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-12 mt-20">
                            <label for="title" class="form-label mb-4">{{ ___('common.Gallery Images') }}</label>
                            <div class="file-upload-container">
                                <label class="file-upload-label" for="file-input">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Drag & Drop Files Here or</span>
                                    <span type="button" class="browse-btn">Browse Files</span>
                                </label>
                                <input type="file" class="d-none" id="file-input" name="gallery_images[]" multiple accept="image/*" onchange="handleFiles(this)">
                                <span class="file-count">0 of 10</span>
                            </div>
                            <div id="file-preview" class="file-preview"></div>
                            @error('gallery_images') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-md-12 mt-24">
                            <div class="text-end">
                                <button class="btn btn-lg ot-btn-primary"><span><i class="fa-solid fa-save"></i>
                                    </span>Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endsection


        @push('script')
            <script>
                function handleFiles(input) {
                    const previewContainer = document.getElementById('file-preview');
                    const fileCount = document.querySelector('.file-count');
                    previewContainer.innerHTML = ''; // Clear previous previews

                    const files = Array.from(input.files);
                    fileCount.textContent = `${files.length} of 10`; // Update file count

                    files.forEach((file, index) => {
                        const previewItem = document.createElement('div');
                        previewItem.classList.add('file-preview-item');

                        // Check file type
                        if (file.type.startsWith('image/')) {
                            const img = document.createElement('img');
                            img.src = URL.createObjectURL(file);
                            previewItem.appendChild(img);
                        } else {
                            const fileIcon = document.createElement('div');
                            fileIcon.classList.add('file-icon');
                            fileIcon.textContent = `.${file.name.split('.').pop().toUpperCase()}`;
                            previewItem.appendChild(fileIcon);
                        }

                        // Close button
                        const closeBtn = document.createElement('button');
                        closeBtn.classList.add('close-btn');
                        closeBtn.innerHTML = '&times;';
                        closeBtn.onclick = () => {
                            previewItem.remove();
                            fileCount.textContent = `${--input.files.length} of 10`;
                        };
                        previewItem.appendChild(closeBtn);

                        previewContainer.appendChild(previewItem);
                    });
                }

            </script>
    @endpush




