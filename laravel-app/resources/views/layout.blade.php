<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text to Bloom Multiple-Choice Questions</title>
    <!-- Include the stylesheets from your snippet -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('login-template/assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/docx@7.8.2/build/index.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>
<!-- Custom CSS for the UI -->
<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f5f7fa;
        margin: 0;
    }

    /* Header Styles */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        background-color: #fcfdfe;

    }

    .header .logo {
        display: flex;
        align-items: center;
        font-size: 20px;
        font-weight: bold;
        color: #333;
    }

    .header .logo i {
        margin-right: 10px;
        color: #28a745;
    }

    .header .nav-links {
        display: flex;
        gap: 15px;
    }

    .header .nav-links a {
        text-decoration: none;
        color: #333;
        font-size: 14px;
        padding: 5px 10px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .header .nav-links a.active {
        color: #28a745;
        font-weight: bold;
    }

    .header .nav-links a:hover {
        background-color: #f0f0f0;
    }

    .header .actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .header .actions button {
        border: none;
        cursor: pointer;
        font-size: 14px;
        padding: 5px 10px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .header .actions button:hover {
        background-color: #f0f0f0;
    }

    .header .actions .get-app {
        background-color: #ffca28;
        color: #333;
        font-weight: bold;
    }

    .header .actions .language {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .header .actions .notification {
        position: relative;
    }

    .header .actions .notification .badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: #ff0000;
        color: #fff;
        border-radius: 50%;
        padding: 2px 5px;
        font-size: 10px;
    }

    .header .actions .user-profile {
        width: 30px;
        height: 30px;
        background-color: #e0e0e0;
        color: #333;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: bold;
    }

    /* Main Content Styles */
    .main-container {
        display: flex;
        height: calc(100vh - 60px);
        padding: 20px;
    }

    .text-input-section {
        flex: 1;
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        margin-right: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .text-input-section .tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .text-input-section .tabs button {
        background: none;
        border: none;
        font-size: 14px;
        color: #666;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .text-input-section .tabs button.active {
        color: #28a745;
        font-weight: bold;
    }

    .text-input-section .tabs button .badge {
        background-color: #ffca28;
        color: #333;
        padding: 2px 5px;
        border-radius: 10px;
        font-size: 10px;
    }

    .text-input-section textarea {
        width: 100%;
        height: 80%;
        border: none;
        resize: none;
        font-size: 16px;
        color: #666;
    }

    .voice-selection-section {
        flex: 2;
        width: 400px;
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
    }

    .voice-selection-section .tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .voice-selection-section .tabs button {
        background: none;
        border: none;
        font-size: 14px;
        color: #666;
        cursor: pointer;
    }

    .voice-selection-section .tabs button.active {
        color: #28a745;
        font-weight: bold;
    }

    .voice-selection-section .filters {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .voice-selection-section .filters input,
    .voice-selection-section .filters select {
        padding: 5px;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        font-size: 14px;
        flex: 1;
    }

    .voice-selection-section .filters button {
        background: none;
        border: none;
        color: #666;
        cursor: pointer;
    }

    .footer-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
    }

    .footer-controls .slider {
        width: 100px;
    }

    .footer-controls select {
        padding: 5px;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
    }

    .create-speech-btn {
        background-color: #28a745;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .footer-controls .info {
        color: #0078d4;
        font-size: 12px;
        text-decoration: underline;
        cursor: pointer;
    }

    .tab-QG {
        color: #238a6a;
        font-weight: bold;
    }

    .tab-history {
        color: black;
        font-weight: bold;
    }

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
        padding: 2px 20px;
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


    /* Toggle Button */
    .toggle-btn-notification-sidebar {
        position: relative;
        font-size: 20px;
        background: none;
        border: none;
        cursor: pointer;

    }

    /* Overlay */
    .overlay-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.4);
        display: none;
        z-index: 999;
    }

    .overlay-sidebar.active {
        display: block;
    }

    /* Sidebar */
    .notification-sidebar {
        position: fixed;
        top: 0;
        right: -360px;
        width: 360px;
        height: 100vh;
        background-color: #fff;
        border-left: 1px solid #ddd;
        box-shadow: -2px 0 8px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
        z-index: 1000;
        transition: right 0.3s ease;
    }

    .notification-sidebar.active {
        right: 0;
    }

    .notification-header-sidebar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        font-size: 18px;
        font-weight: 600;
        border-bottom: 1px solid #eee;
    }

    .close-btn-sidebar {
        font-size: 18px;
        cursor: pointer;
        background: none;
        border: none;
    }

    .notification-item-sidebar {
        display: flex;
        padding: 16px 20px;
        border-bottom: 1px solid #f0f0f0;
    }

    .notification-icon-sidebar {
        width: 40px;
        height: 40px;
        background-color: #e7f3f3;
        color: #1d9bf0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin-right: 12px;
    }

    .notification-content-sidebar {
        flex: 1;
    }

    .notification-title-sidebar {
        font-weight: 600;
        font-size: 14px;
        color: #222;
    }

    .notification-text-sidebar {
        font-size: 14px;
        margin: 4px 0;
        color: #444;
    }

    .notification-time-sidebar {
        font-size: 12px;
        color: #888;
    }

    .notification-text-sidebar a {
        color: #2563eb;
        text-decoration: none;
    }

    .notification-text-sidebar a:hover {
        text-decoration: underline;
    }

    .toggle-btn-notification-sidebar .notification-dot {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 10px;
        height: 10px;
        background-color: #f44336;
        border-radius: 50%;
    }
