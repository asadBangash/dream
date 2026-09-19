@foreach($admins as $admin)
    @php
        $seenClass = '';
        if(!empty($admin->lastMessage)){
            if (@$admin->lastMessage->is_seen == false){
                $seenClass = 'has-unread-message';
            }
        }
    @endphp
    <a class="single-chat @if ($admin->id == $user_id)  active @endif {{ $seenClass }}"
       href="{{ route('instructor_livechat.chat', encryptFunction($admin->id)) }}" id="receiver_id_{{ $admin->id }}">
        <div class="chat-cap">
            <div class="user-img">
                <img src="{{ @globalAsset(@$admin->upload->path, '40X40.webp') }}" height="44" width="44" alt="img" class="img-cover">
            </div>
            <div class="user-chat-caption">
                <h5 class="user-name">{{ @$admin->name }}</h5>
                <p class="chat">{{ @$admin->lastMessage->message ?? 'No Message' }}</p>
            </div>
        </div>
        @if ($admin->lastMessage && $admin->unreadMessages->count() > 0)
            <div class="chat-timer mb-10">
                <span class="time">{{ $admin->lastMessage->created_at->diffForHumans() }}</span>
                <span class="chat-count">{{ $admin->unreadMessages->count() }}</span>
            </div>
        @endif
    </a>
@endforeach

@foreach ($users ?? [] as $user)
    @php
        $seenClass = '';
        if(!empty($user->lastMessage)){
            if (@$user->lastMessage->is_seen == false){
                $seenClass = 'has-unread-message';
            }
        }
    @endphp
    <a class="single-chat @if ($user->id == $user_id)  active @endif {{ $seenClass }}"
        href="{{ route('instructor_livechat.chat', encryptFunction($user->user_id)) }}" id="receiver_id_{{ $user->user_id }}">
        <div class="chat-cap">
            <div class="user-img">
                <img src="{{ @globalAsset(@$user->upload->path, '40X40.webp') }}" alt="img" class="img-cover">
            </div>
            <div class="user-chat-caption">
                <h5 class="user-name">{{ @$user->first_name }} {{ @$user->last_name }}</h5>
                <p class="chat">{{ @$user->lastMessage->message ?? 'No Message' }}</p>
            </div>
        </div>
        @if ($user->lastMessage && $user->unreadMessages->count() > 0)
            <div class="chat-timer mb-10">
                <span class="time">{{ $user->lastMessage->created_at->diffForHumans() }}</span>
                <span class="chat-count">{{ $user->unreadMessages->count() }}</span>
            </div>
        @endif
    </a>

    @if($user->parent)
    <a class="single-chat ms-3 @if ($user->parent->id == $user_id)  active   @endif "
       href="{{ route('instructor_livechat.chat', ['id' => encryptFunction($user->parent->id), 'user' => 'guardian']) }}">
        <div class="chat-cap">
            <div class="user-img">
                <img src="{{ @globalAsset(@$user->parent->upload->path, '40X40.webp') }}" alt="img" class="img-cover">
            </div>
            <div class="user-chat-caption">
                <h5 class="user-name">{{ @$user->parent->guardian_name }}</h5>
                <p class="chat">{{ @$user->parent->lastMessage->message ?? 'No Message' }}</p>
            </div>
        </div>
        @if ($user->parent->lastMessage && $user->parent->unreadMessages->count() > 0)
            <div class="chat-timer mb-10">
                <span class="time">{{ $user->parent->lastMessage->created_at->diffForHumans() }}</span>
                <span class="chat-count">{{ $user->parent->unreadMessages->count() }}</span>
            </div>
        @endif
    </a>
    @endif
@endforeach
