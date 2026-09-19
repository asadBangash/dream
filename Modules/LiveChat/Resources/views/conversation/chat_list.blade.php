@foreach ($conversations as $groupKey => $messages)
    @php
        $latestMessage = $messages->first();
        $participantIds = explode('-', $groupKey);
        $user1 = App\Models\User::find($participantIds[0]);
        $user2 = App\Models\User::find($participantIds[1]);
        $conversationTitle = $user1->name . ' - ' . $user2->name;
    @endphp
    <a href="{{ route('admin.livechat.conversation', ['conversation_id' => $groupKey]) }}" class="single-chat">
        <div class="chat-cap d-flex gap-3 mb-3">
            <div class="users position-relative me-3">
                <div class="user-img position-absolute border border-secondary">
                    <img src="{{ @globalAsset(@$user1->upload->path ?? '', '40X40.webp') }}" height="40" width="40"
                        alt="img" class="img-cover first">
                </div>
                <div class="user-img position-absolute border border-secondary ms-3 mt-3 shadow-sm">
                    <img src="{{ @globalAsset($user2->upload->path ?? '', '40X40.webp') }}" height="40"
                        width="40" alt="img" class="img-cover second">
                </div>
            </div>
            <div class="user-chat-caption ms-5">
                <h5 class="user-name mb-0">{{ $conversationTitle }}</h5>
                <p class="chat">{{ $latestMessage->message ?? 'No Message' }}</p>
                <span>{{ @$latestMessage->created_at->diffForHumans() }}</span>
            </div>
        </div>
    </a>
@endforeach
