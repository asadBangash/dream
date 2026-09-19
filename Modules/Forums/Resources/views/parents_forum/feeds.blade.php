@extends('parent-panel.partials.master')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Feeds</h2>

        <div class="row">
            <div class="col-md-12 mx-auto">
                @foreach ($feeds as $feed)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <img src="{{ @globalAsset($feed->creator->upload->path) }}" alt="User"
                                    class="rounded-circle me-3" style="width: 50px; height: 50px;">
                                <div>
                                    <h5 class="card-title mb-1">{{ $feed->creator->name }}</h5>
                                    <small class="text-muted">{{ $feed->created_at->diffForHumans() }}</small>
                                </div>
                            </div>

                            <p class="mt-3">{!! $feed->description !!}</p>

                            @if ($feed->image)
                                <img src="{{ asset('storage/' . $feed->image) }}" class="img-fluid rounded mt-2"
                                    alt="Feed Image">
                            @endif

                            <div class="mt-3 d-flex align-items-center">
                                <!-- View Details Button -->
                                <a href="{{ route('parent-panel-forum.show', @$feed->id) }}" class="btn btn-outline-secondary btn-sm me-2">
                                    <i class="fas fa-eye"></i> {{ ___('common.View Details') }}
                                </a>

                                <!-- Total Comments -->
                                <span class="me-3">
                                    <i class="fas fa-comments text-muted"></i>
                                    <span>{{ $feed->commentsAndReply()->count() }}</span>
                                </span>

                                <!-- Total Views -->
                                <span>
                                    <i class="fas fa-eye text-muted"></i>
                                    <span>{{ $feed->views_count }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $feeds->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
