@foreach ($users as $user)
    @php
        $seenClass = '';
        if(!empty($user->lastMessage)){
            if (@$user->lastMessage->is_seen == false){
                $seenClass = 'has-unread-message';
            }
        }
    @endphp

    <a class="single-chat  @if ($user->id == $user_id) active @endif {{ $seenClass }}"
       id="receiver_id_{{ $user->id }}"
        href="{{ route('admin_livechat.chat', encryptFunction(@$user->id)) }}">
        <div class="chat-cap d-flex gap-3">
            <div class="user-img">
                <img src="{{ @globalAsset(@$user->upload->path) }}" height="44" width="44" alt="img" class="img-cover">
            </div>
            <div class="user-chat-caption">
                <h5 class="user-name mb-0">{{ @$user->name }}</h5>
                <p class="chat">{{ @$user->lastMessage->message ?? 'No Message' }}</p>
            </div>
        </div>
        @if (@$user->lastMessage && @$user->unreadMessages->count() > 0)
            <div class="chat-timer mb-10">
                <span class="time">{{ @$user->lastMessage->created_at->diffForHumans() }}</span>
                <span class="chat-count">{{ @$user->unreadMessages->count() }}</span>
            </div>
            @else
            <div class="chat-timer mb-10">
                <span class="chat-count bg-transparent text-primary"></span>
            </div>
        @endif
    </a>
@endforeach
{{-- Single Chat --}}
