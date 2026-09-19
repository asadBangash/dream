<style>
    .radio-inputs {
        display: flex;
        align-items: center;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .radio-inputs>* {
        margin: 6px;
    }

    .radio-input:checked+.radio-tile {
        border-color: #2260ff;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        color: #2260ff;
    }

    .radio-input:checked+.radio-tile:before {
        transform: scale(1);
        opacity: 1;
        background-color: #2260ff;
        border-color: #2260ff;
    }

    .radio-icon {
        font-size: 25px
    }

    .radio-input:checked+.radio-tile .radio-icon svg {
        fill: #2260ff;
    }

    .radio-input:checked+.radio-tile .radio-label {
        color: #2260ff;
    }

    .radio-input:focus+.radio-tile {
        border-color: #2260ff;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1), 0 0 0 4px #b5c9fc;
    }

    .radio-input:focus+.radio-tile:before {
        transform: scale(1);
        opacity: 1;
    }

    .radio-tile {
        display: flex;
        gap: 10px;
        align-items: center;
        padding: 15px 20px;
        justify-content: center;
        border-radius: 0.5rem;
        border: 2px solid #b5bfd9;
        background-color: #fff;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        transition: 0.15s ease;
        cursor: pointer;
        position: relative;
    }

    .radio-tile:before {
        content: "";
        position: absolute;
        display: block;
        width: 0.75rem;
        height: 0.75rem;
        border: 2px solid #b5bfd9;
        background-color: #fff;
        border-radius: 50%;
        top: 0.25rem;
        left: 0.25rem;
        opacity: 0;
        transform: scale(0);
        transition: 0.25s ease;
    }

    .radio-tile:hover {
        border-color: #2260ff;
    }

    .radio-tile:hover:before {
        transform: scale(1);
        opacity: 1;
    }

    .radio-label {
        color: #707070;
        transition: 0.375s ease;
        text-align: center;
        font-size: 16px;
    }

    .radio-input {
        clip: rect(0 0 0 0);
        -webkit-clip-path: inset(100%);
        clip-path: inset(100%);
        height: 1px;
        overflow: hidden;
        position: absolute;
        white-space: nowrap;
        width: 1px;
    }

    #stripeOption {
        background: #fbfbfb;
    }

    #card-element {
        padding-bottom: 18px;
        padding-left: 16px;
        padding-right: 5px;
    }

    .dark-theme .payment_input_box {
        border-radius: 5px;
        border: 1px solid #D0D0D0 !important;
        background: #27282E !important;
        color: #fff !important
    }

    .dark-theme .payment_input_box::placeholder {
        color: #D0D0D0 !important;
    }

    .dark-theme .radio-tile {
        box-shadow: none;
        background: #6c757d;
        border-color: #6c757d;
    }

    .dark-theme .radio-label {
        color: #fff;
    }

    .dark-theme .ElementsApp {
        color: #fff
    }

    .dark-theme .ElementsApp input {
        background-color: transparent;
        border: none;
        display: block;
        font-family: sans-serif;
        font-size: 1em;
        height: 1.2em;
        line-height: 1.2em;
        margin: 0;
        padding: 0;
        width: 100%;
        color: inherit !important;
    }

    .text-white {
        color: #fff !important
    }


    .dark-theme .radio-input:checked+.radio-tile {
        color: #fff;
        background: linear-gradient(130.57deg, #392C7D -0.48%, #314CAD 71.79%) !important;
        box-shadow: none !important;
        color: #fff !important;
    }

    .dark-theme .radio-input:checked+.radio-tile .radio-label {
        color: #fff;
    }

    /* body.dark-theme .ElementsApp input.InputElement.is-complete.Input {
        color: #fff !important;
    }


    .ElementsApp .InputElement.is-invalid {
    color: #000 !important;
} */
</style>