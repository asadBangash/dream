@extends('backend.master')
@section('title')
    {{ $data['title'] }}
@endsection
@section('content')
    <div class="page-content">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="bradecrumb-title mb-1">{{ $data['title'] }}</h4>
                </div>
                <div class="col-sm-6 text-end">
                    @if (hasPermission('teacher_lecture_create'))
                        <a href="{{ route('teacher-lecture.create') }}" class="btn ot-btn-primary">{{ ___('common.add') }}</a>
                    @endif
                </div>
            </div>
        </div>
        @if (!empty($data['lectures_table_missing']))
            <div class="alert alert-warning">
                Lecture upload requires the <code>teacher_lectures</code> database table. On the server run:
                <code>php artisan migrate --path=database/migrations/tenant --force</code>
            </div>
        @endif
        <div class="card ot-card">
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Subject</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data['lectures'] as $key => $row)
                            <tr>
                                <td>{{ $data['lectures']->firstItem() + $key }}</td>
                                <td>{{ $row->title }}</td>
                                <td>{{ $row->class->name ?? '—' }}</td>
                                <td>{{ $row->section->name ?? '—' }}</td>
                                <td>{{ $row->subject->name ?? '—' }}</td>
                                <td>{{ strtoupper($row->lecture_type) }}</td>
                                <td>
                                    @if (hasPermission('teacher_lecture_update'))
                                        <a href="{{ route('teacher-lecture.edit', $row->id) }}" class="btn btn-sm ot-btn-primary"><i class="fa fa-edit"></i></a>
                                    @endif
                                    @if (hasPermission('teacher_lecture_delete'))
                                        <button class="btn btn-sm ot-btn-danger" onclick="delete_row('teacher-lecture/delete', {{ $row->id }})"><i class="fa fa-trash"></i></button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center">No lectures yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                {!! $data['lectures']->links() !!}
            </div>
        </div>
    </div>
@endsection
