<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Tạo câu hỏi trắc nghiệm theo thang bloom|Admin dashboard')</title>
    <title>Tạo câu hỏi trắc nghiệm theo thang bloom</title>
    <meta name="description" content="Tạo câu hỏi trắc nghiệm theo thang bloom">
    <meta name="keywords" content="Câu hỏi trắc nghiệm, bloom, bloom's taxonomy, tự động">
    <link rel="icon" href="{{ asset('logo.ico') }}" type="image/x-icon">
    {{-- <link rel="shortcut icon" type="image/png" href="{{ asset('login-template/assets/images/logos/seodashlogo222.png')}}" /> --}}
    <link rel="stylesheet" href="{{ asset('login-template/assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body style="height: 100vh">
    <style>
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
    </style>
    <!--  Body Wrapper -->
    <div class="page-wrapper h-100" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
        data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-center">
                    <a href="{{ route('admin.home') }}" class="text-nowrap logo-img text-center">
                        <img src="{{ asset('logo.png') }}" alt="Logo" width="45" height="38" class="mr-2">
                    </a>
                    {{-- <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div> --}}
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                            <span class="hide-menu">Home</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.home') }}" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="solar:home-smile-bold-duotone" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                            <span class="hide-menu">Quản lý</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.user.show') }}" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="solar:layers-minimalistic-bold-duotone"
                                        class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu">Users</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.plan.show') }}" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="solar:layers-minimalistic-bold-duotone"
                                        class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu">Plan</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.payment.show') }}" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="solar:layers-minimalistic-bold-duotone"
                                        class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu">Payment</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.addition-question.show') }}"
                                aria-expanded="false">
                                <span>
                                    <iconify-icon icon="solar:layers-minimalistic-bold-duotone"
                                        class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu">Additional question</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.ai-model.show') }}" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="solar:layers-minimalistic-bold-duotone"
                                        class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu">AI model</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.config-web.show') }}"
                                aria-expanded="false">
                                <span>
                                    <iconify-icon icon="solar:layers-minimalistic-bold-duotone"
                                        class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu">Config website</span>
                            </a>
                        </li>

                        {{-- <li class="sidebar-item">
              <a class="sidebar-link" href="./ui-alerts.html" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:danger-circle-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Alerts</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./ui-card.html" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:bookmark-square-minimalistic-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Card</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./ui-forms.html" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:file-text-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Forms</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./ui-typography.html" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:text-field-focus-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Typography</span>
              </a>
            </li> --}}
                        <li class="nav-small-cap">
                            <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-6"
                                class="fs-6"></iconify-icon>
                            <span class="hide-menu">AUTH</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('logout') }}" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="solar:login-3-bold-duotone" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu">Log out</span>
                            </a>
                        </li>
                        {{-- <li class="sidebar-item">
              <a class="sidebar-link" href="./authentication-register.html" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:user-plus-rounded-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Register</span>
              </a>
            </li> --}}
                        <li class="nav-small-cap">
                            <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"
                                class="fs-6"></iconify-icon>
                            <span class="hide-menu">EXTRA</span>
                        </li>
                        {{-- <li class="sidebar-item">
                            <a class="sidebar-link" href="./icon-tabler.html" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="solar:sticker-smile-circle-2-bold-duotone"
                                        class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu">Icons</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="./sample-page.html" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="solar:planet-3-bold-duotone" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu">Sample Page</span>
                            </a>
                        </li> --}}
                    </ul>
                    {{-- <div class="unlimited-access hide-menu bg-primary-subtle position-relative mb-7 mt-7 rounded-3">
                        <div class="d-flex">
                            <div class="unlimited-access-title me-3">
                                <h6 class="fw-semibold fs-4 mb-6 text-dark w-75">Upgrade your plan</h6>
                                <a href="#" target="_blank" class="btn btn-primary fs-2 fw-semibold lh-sm">Buy
                                    Pro</a>
                            </div>
                            <div class="unlimited-access-img">
                                <img src="{{ asset('login-template/assets/images/backgrounds/rocket.png') }}"
                                    alt="" class="img-fluid">
                            </div>
                        </div>
                    </div> --}}
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                                <i class="ti ti-bell-ringing"></i>
                                <div class="notification bg-primary rounded-circle"></div>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            {{-- <a href="#" target="_blank" class="btn btn-primary me-2"><span class="d-none d-md-block">Check Pro
                  Version</span> <span class="d-block d-md-none">Pro</span></a> --}}
                            <a href="#" target="_blank" class="btn btn-success"><span
                                    class="d-none d-md-block">{{ Auth::user()->level }} </span>
                                <span class="d-block d-md-none">Free</span></a>
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://img.freepik.com/free-vector/add-new-user_78370-4710.jpg' }}"
                                        alt="" width="35" height="35" class="rounded-circle">
                                    {{ Auth::user()->fullname }}!
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">My Profile</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-mail fs-6"></i>
                                            <p class="mb-0 fs-3">My Account</p>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-list-check fs-6"></i>
                                            <p class="mb-0 fs-3">My Task</p>
                                        </a>
                                        <a href="{{ route('logout') }}"
                                            class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->
            @yield('content')
        </div>
        <ul class="notifications-toast"></ul>
        <link rel="stylesheet" href="{{ asset('login-template/assets/css/styles.min.css') }}">
        <script src="{{ asset('login-template//assets/libs/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('login-template/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('login-template/assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
        <script src="{{ asset('login-template/assets/libs/simplebar/dist/simplebar.js') }}"></script>
        <script src="{{ asset('login-template/assets/js/sidebarmenu.js') }}"></script>
        <script src="{{ asset('login-template/assets/js/app.min.js') }}"></script>
        <script src="{{ asset('login-template/assets/js/dashboard.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>
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
    const createToastSuccess = (message) => {
        // Getting the icon and text for the toast based on the id passed
        const id = "success";
        const toast = document.createElement("li"); // Creating a new 'li' element for the toast
        toast.className = `toast-test ${id}`; // Setting the classes for the toast
        // Setting the inner HTML for the toast
        toast.innerHTML = `                                                       
                <div class="toast-icon">
                    <i class="fas fa-check-circle" style="color: #0ABF30"></i>
                </div>
                <div class="toast-content">
                    <strong>Success</strong>
                    <p>${message}</p>
                    
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

    const createToastError = (error) => {
        // Getting the icon and text for the toast based on the id passed
        id = 'error';
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
</script>

</html>
