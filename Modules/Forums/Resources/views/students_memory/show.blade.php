@extends('student-panel.partials.master')
@section('title')
    {{ @$title }}
@endsection
@push('css')
    <style>
        .memory-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
        }

        .memory-item {
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .memory-item.large {
            grid-column: span 2;
            grid-row: span 2;
        }

        .memory-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .memory-item button.close-btn {
            position: absolute;
            top: 0;
            right: 0;
            background: red;
            color: white;
        }
    </style>
@endpush
@section('content')
    <div class="page-content">
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
        <div class="table-content table-basic mt-20">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>{{ ___('memory.Memory Details') }}</h4>
                        <a href="{{ route('student-panel-memory.index') }}" class="btn btn-lg ot-btn-primary">
                            <span><i class="fa-solid fa-arrow-left"></i> </span>
                            <span class="">{{ ___('common.Back') }}</span>
                        </a>
                </div>
                <div class="card-body">
                    <h3>{{ $memory->title }}</h3>
                    <div class="memory-grid mt-3">
                        <div class="memory-item large">
                            <img src="{{ @globalAsset($memory->feature_image->path) }}" alt="Feature Image" class="img-fluid">
                        </div>
                        @foreach($memory->galleries as $gallery)
                            <div class="memory-item small">
                                <img src="{{ @globalAsset($gallery->image->path) }}" alt="Gallery Image" class="img-fluid">
                                <button type="button" onclick="delete_row('student/memories/image/delete', {{ @$gallery->id }}, true)" class="close-btn">×</button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    @include('backend.partials.delete-ajax')
@endpush






