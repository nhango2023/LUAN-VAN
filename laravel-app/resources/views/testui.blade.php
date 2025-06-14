<!DOCTYPE html>
<html lang="en">

<head>

    <!--====== Design by foolishdeveloper.com =====-->


    <title>Automatic Popup</title>
    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!--Stylesheets-->
    <style media="screen">
        *,
        *:before,
        *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #0855ae;
        }

        .popup {
            background-color: #ffffff;
            width: 420px;
            padding: 30px 40px;
            position: absolute;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 50%;
            border-radius: 8px;
            font-family: "Poppins", sans-serif;
            display: none;
            text-align: center;
        }

        .popup button {
            display: block;
            margin: 0 0 20px auto;
            background-color: transparent;
            font-size: 30px;
            color: #ffffff;
            background: #03549a;
            border-radius: 100%;
            width: 40px;
            height: 40px;
            border: none;
            outline: none;
            cursor: pointer;
        }

        .popup h2 {
            margin-top: -20px;
        }

        .popup p {
            font-size: 14px;
            text-align: justify;
            margin: 20px 0;
            line-height: 25px;
        }

        a {
            display: block;
            width: 150px;
            position: relative;
            margin: 10px auto;
            text-align: center;
            background-color: #0f72e5;
            border-radius: 20px;
            color: #ffffff;
            text-decoration: none;
            padding: 8px 0;
        }
    </style>
</head>

<body>
    <div class="popup">
        <button id="close">&times;</button>
        <h2>Automatic Pop-Up</h2>
        <p>
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Expedita distinctio fugiat alias iure qui, commodi
            minima magni ullam aliquam dignissimos?
        </p>
        <a href="#">Let's Go</a>
    </div>
    <!--Script-->
    <script type="text/javascript">
        window.addEventListener("load", function() {
            setTimeout(
                function open(event) {
                    document.querySelector(".popup").style.display = "block";
                },
                2000
            )
        });


        document.querySelector("#close").addEventListener("click", function() {
            document.querySelector(".popup").style.display = "none";
        });
    </script>
</body>

</html>
