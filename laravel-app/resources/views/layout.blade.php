<!DOCTYPE html>
<html lang="en">

<head>
    {{-- <script>
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
    </script> --}}
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
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    {{-- <script>
        window.user = @json(Auth::check() ? Auth::user() : null);
    </script>
    <script src="{{ asset('js/layout.js') }}" defer></script> --}}
</head>

<body>
    <script>
        const API_BASE_URL = "{{ env('API_URL') }}";
        const API_KEY = "{{ env('API_KEY') }}";
        // Assuming tasks are passed as a JSON object to the frontend
        const tasks = @json($tasks); // Get tasks from PHP (Laravel)

        if (tasks.length === 0) {
            console.log("No tasks are being processed.");
        } else {
            tasks.forEach((task) => {
                // Poll each task result
                pollTaskResult(task.id);
            });
        }

        async function pollTaskResult(taskId) {
            const interval = setInterval(async () => {
                const res = await fetch(`${API_BASE_URL}question/result/${taskId}`);
                const data = await res.json();

                if (data.status === 'done') {
                    clearInterval(interval); // Stop polling for this task
                    const results = data.result;

                    console.log("Results for task:", results);

                    // Call the controller to save the results
                    await saveTaskResults(taskId, results); // Call the controller with the results

                    // Optionally, continue handling other tasks or update UI
                } else if (data.status === 'error') {
                    clearInterval(interval);
                    console.error("Error processing task", taskId, data.result);
                }
            }, 5000); // Poll every 5 seconds
        }

        async function saveTaskResults(taskId, results) {
            try {
                // Call the backend controller to save the results
                const res = await fetch(`${API_BASE_URL}task/saveResults`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content') // CSRF token
                    },
                    body: JSON.stringify({
                        task_id: taskId,
                        results: results
                    })
                });

                const data = await res.json();
                if (res.ok) {
                    console.log("Task results saved successfully:", data);
                } else {
                    console.error("Error saving task results:", data);
                }
            } catch (error) {
                console.error("Error calling save task results:", error);
            }
        }
    </script>
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
                        <button class="close-btn-sidebar rounded-circle" onclick="closeNotifySidebar()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div id="notification-body-sidebar">

                    </div>

                    <div class="notification-footer-sidebar d-flex justify-content-center mt-4">
                        <button id="see-more-btn" class="btn btn-primary rounded-pill">See more</button>
                    </div>


                    <!-- More notifications as needed -->
                </div>

                <img src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : 'https://img.freepik.com/free-vector/add-new-user_78370-4710.jpg' }}"
                    alt="" width="30" height="30" class="rounded-circle avatar" style="cursor: pointer"
                    onclick="toggleProfileSidebar()">
                <!-- Notification Sidebar -->
                <div class="overlay-profile-sidebar" id="overlay-profile-sidebar" onclick="closeProfileSidebar()"></div>
                <div class="profile-sidebar" id="profile-sidebar">
                    <div class="notification-header-sidebar">
                        Profile
                        <button class="close-btn-sidebar rounded-circle" onclick="closeProfileSidebar()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
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

    <script>
        @auth
        const authUser = @json(auth()->user());
        if (authUser.isCreated == 1) {
            document.getElementById('loading_logo').classList.add('bloom-loading');
        }

        let currentLimit = 5; // Initialize with 5 messages

        document.addEventListener('DOMContentLoaded', function() {
            // Initial message load
            fetchMessages(currentLimit);

            // Attach event listener to 'See More' button
            document.getElementById('see-more-btn').addEventListener('click', function() {
                currentLimit += 5; // Increase limit by 5 (can change this to 10 if needed)
                fetchMessages(currentLimit); // Fetch the next set of messages
            });

            async function fetchMessages(limit) {
                @auth
                try {
                    const response = await fetch(`/message/show?limit=${limit}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin' // Needed if using Laravel Auth
                    });

                    if (!response.ok) throw new Error('Network response was not ok');

                    const data = await response.json();
                    const notifySidebar = document.getElementById('notification-body-sidebar');
                    notifySidebar.innerHTML =
                        ''; // Clear the existing messages (optional, to replace with new ones)

                    let display_dot = false;

                    data.messages.forEach(msg => {
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

                    // Show notification dot if there are unseen messages
                    if (display_dot) {
                        const notificationDot = document.getElementById('notification-dot');
                        notificationDot.classList.remove('d-none');
                    }

                    // Check if there are more messages
                    if (!data.has_more) {
                        // Hide "See More" button if no more messages are available
                        document.getElementById('see-more-btn').style.display = 'none';
                    }

                } catch (error) {
                    console.error('Error fetching messages:', error);
                }
            @endauth
        }
        });
        @endauth
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


    <script>
        console.log(API_BASE_URL)
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
