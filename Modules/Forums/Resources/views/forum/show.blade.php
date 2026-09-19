@extends('backend.master')
@section('title')
    {{ @$title }}
@endsection
@section('content')
    <div class="page-content">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="bradecrumb-title mb-1">{{ $title }}</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ ___('common.home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('forum.index') }}">{{ ___('common.Forums') }}</a>
                        </li>
                        <li class="breadcrumb-item">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="table-content table-basic mt-20">
            <div class="card">
                <div class="card-header d-flex justify-content-end align-items-center">
                    @if (hasPermission('forum_list'))
                        <a href="{{ route('forum.index') }}" class="btn btn-lg ot-btn-primary">
                            <span><i class="fa-solid fa-arrow-left"></i> </span>
                            <span class="">{{ ___('common.Back') }}</span>
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    <img class="img-fluid" src="{{ @globalAsset($forum->upload->path) }}" alt="">
                    <div class="mt-3">
                        {!! $forum->description !!}
                    </div>
                </div>
                <div class="card-footer">
                    <div class="comments mt-10">
                        <h5>
                            <i class="fa fa-comment"></i> {{ ___('common.Comments') }} ({{ @$forum->commentsAndReply()->count() }})
                        </h5>
                        @foreach($forum->comments->where('parent_id', null) as $comment)
                            @include('forums::forum.comment', ['comment' => $comment])
                        @endforeach
                        <form action="{{ route('forum.comment.store') }}" method="POST"
                            class="comment-form mt-2" id="comment-form-{{ $forum->id }}" >
                            @csrf
                            <input type="hidden" name="forum_post_id" value="{{ $forum->id }}">
                            <div class="d-flex">
                                <textarea name="comment" class="form-control me-2" rows="1" placeholder="Write a comment..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm mt-3">{{ ___('common.Comment') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    @include('backend.partials.delete-ajax')
    <script>
        function toggleReplyForm(commentId) {
            const form = document.getElementById(`reply-form-${commentId}`);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
@endpush






