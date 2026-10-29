@include('backend.certificate.partials.dream-tuition-styles')

@if (empty($data['certificate']))
    <div class="col-12">
        <div class="alert alert-danger mb-0">{{ ___('alert.something_went_wrong_please_try_again') }}</div>
    </div>
@elseif ($data['students']->isEmpty())
    <div class="col-12">
        <div class="alert alert-warning mb-0">No students found for the selected class, section, and session.</div>
    </div>
@else
    @foreach ($data['students'] as $row)
        <div class="col-12 d-flex justify-content-center">
            @include('backend.certificate.partials.dream-tuition-format', [
                'certificateContext' => certificateDreamContext(
                    $data['certificate'],
                    $row,
                    $data['session'] ?? null,
                    false
                ),
            ])
        </div>
    @endforeach
@endif
