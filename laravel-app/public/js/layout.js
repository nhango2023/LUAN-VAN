
        if (window.user){
            user=window.user;
        
        if (user.isCreated == 1) {
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
            
        }
        });
    
    
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
        
        }