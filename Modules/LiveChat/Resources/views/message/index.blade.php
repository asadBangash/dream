@extends('backend.master')
@section('title')
    {{ @$data['title'] }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('modules/livechat/css/app.css') }}">
@endpush
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
        <input type="text" hidden id="receiver_id" value="{{ encryptFunction(auth()->id()) }}">
        <input type="text" hidden id="app_key" value="{{ env('PUSHER_APP_KEY') }}">
        <audio id="message_sound">
            <source src="{{ asset('modules/livechat/file/sound.mp3') }}" type="audio/mpeg">
        </audio>

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
                    <div class="chat-body">
                        <!-- curren-chat-user -->
                        <div class="current-chat-user">
                            <div class="chat-cap">
                                <div class="user-img">
                                    <img src="{{ @showImage($data['user']->image->original) }}" alt="img"
                                        class="img-cover">
                                </div>
                                <div class="user-chat-caption" id="current_user"
                                    data-id="{{ encryptFunction($data['user']->id) }}">
                                    <h5><a href="javascript:;" class="user-name">{{ $data['user']->name }}</a></h5>
                                </div>
                            </div>

                        </div>
                        <!-- End-of Show product -->
                        <!-- MessageBox -->
                        <div class="chatBox-message">
                            <div class="chatShow">
                                <!-- userMessage -->

                                @foreach ($data['messages'] as $message)
                                    <!-- adminMessage -->
                                    @if (@$message->sender->id == auth()->user()->id)
                                        <div class="single-chat adminMessage" id="message-{{ $message->id }}">
                                            <div class="chatText">
                                                <div class="chatImg">
                                                    <img src="{{ @showImage(@$message->sender->image->original) }}"
                                                        alt="img" class="img-cover">
                                                </div>
                                                <div class="chatCaption">
                                                    <p class="chatPera"> {{ $message->message }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="single-chat userMessage" id="message-{{ $message->id }}">
                                            <div class="chatText">
                                                <div class="chatImg">
                                                    <img src="{{ @showImage(@$message->receiver->image->original) }}"
                                                        alt="img" class="img-cover">
                                                </div>
                                                <div class="chatCaption">
                                                    <p class="chatPera">{{ $message->message }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach


                            </div>
                            <!-- chatSend input box-->
                            <div class="chatSend-wrapper">
                                <div class="sendMessage">
                                    <input class="input" type="text" id="chat_text" name="chat"
                                        placeholder="Write your chat...">
                                    <div class="btn-wrapper form-icon">
                                        <button class="btn-rounded2" type="submit" name="submit" id="message_sent"
                                            data-url="{{ route('livechat.store', encryptFunction($data['user']->id)) }}">{{ ___('live_chat.Send') }}</button>
                                    </div>
                                </div>
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
