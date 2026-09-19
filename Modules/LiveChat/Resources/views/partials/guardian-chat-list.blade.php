
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
        href="{{ route('guardian_livechat.chat', encryptFunction(@$user->user_id)) }}" id="receiver_id_{{ $user->user_id }}">
        <div class="chat-cap d-flex gap-3">
            <div class="user-img">
                <img src="{{ @globalAsset($user->upload->path) }}" height="40" width="40" alt="img" class="img-cover">
            </div>
            <div class="user-chat-caption">
                <h5 class="user-name mb-0">{{ @$user->first_name }} {{ @$user->last_name }}</h5>
                <p class="chat">{{ @$user->lastMessage->message ?? 'No Message' }}</p>
            </div>
        </div>
        @if (@$user->lastMessage && @$user->unreadMessages->count() > 0)
            <div class="chat-timer mb-10">
                <span class="time">{{ @$user->lastMessage->created_at->diffForHumans() }}</span>
                <span class="chat-count">{{ @$user->unreadMessages->count() }}</span>
            </div>
        @endif
    </a>
@endforeach
{{-- Single Chat --}}
