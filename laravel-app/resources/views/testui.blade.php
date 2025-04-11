<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('login-template/assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/docx@7.8.2/build/index.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="header-nav-container">
        <ul class="nav custom-nav justify-content-center">
            <li class="nav-item">
                <a class="nav-link active" href="#">Vocalize</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">History</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Voice Library</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">My Voices</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">API</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Translate <i class="fas fa-arrow-up-right-from-square"
                        style="font-size: 0.75rem;"></i></a>
            </li>
        </ul>
    </div>

    <style>
        .header-nav-container {
            background: #fff;
            padding: 5px 10px;
            border-radius: 30px;
            display: inline-block;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .header-nav-container:hover {
            box-shadow:
                0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        .custom-nav .nav-link {
            color: #717f95;
            font-weight: 500;
            padding: 10px 20px;
            border-radius: 30px;
            position: relative;
        }

        .custom-nav .nav-link.active {
            color: #009879;
            /* Green */
        }

        .custom-nav .nav-link.active::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 25%;
            width: 50%;
            height: 2px;
            background-color: #009879;
            border-radius: 2px;
        }

        .custom-nav .nav-link:hover {
            color: #334155;

        }
    </style>

</body>

</html>
