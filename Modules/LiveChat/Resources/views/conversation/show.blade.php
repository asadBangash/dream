@extends('backend.master')
@section('title', @$data['title'])
@push('css')
    <link rel="stylesheet" href="{{ asset('modules/livechat/css/app.css') }}">
    <style>
        .chat-box-area .chat-body {
            height: auto !important;
            overflow-y: auto;
        }

        .current-chat-user {
            height: 80px;
        }
    </style>
@endpush
@section('content')

    <!-- Chat box Area two s t a r t-->
    <div class="chat-box-area card card-body">
        <div class="row">
            <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-5 col-sm-5">
                <!-- Chat left side-bar -->
                <div class="chat-left-sidebar">
                    <!-- Admin Profile -->
                    <div class="chat-admin">
                        <!-- Profile -->
                        <div class="profile-wrap">
                            <div class="user-img">
                                <img height="40" width="40"
                                    src="{{ @globalAsset(auth()->user()->upload->path, '40X40.webp') }}" alt="img"
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
                            <input class="form-control ot-input" type="text" id="chat_search"
                                onkeyup="searchConversation()" placeholder="{{ ___('live_chat.Search') }}">
                        </div>
                        <strong>Conversations</strong>
                        <div class="chat-list" id="conversationList">

                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xxl-9 col-xl-8 col-lg-6 col-md-7 col-sm-7">
                <!-- curren-chat-user -->
                <div class="current-chat-user pb-2">
                    <div class="chat-cap d-flex gap-3 mb-3 align-items-center">
                        <div class="users position-relative me-3">
                            <div class="user-img position-absolute border border-secondary">
                                <img src="{{ @globalAsset(@$user1->upload->path ?? '', '40X40.webp') }}" height="40"
                                    width="40" alt="img" class="img-cover first">
                            </div>
                            <div class="user-img position-absolute border border-secondary ms-3 mt-3 shadow-sm">
                                <img src="{{ @globalAsset($user2->upload->path ?? '', '40X40.webp') }}" height="40"
                                    width="40" alt="img" class="img-cover second">
                            </div>
                        </div>
                        <div class="user-chat-caption ms-5">
                            <h3 class="mb-0">{{ $user1->name . ' - ' . $user2->name }}</h3>
                        </div>
                    </div>
                </div>
                <!-- End-of Show product -->
                <div class="chat-body">

                    <!-- MessageBox -->
                    <div class="chatBox-message">
                        <div class="chatShow">
                            <!-- userMessage -->
                            @foreach ($messages as $message)
                                <!-- adminMessage -->
                                @if ($user1->id == $message->sender->id)
                                    <div class="single-chat adminMessage sender" id="message-{{ $message->id }}">
                                        <div class="chatText">
                                            <div class="chatImg">
                                                <img src="{{ @globalAsset(@$message->sender->upload->path, '40X40.webp') }}"
                                                    alt="img" class="img-cover">
                                            </div>
                                            <div class="chatCaption">
                                                <p>{{ $message->sender->name }}</p>
                                                <p class="chatPera">
                                                    {{ $message->message }}
                                                </p>
                                                <small class="time">
                                                    {{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</small>
                                            </div>

                                        </div>
                                    </div>
                                @else
                                    <div class="single-chat userMessage receiver" id="message-{{ $message->id }}">
                                        <div class="chatText">
                                            <div class="chatImg">
                                                <img src="{{ @globalAsset(@$message->receiver->upload->path, '40X40.webp') }}"
                                                    alt="img" class="img-cover">
                                            </div>
                                            <div class="chatCaption">
                                                <p>{{ $message->sender->name }}</p>
                                                <p class="chatPera">
                                                    {{ $message->message }}
                                                </p>
                                                <small class="time">
                                                    {{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</small>
                                            </div>

                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End-of Chat Box Area -->

@endsection

@push('script')
    <script>
        $(document).ready(function() {
            getConversationList();
        });

        function searchConversation() {
            let query = $('#chat_search').val();
            getConversationList(query);
        }

        function getConversationList(query) {
            $.ajax({
                url: "{{ route('admin.livechat.conversation_list') }}",
                type: 'GET',
                data: {
                    search: query
                },
                success: function(response) {
                    $('#conversationList').html(response.data.html);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
    </script>
@endpush
