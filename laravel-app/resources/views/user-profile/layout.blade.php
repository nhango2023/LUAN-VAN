<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo câu hỏi trắc nghiệm theo thang bloom</title>
    <meta name="description" content="Tạo câu hỏi trắc nghiệm theo thang bloom">
    <meta name="keywords" content="Câu hỏi trắc nghiệm, bloom, bloom's taxonomy, tự động">
    <link rel="icon" href="{{ asset('logo.ico') }}" type="image/x-icon">
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
        --bs-body-color: #182032;
        margin: 0;
    }

    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    body {
        height: 100vh;
        overflow: hidden;
    }

    :root {
        --header-vh: 8vh;
        --body-vh: 70vh;
        --footer-vh: 22vh;
    }

    /* Header Styles */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        background-color: #fcfdfe;
        height: var(--header-vh);
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
        height: var(--body-vh);
        padding: 20px;
        background: #f8fafc;

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


    /* Message sidebar */
    .toggle-btn-notification-sidebar {
        position: relative;
        font-size: 20px;
        background: none;
        border: none;
        cursor: pointer;

    }

    /* Overlay */
    .overlay-notify-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.4);
        display: none;
        z-index: 999;
    }

    .overlay-notify-sidebar.active {
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

    .notification-item-sidebar:hover {
        background-color: #f8fafc;
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
        display: flex;
        justify-content: space-between;
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

    /* Profile sidebar */
    .toggle-btn-notification-sidebar {
        position: relative;
        font-size: 20px;
        background: none;
        border: none;
        cursor: pointer;

    }

    /* Overlay */
    .overlay-profile-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.4);
        display: none;
        z-index: 999;
    }

    .overlay-profile-sidebar.active {
        display: block;
    }

    /* Sidebar */
    .profile-sidebar {
        position: fixed;
        top: 0;
        right: -470px;
        width: 470px;
        height: 100vh;
        background-color: #fff;
        border-left: 1px solid #ddd;
        box-shadow: -2px 0 8px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
        z-index: 1000;
        transition: right 0.3s ease;
    }

    .profile-sidebar.active {
        right: 0;
    }

    .profile-header-sidebar {
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

    .profile-item-sidebar {
        display: flex;
        padding: 16px 20px;
        border-bottom: 1px solid #f0f0f0;
    }

    .profile-icon-sidebar {
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

    .profile-content-sidebar {
        flex: 1;
    }

    .profile-title-sidebar {
        font-weight: 600;
        font-size: 14px;
        color: #222;
    }

    .profile-text-sidebar {
        font-size: 14px;
        margin: 4px 0;
        color: #444;
    }

    .profile-time-sidebar {
        font-size: 12px;
        color: #888;
    }

    .profile-text-sidebar a {
        color: #2563eb;
        text-decoration: none;
    }

    .profile-text-sidebar a:hover {
        text-decoration: underline;
    }

    .toggle-btn-profile-sidebar .profile-dot {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 10px;
        height: 10px;
        background-color: #f44336;
        border-radius: 50%;
    }

    .avatar {
        transition: transform 0.3s ease;
    }

    .avatar:hover {
        transform: scale(1.3);
        /* Increases size by 10% */
    }

    /* Profile Header */
    .profile-header {
        padding: 25px 0px;
        border-bottom: 1px solid #eee;
    }

    .profile-info {
        display: flex;
        align-items: center;
    }

    .avatar-placeholder {
        width: 48px;
        height: 48px;
        background-color: #ccc;
        border-radius: 50%;
        margin-right: 12px;
    }

    .user-details {
        flex-grow: 1;
    }

    .user-name {
        font-weight: bold;
    }

    .user-email {
        color: #666;
        font-size: 14px;
    }

    .settings-btn {
        margin-left: auto;
        background: #f0f0f0;
        border: none;
        padding: 6px 10px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
    }

    /* Status Section */
    .profile-status {
        padding: 10px;
        border-bottom: 1px solid #eee;
    }

    .status-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .status-item i {
        margin-right: 10px;
        color: #888;
    }

    .status-badge {
        margin-left: auto;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 12px;
    }

    .status-badge.yellow {
        background-color: #fdf3c4;
    }

    .status-badge.blue {
        background-color: #dce6f9;
    }

    .status-badge.red {
        background-color: #fce3e9;
    }

    /* Actions */
    .profile-actions {
        padding: 10px 3px;
    }

    .action-item {
        display: flex;
        align-items: center;
        padding: 10px 16px;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 500;
        color: var(--bs-body-color, #212529);
        gap: 10px;
        transition: background-color 0.2s ease;
        margin-bottom: 1.1rem;
    }

    .action-item:hover {
        background-color: #f1f5f9;
        color: #127458;
    }



    .action-item.with-badge {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .new-badge {
        background: #00c896;
        color: white;
        font-size: 12px;
        padding: 2px 6px;
        border-radius: 10px;
    }

    .subtext {
        font-size: 12px;
        color: #888;
    }

    /* footer*/
    footer {
        background-color: #fcfdfe;
        color: #333;
        padding: 5px 0;
        font-family: 'Varela Round', sans-serif;
        height: var(--footer-vh);
    }

    footer .container .row .col-md-4 h2 {
        font-family: cursive;
        color: #222;
        font-size: 36px;
        margin-bottom: 15px;
    }

    footer .container .row .col-md-4 p {
        font-size: 14px;
        line-height: 1.6;
        color: #444;
    }

    footer .container .row .col-md-4 a {
        color: #666;
        text-decoration: underline;
        font-size: 14px;
    }

    footer .container .row .col-md-4 h5 {
        color: #222;
        margin-bottom: 15px;
    }

    footer .container .row .col-md-4 ul {
        list-style: none;
        padding-left: 0;
    }

    footer .container .row .col-md-4 ul li {
        margin-bottom: 10px;
        font-size: 14px;
        color: #333;
    }

    footer .container .row .col-md-4 ul li i {
        margin-right: 10px;
        color: #888;
    }

    footer .container .row .col-md-4 .social-icons i {
        font-size: 18px;
        margin-right: 15px;
        color: #888;
        transition: color 0.3s ease;
    }

    footer .container .row .col-md-4 .social-icons i:hover {
        color: #222;
    }

    footer .container .row .col-md-4 em {
        color: #222;
        font-style: normal;
    }

    .profile-sidebar-root {
        width: 400px;
        margin: 30px auto;
        background: none;
        padding: 32px 0 0 0;
        display: flex;
        flex-direction: column;
        gap: 32px;
    }

    .account-settings-root {
        background: #fff;
        border: 1.3px solid #e7eaee;
        border-radius: 5px;
        padding: 38px 32px 48px 32px;
        margin: 18px auto;
        display: flex;
        flex-direction: column;
        gap: 15px;
        min-width: 768px;
    }



    html,
    body {
        height: 100%;
        margin: 0;
        overflow-y: auto;
        /* Enable scrolling on the whole page */
    }

    .main-container {
        height: auto !important;
    }


    .account-settings-root>div>b {
        color: #23304a;
        font-size: 1.125rem;
        line-height: 1.75rem;
        font-weight: 600;
    }

    .account-settings-root>div>hr {
        border: none;
        border-top: 1.5px solid rgb(226 232 240);
        margin: 0px 0 2px 0;
    }

    .account-settings-root>div:first-child>div {
        display: flex;
        align-items: center;
        gap: 18px;
        background: #fcfdfe;
        border: 1.5px solid #e1e7ee;
        border-radius: 10px;
        padding: 8px 14px;
        max-width: 350px;
    }

    .account-settings-root>div:first-child>div>input[type="text"] {
        border: none;
        background: transparent;
        font-size: 1.05rem;
        color: #263352;
        flex: 1;
        outline: none;
    }

    .account-settings-root>div:first-child>div>button {
        background: #14815e;
        color: #fff;
        font-weight: 600;
        border: none;
        border-radius: 7px;
        padding: 6px 20px;
        font-size: 1rem;
        transition: background 0.18s;
        cursor: pointer;
        margin-left: 12px;
    }

    .account-settings-root>div:first-child>div>button:hover {
        background: #11905e;
    }

    .account-settings-root>div:nth-child(2)>span {
        color: #8190a5;
        font-size: 1.07rem;
    }

    .account-settings-root>div:nth-child(3)>button {
        background: #fa5252;
        color: #fff;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        padding: 7px 20px;
        font-size: 1rem;
        transition: background 0.18s;
        cursor: pointer;
        margin-top: 12px;
    }

    .account-settings-root>div:nth-child(3)>button:hover {
        background: #e53e3e;
    }

    form {
        margin-top: 12px;
        max-width: 520px;
    }

    form>div {}

    form>div>label {
        display: block;
        font-weight: 600;
        color: #102043;
        margin-bottom: 7px;
        font-size: 1.09rem;
    }

    form>div>input[type="password"] {
        width: 100%;
        background: #f7fafd;
        border: 1.2px solid #dbe3ed;
        border-radius: 10px;
        padding: 5px 18px;
        font-size: 1.15rem;
        color: #96aac4;
        outline: none;
        margin-top: 3px;
        font-family: inherit;
        letter-spacing: 0.14em;
    }

    form>button[type="submit"] {
        margin-top: 14px;
        background: #11805a;
        color: #fff;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        padding: 6px 20px;
        font-size: 1.13rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        transition: background 0.19s;
        margin-bottom: 8px;
    }

    form>button[type="submit"]:hover {
        background: #116c4d;
    }

    form>button[type="submit"] i {
        font-size: 1.18em;
        margin-left: 8px;
    }

    .action-item.active {
        border: 1px solid #0e9f6e;
        border-radius: 12px;
        border-left: 5px solid #0e9f6e;
        color: #046c4e;
    }
</style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('logo.png') }}" alt="Logo" width="45" height="38" class="mr-2">
            </a>
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
                <button class="toggle-btn-notification-sidebar" onclick="toggleNotifySidebar()">
                    <i class="fa fa-bell"></i>
                    <span class="notification-dot d-none" id="notification-dot"></span>
                </button>
                <!-- overlay-notify-sidebar -->
                <div class="overlay-notify-sidebar" id="overlay-notify-sidebar" onclick="closeNotifySidebar()"></div>

                <!-- Notification Sidebar -->
                <div class="notification-sidebar" id="notify-sidebar">
                    <div class="notification-header-sidebar">
                        Notifications
                        <button class="close-btn-sidebar" onclick="closeNotifySidebar()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Notification Items -->
                    <div class="notification-item-sidebar">
                        <div class="notification-icon-sidebar">
                            <i class="fas fa-language"></i>
                        </div>
                        <div class="notification-content-sidebar">
                            <div class="notification-title-sidebar ">
                                <div>Tạo câu hỏi thành</div>

                                <div class="notification-time-sidebar">13 days ago</div>
                            </div>
                            <div class="notification-text-sidebar">Đã tạo câu hỏi từ file <a href="#">[TLDC.pdf]</a>
                                thành công !</div>

                        </div>
                    </div>



                    <!-- More notifications as needed -->
                </div>

                <img src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : 'https://img.freepik.com/free-vector/add-new-user_78370-4710.jpg' }}"
                    alt="" width="30" height="30" class="rounded-circle avatar" style="cursor: pointer"
                    onclick="toggleProfileSidebar()">
                <!-- Notification Sidebar -->
                <div class="overlay-profile-sidebar" id="overlay-profile-sidebar" onclick="closeProfileSidebar()"></div>
                <div class="profile-sidebar" id="profile-sidebar">
                    <div class="profile-header mx-4">
                        <div class="profile-info">
                            <img src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : 'https://img.freepik.com/free-vector/add-new-user_78370-4710.jpg' }}"
                                alt="" class="avatar-placeholder">

                            <div class="user-details">
                                <div class="user-name">{{ Auth::user()->fullname }}</div>
                                <div class="user-email">{{ Auth::user()->email }}</div>
                            </div>
                            <button class="settings-btn">
                                <i class="fas fa-cog"></i> Settings
                            </button>
                        </div>
                    </div>

                    <div class="profile-status mx-4">
                        <div class="status-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Current plan</span>
                            <span class="status-badge yellow">Free</span>
                        </div>
                        <div class="status-item">
                            <i class="fas fa-star"></i>
                            <span>Available credits</span>
                            <span class="status-badge blue">{{ Auth::user()->credit }}</span>
                        </div>
                        <div class="status-item">
                            <i class="fas fa-lock"></i>
                            <span>Locked credits</span>
                            <span class="status-badge red">0</span>
                        </div>
                    </div>

                    <div class="profile-actions mx-3">
                        <div class="action-item">🛒 Buy credits</div>
                        <div class="action-item">📄 Payment history</div>
                        <div class="action-item {{ Route::is('profile.account-infor') ? 'active' : '' }}">👤 Account
                            Information</div>
                        <div class="action-item with-badge">
                            🔗 Service Integration <span class="new-badge">New</span>
                        </div>
                        <div class="dv1">
                            <div class="dv2"></div>
                        </div>
                        <div class="action-item">
                            🎁 Gift Card<br>
                            <span class="subtext">Redeem a gift card to get more credits</span>
                        </div>
                        <a class="action-item d-flex align-items-center" style="text-decoration: none;"
                            href="{{ route('logout') }}">
                            <i class="material-icons">logout</i>
                            <div>Log out</div>
                        </a>
                    </div>


                </div>
            @else
                <a type="button" href="{{ route('login') }}" class="btn btn-success">Sgin in -></a>
            @endauth

        </div>
    </div>

    <div class="main-container">
        <div class="d-flex mx-auto">
            <div class="profile-settings-root">
                <div class="profile-settings-sidebar">
                    <div class="profile-header mx-4" style="padding: 10px 0">
                        <div class="profile-info">
                            <img src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : 'https://img.freepik.com/free-vector/add-new-user_78370-4710.jpg' }}"
                                alt="" class="avatar-placeholder">
                            <div class="user-details mr-3">
                                <div class="user-name">{{ Auth::user()->fullname }}</div>
                                <div class="user-email">{{ Auth::user()->email }}</div>
                            </div>
                            <button class="settings-btn">
                                <i class="fas fa-cog"></i> Settings
                            </button>
                        </div>
                    </div>

                    <div class="profile-status mx-4">
                        <div class="status-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Current plan</span>
                            <span class="status-badge yellow">Free</span>
                        </div>
                        <div class="status-item">
                            <i class="fas fa-star"></i>
                            <span>Available credits</span>
                            <span class="status-badge blue">{{ Auth::user()->credit }}</span>
                        </div>
                        <div class="status-item">
                            <i class="fas fa-lock"></i>
                            <span>Locked credits</span>
                            <span class="status-badge red">0</span>
                        </div>
                    </div>
                    <style>
                        .action-item {
                            padding: 8px 16px;
                            margin-bottom: 0.6rem;
                        }
                    </style>
                    <div class="profile-actions mx-3">
                        <div class="action-item">🛒 Buy credits</div>
                        <div class="action-item">📄 Payment history</div>
                        <div class="action-item {{ Route::is('profile.account-infor') ? 'active' : '' }}"">👤
                            Account
                            Information</div>
                        <div class="action-item with-badge">
                            🔗 Service Integration <span class="new-badge">New</span>
                        </div>
                        <div class="dv1">
                            <div class="dv2"></div>
                        </div>
                        <div class="action-item">
                            🎁 Gift Card<br>
                            <span class="subtext">Redeem a gift card to get more credits</span>
                        </div>
                        <a class="action-item d-flex align-items-center" style="text-decoration: none;"
                            href="{{ route('logout') }}">
                            <i class="material-icons">logout</i>
                            <div>Log out</div>
                        </a>
                    </div>
                </div>
                <div class="profile-settings-main">

                </div>
            </div>
            <div class="account-settings-root">
                @yield('content')
            </div>
        </div>
    </div>
    <footer>
        <div class="container">
            <div class="row text-left">
                <!-- Logo and About -->
                <div class="col-md-4">
                    <h2>logo</h2>
                    <p>We are a young company always looking for new and creative ideas to help you with our
                        products in
                        your everyday work.</p>
                    <a href="#">Our Team</a>
                </div>
                <!-- Contact Info -->
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <ul>
                        <li><i class="fa fa-map-marker"></i> Via Rossini 10, 10136 Turin Italy</li>
                        <li><i class="fa fa-phone"></i> (0039) 333 12 68 347</li>
                        <li><i class="fa fa-envelope"></i> <a href="mailto:hello@domain.com">hello@domain.com</a>
                        </li>
                    </ul>
                </div>
                <!-- Social Media -->
                <div class="col-md-4">
                    <h5><em>Follow us</em></h5>
                    <div class="social-icons">
                        <i class="fab fa-facebook-f"></i>
                        <i class="fab fa-twitter"></i>
                        <i class="fab fa-google-plus-g"></i>
                        <i class="fab fa-instagram"></i>
                        <i class="fab fa-pinterest-p"></i>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    @vite('resources/js/app.js')
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.Echo.channel('testChannel')
                .listen('testingEvent', (e) => {
                    const notificationHTML = `
                    <div class="notification-item-sidebar">
                        <div class="notification-icon-sidebar">
                            <i class="fas fa-language"></i>
                        </div>
                        <div class="notification-content-sidebar">
                            <div class="notification-title-sidebar ">
                                <div>Tạo câu hỏi thành</div>
                                <div class="notification-time-sidebar">13 days ago</div>
                            </div>
                            <div class="notification-text-sidebar">Đã tạo câu hỏi từ file <a href="#">[TLDC.pdf]</a>
                                thành công !</div>

                        </div>
                    </div>
                        `;
                    // 2. Append to the notify-sidebar
                    document.getElementById('notify-sidebar').insertAdjacentHTML('beforeend', notificationHTML);

                    // 3. Remove d-none from notification-dot
                    const notificationDot = document.getElementById('notification-dot');
                    notificationDot.classList.remove('d-none');
                })
        })

        function toggleNotifySidebar() {
            const sidebar = document.getElementById("notify-sidebar");
            const overlay = document.getElementById("overlay-notify-sidebar");
            sidebar.classList.toggle("active");
            overlay.classList.toggle("active");
        }

        function closeNotifySidebar() {
            document.getElementById("notify-sidebar").classList.remove("active");
            document.getElementById("overlay-notify-sidebar").classList.remove("active");
        }

        function toggleProfileSidebar() {
            const sidebar = document.getElementById("profile-sidebar");
            const overlay = document.getElementById("overlay-profile-sidebar");
            sidebar.classList.toggle("active");
            overlay.classList.toggle("active");
        }

        function closeProfileSidebar() {
            document.getElementById("profile-sidebar").classList.remove("active");
            document.getElementById("overlay-profile-sidebar").classList.remove("active");
        }
    </script>
</body>

</html>