</style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <i class="fa fa-bars"></i>
            <span>Text To Bloom Multiple-Choice Questions</span>
        </div>
        <div class="">

            <div class="header-nav-container">
                <ul class="nav custom-nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">Tạo câu
                            hỏi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('question.show') ? 'active' : '' }}"
                            href="{{ route('question.show') }}">Lịch sử</a>
                    </li>

                </ul>
            </div>


        </div>
        <div class="actions">
            <button class="language">
                <i class="fa fa-globe"></i> <span>Language</span>
            </button>
            @auth
                <button class="toggle-btn-notification-sidebar" onclick="toggleSidebar()">
                    <i class="fa fa-bell"></i>
                    <span class="notification-dot"></span>
                </button>
                <!-- overlay-sidebar -->
                <div class="overlay-sidebar" id="overlay-sidebar" onclick="closeSidebar()"></div>

                <!-- Notification Sidebar -->
                <div class="notification-sidebar" id="sidebar">
                    <div class="notification-header-sidebar">
                        Notifications
                        <button class="close-btn-sidebar" onclick="closeSidebar()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Notification Items -->
                    <div class="notification-item-sidebar">
                        <div class="notification-icon-sidebar">
                            <i class="fas fa-language"></i>
                        </div>
                        <div class="notification-content-sidebar">
                            <div class="notification-title-sidebar">Vocalize success</div>
                            <div class="notification-text-sidebar">Your text <a href="#">[The iPh...e 2024.]</a> has
                                been converted to audio successfully!</div>
                            <div class="notification-time-sidebar">13 days ago</div>
                        </div>
                    </div>

                    <div class="notification-item-sidebar">
                        <div class="notification-icon-sidebar">
                            <i class="fas fa-language"></i>
                        </div>
                        <div class="notification-content-sidebar">
                            <div class="notification-title-sidebar">Vocalize success</div>
                            <div class="notification-text-sidebar">Your text <a href="#">[Prices ...f 2024.]</a> has
                                been converted to audio successfully!</div>
                            <div class="notification-time-sidebar">13 days ago</div>
                        </div>
                    </div>

                    <!-- More notifications as needed -->
                </div>
                <img src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : 'https://img.freepik.com/free-vector/add-new-user_78370-4710.jpg' }}"
                    alt="" width="30" height="30" class="rounded-circle">
            @else
                <a type="button" href="{{ route('login') }}" class="btn btn-success">Sgin in -></a>
            @endauth

        </div>
    </div>


    @yield('content')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("overlay-sidebar");
            sidebar.classList.toggle("active");
            overlay.classList.toggle("active");
        }

        function closeSidebar() {
            document.getElementById("sidebar").classList.remove("active");
            document.getElementById("overlay-sidebar").classList.remove("active");
        }
    </script>
</body>

</html>
