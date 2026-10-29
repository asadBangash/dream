<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Great+Vibes&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Montserrat:wght@600;700;800&display=swap" rel="stylesheet">
<style>
    @page {
        size: A4 landscape;
        margin: 6mm;
    }

    .dream-cert-page {
        page-break-after: always;
        margin-bottom: 24px;
        display: flex;
        justify-content: center;
        width: 100%;
    }

    .dream-cert-page:last-child {
        page-break-after: auto;
    }

    .dream-cert-frame {
        position: relative;
        width: min(1024px, 100%);
        aspect-ratio: 1024 / 682;
        height: auto;
        overflow: hidden;
        container-type: inline-size;
        container-name: dreamcert;
        background: url("{{ asset('backend/uploads/certificate-templates/dream-certificate-master.jpg') }}") center center / 100% 100% no-repeat;
        background-color: #f3ede3;
        box-sizing: border-box;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .certificate_wrapper_preview_box,
    .dream-cert-print-area {
        overflow-x: auto;
        overflow-y: visible;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        width: 100%;
    }

    .dream-cert-preview-box {
        align-items: flex-start !important;
        justify-content: flex-start !important;
    }

    /* Covers only the variable-text band (not the CERTIFICATE ribbon above) */
    .dream-cert-content-panel {
        position: absolute;
        z-index: 2;
        left: 20.5%;
        right: 20.5%;
        top: 39.8%;
        bottom: 13.5%;
        background: #efe9df;
        overflow: hidden;
        box-sizing: border-box;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .dream-cert-content-inner {
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        text-align: center;
        padding: 0.4cqi 1.2cqi 0;
        box-sizing: border-box;
        gap: 0.15cqi;
    }

    .dream-line {
        margin: 0;
        width: 100%;
        line-height: 1.15;
    }

    .dream-line--lead {
        font-family: 'Libre Baskerville', Georgia, serif;
        font-style: italic;
        font-size: 2.05cqi;
        color: #1a1a1a;
    }

    .dream-line--name {
        font-family: 'Great Vibes', cursive;
        font-size: 5.2cqi;
        color: #0b4d2a;
        margin: 0.1cqi 0 0;
        padding: 0 0.5cqi;
        line-height: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    .dream-line--rule {
        width: 42cqi;
        max-width: 88%;
        height: 2px;
        margin: 0.35cqi 0 0.25cqi;
        background: linear-gradient(90deg, transparent, #c9a227 18%, #c9a227 82%, transparent);
        flex-shrink: 0;
    }

    .dream-line--parent {
        font-family: 'Libre Baskerville', Georgia, serif;
        font-size: 1.85cqi;
        color: #1a1a1a;
        margin-bottom: 0.35cqi;
    }

    .dream-line--course {
        width: auto;
        max-width: 100%;
        margin: 0.45cqi 0 0.35cqi;
        padding: 0.55cqi 3.2cqi;
        background: linear-gradient(180deg, #0d5230 0%, #083a20 100%);
        border: 2px solid #c9a227;
        flex-shrink: 0;
    }

    .dream-line--course span {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 2.15cqi;
        letter-spacing: 0.12cqi;
        color: #fff;
        white-space: nowrap;
    }

    .dream-line--level {
        font-family: 'Montserrat', sans-serif;
        font-weight: 800;
        font-size: 3.1cqi;
        letter-spacing: 0.18cqi;
        color: #0b4d2a;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8cqi;
        margin: 0.35cqi 0;
        flex-shrink: 0;
    }

    .dream-line--level .leaf {
        color: #c9a227;
        font-size: 1.85cqi;
        line-height: 1;
    }

    .dream-line--institute {
        font-family: 'Libre Baskerville', Georgia, serif;
        font-size: 2cqi;
        color: #1a1a1a;
        margin-top: 0.2cqi;
    }

    .dream-line--tagline {
        font-family: 'Great Vibes', cursive;
        font-size: 3.35cqi;
        color: #0b4d2a;
        margin-top: 0.15cqi;
        line-height: 1.05;
    }

    @supports not (font-size: 1cqi) {
        .dream-line--lead { font-size: 14px; }
        .dream-line--name { font-size: 36px; }
        .dream-line--parent { font-size: 13px; }
        .dream-line--course span { font-size: 15px; }
        .dream-line--level { font-size: 22px; }
        .dream-line--institute { font-size: 14px; }
        .dream-line--tagline { font-size: 24px; }
    }

    @media print {
        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        .dream-cert-page {
            margin: 0;
            page-break-after: always;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .dream-cert-frame {
            width: 100%;
            max-width: 287mm;
            aspect-ratio: 1024 / 682;
            height: auto;
            max-height: 190mm;
            page-break-inside: avoid;
        }
    }
</style>
