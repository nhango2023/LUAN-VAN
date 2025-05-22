<!DOCTYPE html>
<html lang="en">

<head>
    <script>
        function isMobile() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        }

        if (isMobile()) {
            // Option 1: Redirect to another page
            window.location.href = "/not-available-on-mobile";

            // Option 2: Show an alert and stop interaction
            // alert("This site is not supported on mobile devices.");
            // document.body.innerHTML = "<h2>Sorry, mobile access is not supported.</h2>";
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $configWeb->title }}</title>
    <meta name="description" content="{{ $configWeb->web_description }}">
    <meta name="keywords" content="{{ $configWeb->keywords }}">
    <link rel="icon" href="{{ asset('logo.ico') }}" type="image/x-icon">
    <!-- Include the stylesheets from your snippet -->
    <!-- seo -->

    @if (Request::segment(1) == '')
        <meta name="description" content="{{ $configWeb->web_description }}@yield('description')">
        <meta property="og:description" content="{{ $configWeb->web_description }}@yield('description')">
        <meta name="twitter:description" content="{{ $configWeb->web_description }}@yield('description')">
    @endif


    @if (Request::segment(1) != '')
        <meta name="description" content="@yield('description')">
        <meta property="og:description" content="@yield('description')">
        <meta name="twitter:description" content="@yield('description')">
    @endif



    <meta property="og:image" content="{{ secure_url('/file/img/logo') . '/' . $configWeb->logo }}" />
    <meta itemprop="image" content="{{ secure_url('/file/img/logo') . '/' . $configWeb->web_description }}" />
    <meta property="og:image:secure_url"
        content="{{ secure_url('/file/img/logo') . '/' . $configWeb->web_description }}" />



    <meta name="robots" content="all">

    <meta property="og:image:alt" content="{{ $configWeb->title }}" />

    <meta property="og:site_name" content="{{ $configWeb->titles }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ Request::fullUrl() }}" />

    <meta name="twitter:card" content="summary">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <meta name="twitter:site" content="{{ $configWeb->title }}">

    <meta name="twitter:title" content="@yield('title') - {{ $configWeb->title }}">
    <meta property="og:title" content="@yield('title') - {{ $configWeb->title }}" />
    <!-- seo -->
    <title>@yield('title') - {{ $configWeb->title }}</title>

    <link rel="icon" type="image/x-icon" href="{{ secure_url('/file/img/favicon') . '/' . 'favicon.ico' }}">

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
        background-color: white;
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
        background-color: white;
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

    :root {
        --dark: #34495E;
        --light: #ffffff;
        --success: #0ABF30;
        --error: #E24D4C;
        --warning: #E9BD0C;
        --info: #3498DB;
    }

    .notifications-toast {
        position: fixed;
        bottom: 0;
        right: 0px;
        z-index: 9999;
        display: flex;
        flex-direction: column-reverse;
        gap: 10px;
    }

    .notifications-toast :where(.toast-test, .column) {
        display: flex;
        align-items: center;
    }

    .notifications-toast .toast-test {
        background: red;
        width: 400px;
        position: relative;
        overflow: hidden;
        list-style: none;
        border-radius: 4px;
        padding: 16px 17px;
        margin-bottom: 10px;
        background: var(--light);
        justify-content: space-between;
        animation: show_toast 0.3s ease forwards;
    }

    @keyframes show_toast {
        0% {
            transform: translateX(100%);
        }

        40% {
            transform: translateX(-5%);
        }

        80% {
            transform: translateX(0%);
        }

        100% {
            transform: translateX(-10px);
        }
    }

    .notifications-toast .toast-test.hide {
        animation: hide_toast 0.3s ease forwards;
    }

    @keyframes hide_toast {
        0% {
            transform: translateX(-10px);
        }

        40% {
            transform: translateX(0%);
        }

        80% {
            transform: translateX(-5%);
        }

        100% {
            transform: translateX(calc(100% + 20px));
        }
    }

    .toast-test::before {
        position: absolute;
        content: "";
        height: 3px;
        width: 100%;
        bottom: 0px;
        left: 0px;
        animation: progress 5s linear forwards;
    }

    @keyframes progress {
        100% {
            width: 0%;
        }
    }

    .toast-test.success::before,
    .btn#success {
        background: var(--success);
    }

    .toast-test.error::before,
    .btn#error {
        background: var(--error);
    }

    .toast-test.warning::before,
    .btn#warning {
        background: var(--warning);
    }

    .toast-test.info::before,
    .btn#info {
        background: var(--info);
    }

    .toast-test .column i {
        font-size: 1.75rem;
    }

    .toast-test.success .column i {
        color: var(--success);
    }

    .toast-test.error .column i {
        color: var(--error);
    }

    .toast-test.warning .column i {
        color: var(--warning);
    }

    .toast-test.info .column i {
        color: var(--info);
    }

    .toast-test .column span {
        font-size: 1.07rem;
        margin-left: 12px;
    }

    .toast-test i:last-child {
        color: #aeb0d7;
        cursor: pointer;
    }

    .toast-test i:last-child:hover {
        color: var(--dark);
    }

    .buttons .btn {
        border: none;
        outline: none;
        cursor: pointer;
        margin: 0 5px;
        color: var(--light);
        font-size: 1.2rem;
        padding: 10px 20px;
        border-radius: 4px;
    }

    @media screen and (max-width: 530px) {
        .notifications-toast {
            width: 95%;
        }

        .notifications-toast .toast-test {
            width: 100%;
            font-size: 1rem;
            margin-left: 20px;
        }

        .buttons .btn {
            margin: 0 1px;
            font-size: 1.1rem;
            padding: 8px 15px;
        }
    }

    .custom-toast {
        display: flex;
        align-items: flex-start;
        position: fixed;
        top: 20px;
        right: 20px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
        padding: 16px 20px;
        width: 360px;
        z-index: 9999;
        border-left: 6px solid #22c55e;
    }

    .toast-icon {
        color: #22c55e;
        font-size: 24px;
        margin-right: 14px;
        margin-top: 2px;
    }

    .toast-content {
        flex-grow: 1;
    }

    .toast-content strong {
        font-size: 16px;
        color: #111827;
    }

    .toast-content p {
        margin: 4px 0;
        font-size: 14px;
        color: #6b7280;
        line-height: 1.4;
    }

    .toast-btn {
        background-color: #22c55e;
        color: white;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        margin-top: 8px;
        border: none;
        cursor: pointer;
    }

    .toast-btn:hover {
        background-color: #16a34a;
    }

    .toast-close {
        cursor: pointer;
        margin-left: 12px;
        color: #6b7280;
        font-size: 16px;
    }

    .toast-close:hover {
        color: #111827;
    }

    .action-item.active {
        border: 1px solid #0e9f6e;
        border-radius: 12px;
        border-left: 5px solid #0e9f6e;
        color: #046c4e;
    }

    @media (max-width: 768px) {
        .header-nav-container {}


    }

    /* loading text */
    .bloom-loading {
        display: flex;
        gap: 2px;
        font-size: 1.5rem;
        font-weight: bold;
        font-family: sans-serif;
        justify-content: center;
        /* margin-top: 50px; */
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

    @keyframes jump {

        0% {
            transform: translateY(3px);
        }

        25% {
            transform: translateY(6px);
        }

        50% {
            transform: translateY(0px);
        }

        75% {
            transform: translateY(-3px);
        }

        100% {
            transform: translateY(-6px);
        }
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
            <div id="loading_logo" class="">
                <span>B</span><span>l</span><span>o</span><span>o</span><span>m</span><span>A</span><span>I</span>
            </div>
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
            {{-- <button class="language">
                <i class="fa fa-globe"></i> <span>Language</span>
            </button> --}}
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
                            <a style="text-decoration: none; color: black;" class="settings-btn"
                                href="{{ route('profile.account-infor') }}">
                                <i class="fas fa-cog"></i> Settings
                            </a>
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
                        <a href="{{ route('profile.buy-credit') }}">
                            <div class="action-item {{ Route::is('profile.buy-credit') ? 'active' : 'noe' }}">🛒 Buy
                                credits
                            </div>
                        </a>
                        <div class="action-item">📄 Payment history</div>
                        <a href="{{ route('profile.account-infor') }}">
                            <div class="action-item {{ Route::is('profile.account-infor') ? 'active' : 'none' }}">👤
                                Account
                                Information</div>
                        </a>
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
        @yield('content')
    </div>
    <ul class="notifications-toast"></ul>

    <footer>
        <div class="container">
            <div class="row text-left">
                <!-- Logo and About -->
                <div class="col-md-4">
                    <h2>logo</h2>
                    <p>{{ $configWeb->company_description }}</p>

                </div>
                <!-- Contact Info -->
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <ul>
                        <li><i class="fa fa-map-marker"></i> {{ $configWeb->address }} </li>
                        <li><i class="fa fa-phone"></i>{{ $configWeb->phone_number }} </li>
                        <li><i class="fa fa-envelope"></i> <a
                                href="mailto:hello@domain.com">{{ $configWeb->email }}</a></li>
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



    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    @vite('resources/js/app.js')
    <script>
        @auth
        const authUser = @json(auth()->user());
        if (authUser.isCreated == 1) {
            document.getElementById('loading_logo').classList.add('bloom-loading');
        }
        @endauth

        document.addEventListener('DOMContentLoaded', function() {


            Echo.channel(`user`)
                .listen('QuestionEvent', (e) => {
                    
                    document.getElementById('btn-submit').disabled = false;

                    if (e.code === 403 || e.code === 402) {
                        createToastError('error', e.message);
                    } else if (e.code === 200) {
                        fetchMessages();
                        createToastSuccess('success');
                        document.querySelector('.file-selector').disabled = false;
                        document.getElementById('loading_logo').classList.remove('bloom-loading');
                    }
                });

            async function fetchMessages() {
                @auth

                try {
                    const response = await fetch('/message/show', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin' // Needed if using Laravel Auth
                    });

                    if (!response.ok) throw new Error('Network response was not ok');

                    const data = await response.json();
                    const notifySidebar = document.getElementById('notify-sidebar');
                    notifySidebar.innerHTML = '';
                    let display_dot = false;

                    data.forEach(msg => {
                        if (msg.seen == 0) display_dot = true;
                        const style_not_seen = msg.seen == 0 ? 'style="color: rgb(14 159 110)"' : '';
                        const timeText = timeAgo(msg.created_at);

                        const notificationHTML = `
                    <a onclick="updateMessage(${msg.id}, ${msg.id_file})" style="text-decoration: none;color: inherit;cursor: pointer">
                        <div class="notification-item-sidebar">
                            <div class="notification-icon-sidebar"><i class="fas fa-language"></i></div>
                            <div class="notification-content-sidebar">
                                <div class="notification-title-sidebar">
                                    <div ${style_not_seen}>Tạo câu hỏi thành công</div>
                                    <div class="notification-time-sidebar">${timeText}</div>
                                </div>
                                <div class="notification-text-sidebar">
                                    Đã tạo câu hỏi từ file 
                                    <a href="javascript:void(0);" onclick="updateMessage(${msg.id}, ${msg.id_file})">[${msg.original_name}]</a> 
                                    thành công !
                                </div>
                            </div>
                        </div>
                    </a>
                `;
                        notifySidebar.insertAdjacentHTML('beforeend', notificationHTML);
                    });

                    if (display_dot) {
                        const notificationDot = document.getElementById('notification-dot');
                        notificationDot.classList.remove('d-none');
                    }

                } catch (error) {
                    console.error('Error fetching messages:', error);
                }
            @endauth
        }

        // Initial call
        fetchMessages();
        });
    </script>

    <script>
        //toast
        const notifications = document.querySelector(".notifications-toast")


        const toastDetails = {
            timer: 7000,
            success: {
                icon: 'fa-circle-check',
                text: 'Success: This is a success toast.',
            }
        }

        const removeToast = (toast) => {
            toast.classList.add("hide");
            if (toast.timeoutId) clearTimeout(toast.timeoutId); // Clearing the timeout for the toast
            setTimeout(() => toast.remove(), 100); // Removing the toast after 500ms
        }

        //toast
        const createToastSuccess = (id) => {
            // Getting the icon and text for the toast based on the id passed

            const toast = document.createElement("li"); // Creating a new 'li' element for the toast
            toast.className = `toast-test ${id}`; // Setting the classes for the toast
            // Setting the inner HTML for the toast
            toast.innerHTML = `                                                       
                        <div class="toast-icon">
                            <i class="fas fa-check-circle" style="color: #0ABF30"></i>
                        </div>
                        <div class="toast-content">
                            <strong>Success</strong>
                            <p>Tạo câu hỏi thành công,<br>Kiểm tra kết quả trong lịch sử.</p>
                            <button onclick="window.location.href='/question/show'" class="toast-btn">Go to history</button>
                        </div>
                        <div class="toast-close" onclick="this.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </div>
                        </div>
                            `;
            notifications.appendChild(toast); // Append the toast to the notification ul
            // Setting a timeout to remove the toast after the specified duration
            toast.timeoutId = setTimeout(() => removeToast(toast), toastDetails.timer);
        }

        const createToastInfor = (id, message) => {
            // Getting the icon and text for the toast based on the id passed

            const toast = document.createElement("li"); // Creating a new 'li' element for the toast
            toast.className = `toast-test ${id}`; // Setting the classes for the toast
            // Setting the inner HTML for the toast
            toast.innerHTML = `                                                       
                        <div class="toast-icon">
                            <i class="fas fa-info-circle" style="color: #3498DB"></i>
                        </div>
                        <div class="toast-content">
                            <strong>Thông tin</strong>
                            <p>${message}</p>
                        </div>
                        <div class="toast-close" onclick="this.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </div>
                            `;
            notifications.appendChild(toast); // Append the toast to the notification ul
            // Setting a timeout to remove the toast after the specified duration
            toast.timeoutId = setTimeout(() => removeToast(toast), toastDetails.timer);
        }

        const createToastError = (id, error) => {
            // Getting the icon and text for the toast based on the id passed

            const toast = document.createElement("li"); // Creating a new 'li' element for the toast
            toast.className = `toast-test ${id}`; // Setting the classes for the toast
            // Setting the inner HTML for the toast
            toast.innerHTML = `                                                       
                        <div class="toast-icon">
                            <i class="fas fa-exclamation-circle" style="color: #E24D4C"></i>
                        </div>
                        <div class="toast-content">
                            <strong>Lỗi !</strong>
                            <p>${error}</p>                      
                        </div>
                        <div class="toast-close" onclick="this.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </div>
                            `;
            notifications.appendChild(toast); // Append the toast to the notification ul
            // Setting a timeout to remove the toast after the specified duration
            toast.timeoutId = setTimeout(() => removeToast(toast), toastDetails.timer);
        }

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
    @auth
        <script>
            function timeAgo(timestamp) {
                const now = new Date();
                const past = new Date(timestamp);
                const diffInSeconds = Math.floor((now - past) / 1000);

                if (diffInSeconds < 60) {
                    return 'a few seconds ago';
                } else if (diffInSeconds < 3600) {
                    const minutes = Math.floor(diffInSeconds / 60);
                    return `${minutes} minute${minutes !== 1 ? 's' : ''} ago`;
                } else if (diffInSeconds < 86400) {
                    const hours = Math.floor(diffInSeconds / 3600);
                    return `${hours} hour${hours !== 1 ? 's' : ''} ago`;
                } else if (diffInSeconds < 2592000) {
                    const days = Math.floor(diffInSeconds / 86400);
                    return `${days} day${days !== 1 ? 's' : ''} ago`;
                } else {
                    const months = Math.floor(diffInSeconds / 2592000);
                    return `${months} month${months !== 1 ? 's' : ''} ago`;
                }
            }



            async function updateMessage(id_message, id_file) {
                try {
                    const response = await fetch(`/message/update/${id_message}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // for Laravel CSRF protection
                        },
                        body: JSON.stringify({
                            seen: true
                        })
                    });

                    if (!response.ok) {
                        throw new Error('Update failed');
                    }

                    const data = await response.json();
                    console.log('Success:', data);

                    // Optional: redirect to the question page
                    window.location.href = `/question/show/${id_file}`;

                } catch (error) {
                    console.error('Error:', error);
                }
            }
        </script>
    @endauth

</body>

</html>
