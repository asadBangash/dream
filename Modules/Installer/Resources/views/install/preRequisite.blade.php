@extends('installer::layouts.app_install', ['title' => @$data['title']])
@section('title', $data['title'])

@section('content')

    <!-- from section -->

    <div class="row p-5">
        <h3>{{ @$data['Server-Requirements'] }}</h3>
        <hr />
        @foreach ($server_checks as $server)
            @php
                if (gv($server, 'type') == 'error' and !$has_false) {
                    $has_false = true;
                }
            @endphp
            <div class="col-md-6">
                <div class="list-item">
                    <img src="{{ asset($data['asset_path'] . '/') }}/images/{{ gv($server, 'type') == 'error' ? 'cross' : 'check' }}.svg"
                        alt="" />
                    <p class="text-{{ gv($server, 'type') == 'error' ? 'danger' : '' }}">
                        {{ gv($server, 'message') }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row px-5">
        <h3>{{ @$data['Folder-Requirements'] }}</h3>
        <hr />
        @foreach ($folder_checks as $folder)
            @php
                if (gv($folder, 'type') == 'error' and !$has_false) {
                    $has_false = true;
                }
            @endphp
            <div class="col-md-6">
                <div class="list-item">
                    <img src="{{ asset($data['asset_path'] . '/') }}/images/{{ gv($folder, 'type') == 'error' ? 'cross' : 'check' }}.svg"
                        alt="" />
                    <p class="text-{{ gv($folder, 'type') == 'error' ? 'danger' : '' }}">
                        {{ gv($folder, 'message') }}</p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="px-5 py-4 d-flex flex-column gap-3">
        @if ($has_false)
            <div class="py-3 rounded text-center px-5 btn-with-opacity system_req_err">
                <p class="px-5 all-the system_req_err_msg">
                    <b>{{ @$data['notify'] }}</b>
                </p>
            </div>
            <a href="{{ route('service.checkEnvironment') }}"
                class="btn mb-3 color btn-primary px-5 py-3 align-items-center">
                {{ ___('installer.Refresh') }} </a>
        @else
            <div class="py-3 rounded text-center px-5 btn-with-opacity">
                <p class="px-5 all-the">
                    <b>{{ @$data['success'] }}</b>
                </p>
            </div>
        @endif

        <div class="d-flex justify-content-center mt-4">
            <a href="{{ route('service.license') }}" class="btn mb-3 color btn-primary px-5 py-3 follow-next-step">
                {{ @$data['button_text'] }}</a>

        </div>
    </div>

@stop
