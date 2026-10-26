@extends('backend.master')
@section('title')
    {{ $data['title'] }}
@endsection
@section('content')
    <div class="page-content">
        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('teacher-lecture.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @include('backend.teacher-lecture.partials.form-fields', [
                        'lecture' => null,
                        'sections' => collect(),
                        'subjects' => collect(),
                    ])
                    <button type="submit" class="btn ot-btn-primary">{{ ___('common.submit') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
