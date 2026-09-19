@extends('backend.master')

@section('title')
    {{ @$data['title'] }}
@endsection

@section('content')
    <div class="page-content">

        {{-- breadcrumbs Area S t a r t --}}
        @include('backend.ui-components.breadcrumb', [
            'title' => @$data['title'],
            'routes' => [
                route('dashboard') => ___('common.Dashboard'),
                '#' => @$data['title'],
            ],
        
            'buttons' => 1,
        ])
        {{-- breadcrumbs Area E n d --}}

        <div class="card ot-card">
            <div class="card-body">
                <form action="{{ route('livechat.setting.update') }}" enctype="multipart/form-data" method="post" id="visitForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pusher_app_id" class="form-label ">{{ ___('live_chat.PUSHER_APP_ID') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('pusher_app_id') is-invalid @enderror"
                                name="pusher_app_id" list="datalistOptions" id="pusher_app_id"
                                value="{{ old('pusher_app_id', setting('pusher_app_id')) }}" placeholder="{{ ___('live_chat.enter_pusher_app_id') }}">
                            @error('pusher_app_id')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="pusher_app_key" class="form-label ">{{ ___('live_chat.PUSHER_APP_KEY') }} <span
                                    class="fillable">*</span></label>
                            <input class="form-control ot-input @error('pusher_app_key') is-invalid @enderror"
                                name="pusher_app_key" list="datalistOptions" id="pusher_app_key"
                                value="{{ old('pusher_app_key', setting('pusher_app_key')) }}"
                                placeholder="{{ ___('live_chat.enter_pusher_app_key') }}">
                            @error('pusher_app_key')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pusher_app_secret" class="form-label ">{{ ___('live_chat.PUSHER_APP_SECRET') }}
                                <span class="fillable">*</span></label>
                            <input class="form-control ot-input @error('pusher_app_secret') is-invalid @enderror"
                                name="pusher_app_secret" list="datalistOptions" id="pusher_app_secret"
                                value="{{ old('pusher_app_secret', setting('pusher_app_secret')) }}"
                                placeholder="{{ ___('live_chat.enter_pusher_app_secret') }}">
                            @error('pusher_app_secret')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pusher_app_cluster" class="form-label ">{{ ___('live_chat.PUSHER_APP_CLUSTER') }}
                                <span class="fillable">*</span></label>
                            <input class="form-control ot-input @error('pusher_app_cluster') is-invalid @enderror"
                                name="pusher_app_cluster" list="datalistOptions" id="pusher_app_cluster"
                                value="{{ old('pusher_app_cluster', setting('pusher_app_cluster')) }}"
                                placeholder="{{ ___('live_chat.enter_pusher_app_cluster') }}">
                            @error('pusher_app_cluster')
                                <div id="validationServer04Feedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="text-end">
                                @if (hasPermission('storage_settings_update'))
                                    <button class="btn btn-lg ot-btn-primary">{{ ___('common.update') }} </button>
                                @endif
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
