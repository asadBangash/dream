@extends('installer::layouts.app_install', ['title' => @$data['title']])
@section('title', $data['title'])
@section('content')
    <div class="single-report-admit">
        <div class="card-header">
            <h2 class="text-center text-uppercase color-whitesmoke">{{ $title ?? ___('common.Error') }}
            </h2>
        </div>
    </div>
    <div class="card-body">
        <p class="text-center">
            {{ $message }}
        </p>
        <a href="{{ url('/') }}" class="offset-3 col-sm-6 primary-btn fix-gr-bg mt-40 mb-20">
            {{ ___('installer.Go Home') }} </a>
    </div>
@stop
