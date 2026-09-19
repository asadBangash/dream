@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection


@section('content')
    <div class="page-content">

        {{-- breadecrumb Area S t a r t --}}
        @include('backend.ui-components.breadcrumb', [
            'title' => @$data['title'],
            'routes' => [
                route('dashboard') => ___('common.Dashboard'),
                '#' => @$data['title'],
            ],

            'buttons' => 1,
        ])
        {{-- breadecrumb Area E n d --}}

        <!-- Chat box Area two s t a r t-->
        <div class="chat-box-area card-body">
            <div class="row">
                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-5 col-sm-5">
                    <!-- Chat left side-bar -->
                    <div class="chat-left-sidebar">
                        <!-- Admin Profile -->
                        <div class="chat-admin">
                            <!-- Profile -->
                            <div class="profile-wrap">
                                <div class="user-img">
                                    <img src="{{ @showImage(auth()->user()->image->original) }}" alt="img"
                                        class="img-cover">
                                </div>
                                <div class="user-chat-caption">
                                    <h5 class="user-name">{{ auth()->user()->name }}</h5>
                                    <p class="chat-status">{{ ___('live_chat.Active') }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- My Listings -->
                        <div class="chat-list-wrapper ">
                            <div class="search-chat mb-20">
                                <input class="form-control ot-input" type="text" id="chat_search" onkeyup="searchChat()"
                                    placeholder="{{ ___('live_chat.Search') }}">
                            </div>
                            <div class="chat-list" data-url="{{ route('livechat.chat_list') }}">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xxl-9 col-xl-8 col-lg-6 col-md-7 col-sm-7">
                    <div class="chat-body text-center">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="login-image ">
                                <img src="{{ @showImage(gallery('live_chat'), 'modules/livechat/img/greetings.png') }}"
                                    alt="img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End-of Chat Box Area -->
    </div>
@endsection
@push('script')
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="{{ asset('modules/livechat/js/app.js') }}"></script>
@endpush
