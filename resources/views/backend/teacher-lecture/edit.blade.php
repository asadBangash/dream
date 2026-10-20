@extends('backend.master')
@section('title')
    {{ $data['title'] }}
@endsection
@section('content')
    <div class="page-content">
        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('teacher-lecture.update', $data['lecture']->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('backend.teacher-lecture.partials.form-fields', ['lecture' => $data['lecture'], 'sections' => $data['sections'], 'subjects' => $data['subjects']])
                    <button type="submit" class="btn ot-btn-primary">{{ ___('common.update') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
