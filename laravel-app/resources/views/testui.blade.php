<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Button Hover Text</title>
    <style>
        .animated-hover-button {
            position: relative;
            overflow: hidden;
            padding: 12px 28px;
            font-size: 1.1rem;
            border: none;
            border-radius: 8px;
            background: #007bff;
            color: #fff;
            cursor: pointer;
            outline: none;
        }

        .animated-hover-button span {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            text-align: center;
            transition:
                opacity 0.3s cubic-bezier(.5, 1.5, .5, 1),
                transform 0.3s cubic-bezier(.5, 1.5, .5, 1);
            pointer-events: none;
        }

        /* Show default text by default */
        .animated-hover-button .default-text {
            top: 50%;
            opacity: 1;
            transform: translate(-50%, -50%);
        }

        /* Hide hover text by default (slide below and transparent) */
        .animated-hover-button .hover-text {
            top: 70%;
            opacity: 0;
            transform: translate(-50%, 0%);
        }

        /* On hover: hide default text (slide up and fade out), show hover text (slide up and fade in) */
        .animated-hover-button:hover .default-text {
            top: 35%;
            opacity: 0;
            transform: translate(-50%, -40%);
        }

        .animated-hover-button:hover .hover-text {
            top: 50%;
            opacity: 1;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body>

    <button class="animated-hover-button">
        <span class="default-text">Click me</span>
        <span class="hover-text">Hovered!</span>
    </button>

</body>

</html>
