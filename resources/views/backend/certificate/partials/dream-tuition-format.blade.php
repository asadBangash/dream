@php
    $ctx = $certificateContext ?? [];
@endphp
<div class="dream-cert-page">
    <div class="dream-cert-frame" role="img" aria-label="Dream Tuition Academy certificate">
        {{-- Single panel below "OF ACHIEVEMENT" — covers sample text on the JPG, keeps header/border visible --}}
        <div class="dream-cert-content-panel">
            <div class="dream-cert-content-inner">
                <p class="dream-line dream-line--lead">This is to certify that</p>

                @if ($ctx['show_name'] ?? true)
                    <p class="dream-line dream-line--name">{{ $ctx['student_name'] ?? '' }}</p>
                    <div class="dream-line--rule" aria-hidden="true"></div>
                @endif

                @if (! empty($ctx['parent_line']))
                    <p class="dream-line dream-line--parent">{{ $ctx['parent_line'] }}</p>
                @endif

                <p class="dream-line dream-line--lead">has successfully completed the</p>

                <div class="dream-line dream-line--course">
                    <span>{{ strtoupper($ctx['course_name'] ?? '') }}</span>
                </div>

                <p class="dream-line dream-line--level">
                    <span class="leaf">✦</span>
                    <span>{{ strtoupper($ctx['level'] ?? '') }}</span>
                    <span class="leaf">✦</span>
                </p>

                <p class="dream-line dream-line--institute">{{ $ctx['institute_line'] ?? '' }}</p>
                <p class="dream-line dream-line--tagline">{{ $ctx['tagline'] ?? 'Keep Learning, Keep Growing!' }}</p>
            </div>
        </div>
    </div>
</div>
