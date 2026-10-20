@extends('student-panel.partials.master')
@section('title')
    {{ $data['title'] }}
@endsection
@section('content')
    <div class="page-content">
        <div class="page-header">
            <h4>{{ $data['title'] }}</h4>
        </div>
        <div class="card ot-card">
            <div class="card-body">
                @forelse ($data['notifications'] as $note)
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-1">{{ $note->title }}</h6>
                            <small class="text-muted">{{ $note->created_at->format('M j, Y H:i') }}</small>
                        </div>
                        <p class="mb-2">{{ $note->message }}</p>
                        @if ($note->url)
                            <a href="{{ route('viewNotification', $note->id) }}" class="btn btn-sm ot-btn-primary">View details</a>
                        @endif
                    </div>
                @empty
                    <p class="text-center text-muted mb-0">No notifications yet.</p>
                @endforelse
                {!! $data['notifications']->links() !!}
            </div>
        </div>
    </div>
@endsection
