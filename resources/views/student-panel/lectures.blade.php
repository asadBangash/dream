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
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Teacher</th>
                            <th>Download / Watch</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data['lectures'] as $row)
                            <tr>
                                <td>{{ $row->subject->name ?? '—' }}</td>
                                <td>{{ $row->title }}</td>
                                <td>{{ strtoupper($row->lecture_type) }}</td>
                                <td>{{ trim(($row->staff->first_name ?? '').' '.($row->staff->last_name ?? '')) }}</td>
                                <td>
                                    @if ($row->upload)
                                        <a class="btn btn-sm ot-btn-primary" href="{{ globalAsset($row->upload->path) }}" target="_blank">Download</a>
                                    @endif
                                    @if ($row->video_url)
                                        <a class="btn btn-sm ot-btn-secondary" href="{{ $row->video_url }}" target="_blank">Video</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center">No lectures uploaded for your class yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
