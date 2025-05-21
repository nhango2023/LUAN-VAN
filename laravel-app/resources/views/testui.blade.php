<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .bloom-loading {
            display: flex;
            gap: 2px;
            font-size: 1.5rem;
            font-weight: bold;
            font-family: sans-serif;
            justify-content: center;
            margin-top: 50px;
        }

        .bloom-loading span {
            display: inline-block;
            animation: jump 1.2s infinite;
        }

        .bloom-loading span:nth-child(1) {
            animation-delay: 0s;
        }

        .bloom-loading span:nth-child(2) {
            animation-delay: 0.05s;
        }

        .bloom-loading span:nth-child(3) {
            animation-delay: 0.1s;
        }

        .bloom-loading span:nth-child(4) {
            animation-delay: 0.15s;
        }

        .bloom-loading span:nth-child(5) {
            animation-delay: 0.2s;
        }

        .bloom-loading span:nth-child(6) {
            animation-delay: 0.25s;
        }

        .bloom-loading span:nth-child(7) {
            animation-delay: 0.3s;
        }



        /* Add more delays if needed for longer text */

        @keyframes jump {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }
    </style>
</head>

<body>
    <div id="logo_loading" class="">
        <span>B</span><span>l</span><span>o</span><span>o</span><span>m</span><span>A</span><span>I</span>
    </div>

    <script>
        document.getElementById('logo_loading').classList.add('bloom-loading');
    </script>

</body>

</html>
