@extends('installer::layouts.app_install', ['title' => @$data['title']])
@section('title', $data['title'])
@section('content')
    <!-- from section -->

    <div class="px-5 py-4 d-flex flex-column justify-content-center align-items-center gap-3 content-body">
        <img src="{{ asset($data['asset_path'] . '/') }}/images/complete-installation.png" alt="" />
        <p class="text-center pb-3">
            {{ @$data['info'] }}
        </p>

        @if (@$data['email'] && @$data['password'])
            <p>{{ ___('instller.Email') }} : {{ @$data['email'] }}</p>
            <p>{{ ___('instller.Password') }} : {{ @$data['password'] }}</p>
        @endif
        <a href="{{ url('/') }}" class="btn color mb-3 btn-primary px-5 py-3 align-items-center">
            {{ ___('installer.Go Home') }} </a>
    </div>
@stop
