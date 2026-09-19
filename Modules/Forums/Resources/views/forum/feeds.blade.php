@extends('backend.master')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Feeds</h2>

        <div class="row">
            <div class="col-md-8 mx-auto">
                @foreach ($feeds as $feed)
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-header d-flex align-items-center bg-light border-0">
                            <img src="{{ @globalAsset($feed->creator->upload->path) }}" alt="User"
                                class="rounded-circle me-3" style="width: 50px; height: 50px;">
                            <div>
                                <h5 class="card-title mb-0">{{ $feed->creator->name }}</h5>
                                <small class="text-muted">{{ $feed->created_at->diffForHumans() }}</small>
                            </div>
                        </div>

                        <div class="card-body">
                            <p class="card-text">{!! $feed->description !!}</p>

                            @if ($feed->image)
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $feed->image) }}" class="img-fluid rounded mt-3"
                                        alt="Feed Image" style="max-height: 300px; object-fit: cover;">
                                </div>
                            @endif

                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                <!-- View Details Button -->
                                <a href="{{ route('forum.show', @$feed->id) }}" class="btn btn-primary btn-sm px-4 shadow-sm rounded-pill">
                                    {{ __('Read More...') }}
                                </a>


                                <div class="d-flex align-items-center">
                                    <!-- Total Comments -->
                                    <span class="me-3 d-flex align-items-center">
                                        <i class="fas fa-comments text-primary me-1"></i>
                                        <span>{{ $feed->commentsAndReply()->count() }}</span>
                                    </span>

                                    <!-- Total Views -->
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-eye text-secondary me-1"></i>
                                        <span>{{ $feed->views_count }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </div>
@endsection
