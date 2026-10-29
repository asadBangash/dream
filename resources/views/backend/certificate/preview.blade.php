@include('backend.certificate.partials.dream-tuition-styles')

<div class="preview_box_wrapper">
    <h4 class="preview_title">Format</h4>
    <div class="certificate_wrapper_preview_box p-4">
        @include('backend.certificate.partials.dream-tuition-format', [
            'certificateContext' => certificateDreamContext($data['certificate'], null, null, true),
        ])
    </div>
</div>
