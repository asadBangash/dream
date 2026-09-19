@extends('installer::layouts.app_install', ['title' => @$data['title']])
@section('title', $data['title'])
@section('content')
    <!-- from section -->
    <div class="px-5 py-4 d-flex flex-column justify-content-center align-items-center gap-3 content-body">
        <img src="{{ asset($data['asset_path'] . '/') }}/images/illustration.png" alt=""
            class="img img-responsive mt-3" />
        <p class="text-center mb-3">
            {{ @$data['short_note'] }}
        </p>
        <a href="{{ route('service.checkEnvironment') }}"
            class="btn color btn-primary px-5 py-3 mb-3 align-items-center follow-next-step"> {{ @$data['button_text'] }}</a>
    </div>
@stop
