@php
    $lecture = $lecture ?? null;
    $sections = $sections ?? collect();
    $subjects = $subjects ?? collect();
@endphp
<div class="row mb-3">
    <div class="col-md-4 mb-3">
        <label class="form-label">{{ ___('student_info.class') }} *</label>
        <select id="getSections" name="class" class="nice-select niceSelect bordered_style wide" required>
            <option value="">{{ ___('student_info.select_class') }}</option>
            @foreach ($data['classes'] as $item)
                @if ($item->class)
                    <option value="{{ $item->class->id }}" @selected(old('class', $lecture->classes_id ?? '') == $item->class->id)>{{ $item->class->name }}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">{{ ___('student_info.section') }} *</label>
        <select id="getSubjects" name="section" class="nice-select niceSelect bordered_style wide sections section" required>
            <option value="">{{ ___('student_info.select_section') }}</option>
            @foreach ($sections as $item)
                <option value="{{ $item->section->id }}" @selected(old('section', $lecture->section_id ?? '') == $item->section->id)>{{ $item->section->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">{{ ___('academic.subject') }} *</label>
        <select id="subject" name="subject" class="nice-select niceSelect bordered_style wide subjects" required>
            <option value="">{{ ___('examination.select_subject') }}</option>
            @foreach ($subjects as $item)
                <option value="{{ $item->subject->id }}" @selected(old('subject', $lecture->subject_id ?? '') == $item->subject->id)>{{ $item->subject->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Title *</label>
        <input type="text" name="title" class="form-control ot-input" value="{{ old('title', $lecture->title ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Material type *</label>
        <select name="lecture_type" class="nice-select niceSelect bordered_style wide" required>
            @foreach ($data['lectureTypes'] as $value => $label)
                <option value="{{ $value }}" @selected(old('lecture_type', $lecture->lecture_type ?? 'pdf') == $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">File (PDF / video / document)</label>
        <input type="file" name="document" class="form-control ot-input">
        @if ($lecture?->upload)
            <small><a href="{{ globalAsset($lecture->upload->path) }}" target="_blank">Current file</a></small>
        @endif
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Video URL (optional)</label>
        <input type="url" name="video_url" class="form-control ot-input" value="{{ old('video_url', $lecture->video_url ?? '') }}" placeholder="https://...">
    </div>
    <div class="col-md-12 mb-3">
        <label class="form-label">{{ ___('common.description') }}</label>
        <textarea name="description" class="form-control ot-input" rows="3">{{ old('description', $lecture->description ?? '') }}</textarea>
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label">{{ ___('common.status') }} *</label>
        <select name="status" class="nice-select niceSelect bordered_style wide">
            <option value="1" @selected(old('status', $lecture->status ?? 1) == 1)>{{ ___('common.active') }}</option>
            <option value="0" @selected(old('status', $lecture->status ?? 1) == 0)>{{ ___('common.inactive') }}</option>
        </select>
    </div>
</div>
