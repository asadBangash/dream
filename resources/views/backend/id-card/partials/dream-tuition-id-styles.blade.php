<style>
    #printContent.dream-id-preview-root {
        width: 100%;
        min-height: 420px;
    }

    .dream-id-print-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        justify-content: center;
        align-items: flex-start;
        width: 100%;
        padding: 8px 0;
    }

    .dream-id {
        --dream-id-cream: #f3efe4;
        --dream-id-green: #2d5a3d;
        --dream-id-gold: #c4a035;
        position: relative;
        box-sizing: border-box;
        overflow: hidden;
        font-family: Georgia, 'Times New Roman', serif;
        color: var(--dream-id-green);
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .dream-id__bg {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: fill;
        pointer-events: none;
        z-index: 0;
    }

    .dream-id__label {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 0.6875em;
        font-weight: 700;
        letter-spacing: 0.06em;
        line-height: 1.2;
        color: var(--dream-id-green);
        text-transform: uppercase;
    }

    .dream-id__line-value {
        display: block;
        font-family: Georgia, 'Times New Roman', serif;
        font-style: italic;
        font-weight: 500;
        font-size: 1em;
        line-height: 1.25;
        color: var(--dream-id-green);
        border-bottom: 2px solid var(--dream-id-gold);
        padding: 0 0 0.2em;
        min-height: 1.35em;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .dream-id__field {
        display: flex;
        flex-direction: column;
        gap: 0.15em;
        min-width: 0;
    }

    .dream-id__photo-frame {
        border: 2px solid var(--dream-id-gold);
        background: var(--dream-id-cream);
        overflow: hidden;
        box-sizing: border-box;
    }

    .dream-id__photo-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center top;
        display: block;
    }

    /* ---------- Scale wrappers (fixed aspect, visible in preview) ---------- */
    .dream-id-scale {
        position: relative;
        margin: 0 auto;
        flex-shrink: 0;
    }

    .dream-id-scale--student {
        width: min(100%, 1024px);
        height: calc(min(100vw, 1024px) * 645 / 1024);
        max-height: 645px;
    }

    .dream-id-scale--teacher {
        width: min(100%, 645px);
        height: calc(min(100vw, 645px) * 1024 / 645);
        max-height: 1024px;
    }

    .dream-id-scale .dream-id {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
    }

    .dream-id-scale--student .dream-id {
        font-size: clamp(11px, 1.56vw, 16px);
    }

    .dream-id-scale--teacher .dream-id {
        font-size: clamp(10px, 2.1vw, 16px);
    }

    /* ---------- Student 1024×645 ---------- */
    .dream-id--student .dream-id__student-body {
        position: absolute;
        z-index: 2;
        left: 6.5%;
        top: 37.8%;
        width: 73.5%;
        height: 51%;
        background: var(--dream-id-cream);
        box-sizing: border-box;
    }

    .dream-id--student .dream-id__student-layout {
        display: grid;
        grid-template-columns: 22% minmax(0, 1fr);
        gap: 3.5%;
        width: 100%;
        height: 100%;
        padding: 1.5% 2% 1.5% 1.5%;
        box-sizing: border-box;
    }

    .dream-id--student .dream-id__photo-frame {
        min-height: 0;
        height: 100%;
    }

    .dream-id--student .dream-id__student-fields {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-width: 0;
        height: 100%;
        padding: 0.25em 0;
        box-sizing: border-box;
    }

    .dream-id--student .dream-id__field-row {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 5%;
        align-items: end;
    }

    .dream-id--student .dream-id__field--name .dream-id__line-value {
        font-size: 1.3125em;
    }

    .dream-id--student .dream-id__qr--custom {
        position: absolute;
        z-index: 3;
        left: 82.5%;
        top: 44.5%;
        width: 12.5%;
        height: 20%;
        background: var(--dream-id-cream);
        box-sizing: border-box;
        padding: 2px;
    }

    .dream-id--student .dream-id__qr--custom img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    /* ---------- Teacher 645×1024 ---------- */
    .dream-id--teacher .dream-id__teacher-body {
        position: absolute;
        z-index: 2;
        left: 7%;
        top: 29.5%;
        width: 86%;
        height: 52%;
        background: var(--dream-id-cream);
        box-sizing: border-box;
        padding: 1.5% 2%;
    }

    .dream-id--teacher .dream-id__teacher-layout {
        display: grid;
        grid-template-columns: 38% minmax(0, 1fr);
        gap: 4%;
        width: 100%;
        height: 100%;
        box-sizing: border-box;
    }

    .dream-id--teacher .dream-id__teacher-photo-col {
        display: flex;
        flex-direction: column;
        gap: 0.65em;
        min-height: 0;
    }

    .dream-id--teacher .dream-id__photo-frame {
        flex: 1 1 auto;
        min-height: 0;
    }

    .dream-id--teacher .dream-id__teacher-fields {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-width: 0;
        height: 100%;
        padding: 0.15em 0;
        box-sizing: border-box;
    }

    .dream-id--teacher .dream-id__field--name .dream-id__line-value {
        font-size: 1.2em;
    }

    .dream-id--teacher .dream-id__qr--custom {
        position: absolute;
        z-index: 3;
        left: 50%;
        transform: translateX(-50%);
        bottom: 14%;
        width: 30%;
        height: 19%;
        background: var(--dream-id-cream);
        box-sizing: border-box;
        padding: 2px;
    }

    .dream-id--teacher .dream-id__qr--custom img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    @media print {
        @page {
            size: auto;
            margin: 8mm;
        }

        .dream-id-scale--student {
            width: 1024px;
            height: 645px;
            max-height: none;
        }

        .dream-id-scale--teacher {
            width: 645px;
            height: 1024px;
            max-height: none;
        }

        .dream-id-scale--student .dream-id,
        .dream-id-scale--teacher .dream-id {
            font-size: 16px;
        }

        .dream-id-scale {
            page-break-inside: avoid;
            break-inside: avoid;
        }
    }
</style>
