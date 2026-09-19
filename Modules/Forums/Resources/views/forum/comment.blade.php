<div class="comment m-3">
    <div class="d-flex align-items-start">
        <img src="{{ @globalAsset($comment->publisher->upload->path, '40X40.webp') }}" alt="User"
             class="rounded-circle me-2" style="width: 40px; height: 40px;">
        <div>
            <h6 class="mb-1">{{ $comment->publisher->name }}</h6>
            <p class="mb-1">{{ $comment->comment }}</p>
            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
            @if(auth()->user()->role_id == \App\Enums\RoleEnum::SUPERADMIN)
                <a href="javascript:void(0);" onclick="delete_row('forums/comment-delete', {{ @$comment->id }}, true)"
                   class="text-danger font-size-12 ms-2">Delete</a>
            @endif
            {{-- @if($comment->published_by != auth()->id()) --}}
                <a href="javascript:void(0);" onclick="toggleReplyForm({{ $comment->id }})"
                   class="text-primary font-size-12 ms-2">Reply</a>
            {{-- @endif --}}
        <!-- Display replies recursively -->
            @if($comment->replies)
                <div class="replies mt-3 ps-4">
                    @foreach($comment->replies as $reply)
                        @include('forums::.forum.comment', ['comment' => $reply])
                    @endforeach
                </div>
            @endif
        <!-- Reply form -->
            <form action="{{ route('forum.comment.reply') }}" method="POST" class="reply-form mt-2"
                  id="reply-form-{{ $comment->id }}" style="display: none;">
                @csrf
                <input type="hidden" name="forum_post_id" value="{{ $forum->id }}">
                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                <div class="d-flex">
                    <textarea name="comment" class="form-control me-2" rows="1"
                              placeholder="Write a reply..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-sm mt-3">Reply</button>
            </form>
        </div>
    </div>
</div>
