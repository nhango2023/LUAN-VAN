@extends('layout')
@section('content')
    <style>
        /* .upload-container {
                                                                                                                                                                background-color: #fff;
                                                                                                                                                                border: 2px dashed #ddd;
                                                                                                                                                                padding: 40px;
                                                                                                                                                                text-align: center;
                                                                                                                                                                width: 100%;
                                                                                                                                                                height: 100%;
                                                                                                                                                                border-radius: 8px;
                                                                                                                                                            }

                                                                                                                                                            .upload-container h3 {
                                                                                                                                                                margin-bottom: 20px;
                                                                                                                                                            }

                                                                                                                                                            .upload-container button {
                                                                                                                                                                background-color: #A0A0A0;
                                                                                                                                                                color: white;
                                                                                                                                                                border: none;
                                                                                                                                                                padding: 12px 20px;
                                                                                                                                                                font-size: 14px;
                                                                                                                                                                cursor: pointer;
                                                                                                                                                                border-radius: 4px;
                                                                                                                                                            }

                                                                                                                                                            .upload-container p {
                                                                                                                                                                margin-top: 10px;
                                                                                                                                                                color: #888;
                                                                                                                                                            }

                                                                                                                                                            .upload-container input[type="file"] {
                                                                                                                                                                display: none;
                                                                                                                                                            }

                                                                                                                                                            .drop-zone {
                                                                                                                                                                display: inline-block;
                                                                                                                                                                padding: 20px;
                                                                                                                                                                border: 2px dashed #007bff;
                                                                                                                                                                border-radius: 8px;
                                                                                                                                                                cursor: pointer;
                                                                                                                                                                transition: background-color 0.3s ease;
                                                                                                                                                            }

                                                                                                                                                            .drop-zone:hover {
                                                                                                                                                                background-color: #f1f9ff;
                                                                                                                                                            }

                                                                                                                                                            .drop-zone.active {
                                                                                                                                                                background-color: #f1f9ff;
                                                                                                                                                            } */
        .container-upload {
            text-align: center;
            width: 100%;
            max-width: 500px;
            min-height: 435px;
            margin: auto;
            background-color: white;
            border-radius: 16px;
            box-shadow: rgba(255, 255, 255, 0.1) 0px 1px 1px 0px inset, rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;
        }

        .header-section {
            padding: 25px 0px;
            text-align: center
        }

        .header-section h1 {
            font-weight: 500;
            font-size: 1.7rem;
            text-transform: uppercase;
            color: #707EA0;
            margin: 0px;
            margin-bottom: 8px;
        }

        .header-section p {
            margin: 5px;
            font-size: 0.95rem;
            color: #707EA0;
        }

        .drop-section {
            min-height: 250px;
            border: 1px dashed #A8B3E3;
            background-image: linear-gradient(180deg, white, #F1F6FF);
            margin: 5px 35px 35px 35px;
            border-radius: 12px;
            position: relative;
        }

        .drop-section div.col:first-child {
            opacity: 1;
            visibility: visible;
            transition-duration: 0.2s;
            transform: scale(1);
            width: 200px;
            margin: auto;
        }

        .drop-section div.col:last-child {
            font-size: 40px;
            font-weight: 700;
            color: #c0cae1;
            position: absolute;
            top: 0px;
            bottom: 0px;
            left: 0px;
            right: 0px;
            margin: auto;
            width: 200px;
            height: 55px;
            pointer-events: none;
            opacity: 0;
            visibility: hidden;
            transform: scale(0.6);
            transition-duration: 0.2s;
        }

        /* we will use "drag-over-effect" class in js */
        .drag-over-effect div.col:first-child {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: scale(1.1);
        }

        .drag-over-effect div.col:last-child {
            opacity: 1;
            visibility: visible;
            transform: scale(1);
        }

        .drop-section .cloud-icon {
            text-align: center;
            margin-top: 25px;
            margin-bottom: 20px;
        }

        .drop-section span,
        .drop-section button {
            display: block;
            margin: auto;
            color: #707EA0;
            margin-bottom: 10px;
        }

        .drop-section button {
            color: white;
            background-color: #5874C6;
            border: none;
            outline: none;
            padding: 7px 20px;
            border-radius: 8px;
            margin-top: 20px;
            cursor: pointer;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;
        }

        .drop-section input {
            display: none;
        }

        .list-section {
            display: none;
            text-align: left;
            margin: 0px 35px;
            padding-bottom: 20px;
        }

        .list-section .list-title {
            font-size: 0.95rem;
            color: #707EA0;
        }

        .list-section li {
            display: flex;
            margin: 15px 0px;
            padding-top: 4px;
            padding-bottom: 2px;
            border-radius: 8px;
            transition-duration: 0.2s;
        }

        .list-section li:hover {
            box-shadow: #E3EAF9 0px 0px 4px 0px, #E3EAF9 0px 12px 16px 0px;
        }

        .list-section li .col {
            flex: .1;
        }

        .list-section li .col:nth-child(1) {
            flex: .15;
            text-align: center;
        }

        .list-section li .col:nth-child(2) {
            flex: .75;
            text-align: left;
            font-size: 0.9rem;
            color: #3e4046;
            padding: 8px 10px;
        }

        .list-section li .col:nth-child(2) div.name {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            max-width: 250px;
            display: inline-block;
        }

        .list-section li .col .file-name span {
            color: #707EA0;
            float: right;
        }

        .list-section li .file-progress {
            width: 100%;
            height: 5px;
            margin-top: 8px;
            border-radius: 8px;
            background-color: #dee6fd;
        }

        .list-section li .file-progress span {
            display: block;
            width: 0%;
            height: 100%;
            border-radius: 8px;
            background-image: linear-gradient(120deg, #6b99fd, #9385ff);
            transition-duration: 0.4s;
        }

        .list-section li .col .file-size {
            font-size: 0.75rem;
            margin-top: 3px;
            color: #707EA0;
        }

        .list-section li .col svg.cross,
        .list-section li .col svg.tick {
            fill: #8694d2;
            background-color: #dee6fd;
            position: relative;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            border-radius: 50%;
        }

        .list-section li .col svg.tick {
            fill: #50a156;
            background-color: transparent;
        }

        .list-section li.complete span,
        .list-section li.complete .file-progress,
        .list-section li.complete svg.cross {
            display: none;
        }

        .list-section li.in-prog .file-size,
        .list-section li.in-prog svg.tick {
            display: none;
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
    </style>




    <!-- Main Content -->
    <div class="main-container">
        <!-- Text Input Section -->
        <div class="text-input-section">

            {{-- <div class="upload-container">
                <h3>Upload Your File</h3>
                <label for="file-upload" class="drop-zone">
                    <span>Choose Files</span>
                    
                </label>
                <p>or drop files here</p>
                <p id="file-name-display" style="color: #333; font-weight: bold;"></p>
            </div> --}}


            <div class="container">
                <div class="header-section">
                    <h1>Upload Files</h1>

                </div>
                <div class="drop-section">
                    <div class="col" style="text-align: center">
                        <div class="cloud-icon">
                            <img src="{{ asset('storage/images/cloud.png') }}" alt="cloud">
                        </div>
                        <span>Drag & Drop your files here</span>
                        <span>OR</span>
                        <button class="file-selector">Browse Files</button>
                        <input type="file" class="file-selector-input" multiple>
                    </div>
                    <div class="col">
                        <div class="drop-here">Drop Here</div>
                    </div>
                </div>
                <div class="list-section">
                    <div class="list-title">Uploaded Files</div>
                    <div class="list"></div>
                </div>
            </div>

        </div>

        <!-- Voice Selection Section -->
        <div class="voice-selection-section">
            <form action="{{ route('question.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                <!-- Hidden input file (vẫn có thể trigger bằng JS) -->
                <input type="file" name="file_upload" id="file-upload" style="display: none;">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">remember</label>
                        <input type="number" name="n_remember" class="form-control" id="inputEmail4">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">remember</label>
                        <input type="number" class="form-control" id="inputPassword4">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">understand</label>
                        <input type="number" name="n_understand" class="form-control" id="inputEmail4">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">understand</label>
                        <input type="number" class="form-control" id="inputPassword4">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">apply</label>
                        <input type="number" name="n_apply" class="form-control" id="inputEmail4">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">apply</label>
                        <input type="number" class="form-control" id="inputPassword4">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">analyze</label>
                        <input type="number" name="n_analyze" class="form-control" id="inputEmail4">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">analyz</label>
                        <input type="number" class="form-control" id="inputPassword4">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">evaluate</label>
                        <input type="number" name="n_evaluate" class="form-control" id="inputEmail4">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">evaluate</label>
                        <input type="number" class="form-control" id="inputPassword4">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">create</label>
                        <input type="number" name="n_create" class="form-control" id="inputEmail4">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">create</label>
                        <input type="number" class="form-control" id="inputPassword4">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Generate Question</button>


            </form>
            <ul class="notifications-toast"></ul>
            <div class="buttons">
                <button class="btn" id="success">Success</button>
            </div>

        </div>
    </div>


    </div>
    <script>
        document.getElementById("success").addEventListener("click", () => {
            createToast('success');
        });

        const realInput = document.getElementById("file-upload");
        const fakeInput = document.querySelector(".file-selector-input");
        // When a user selects a file using the external input
        fakeInput.addEventListener("change", function() {
            // Only assign the first selected file to the real input
            if (fakeInput.files.length > 0) {
                const file = fakeInput.files[0]; // get first file
                // Create a DataTransfer to assign file to real input
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                realInput.files = dataTransfer.files;
            }
        });
        document.querySelector('form').addEventListener('submit', function(e) {
            if (fakeInput.files.length > 0) {
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(fakeInput.files[0]); // lấy file đầu tiên
                realInput.files = dataTransfer.files;
            } else {
                alert("Vui lòng chọn file trước khi tạo câu hỏi.");
                e.preventDefault(); // ngăn không cho submit nếu chưa có file
            }
        });

        const dropArea = document.querySelector('.drop-section');
        const listSection = document.querySelector('.list-section');
        const listContainer = document.querySelector('.list');
        const fileSelector = document.querySelector('.file-selector');
        const fileSelectorInput = document.querySelector('.file-selector-input');

        // Browse button click triggers file input
        fileSelector.onclick = () => fileSelectorInput.click();

        // Handle file selection
        fileSelectorInput.onchange = () => {
            [...fileSelectorInput.files].forEach((file) => {
                if (typeValidation(file.type)) {
                    previewFile(file);
                } else {
                    alert('❌ Only PDF, Word (.doc/.docx), and TXT files are allowed!');
                }
            });
        };

        // Drag over
        dropArea.ondragover = (e) => {
            e.preventDefault();
            [...e.dataTransfer.items].forEach((item) => {
                if (typeValidation(item.type)) {
                    dropArea.classList.add('drag-over-effect');
                }
            });
        };

        // Drag leave
        dropArea.ondragleave = () => {
            dropArea.classList.remove('drag-over-effect');
        };

        // Drop file
        dropArea.ondrop = (e) => {
            e.preventDefault();
            dropArea.classList.remove('drag-over-effect');
            const files = e.dataTransfer.files || [];
            [...files].forEach((file) => {
                if (typeValidation(file.type)) {
                    previewFile(file);
                }
            });
        };

        // Validate file type
        function typeValidation(type) {
            return (
                type === 'application/pdf' ||
                type === 'application/msword' || // .doc
                type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || // .docx
                type === 'text/plain' // .txt
            );
        }

        const assetBaseUrl = "{{ asset('storage/images') }}";
        // Display file preview only (no upload)
        function previewFile(file) {
            listSection.style.display = 'block';
            const li = document.createElement('li');
            li.style.alignItems = 'center';
            li.innerHTML = `
                <div class="col">
                    <img style="width: 50px; height: 40px" src="${iconSelector(file.type)}" alt="">
                </div>
                <div class="col">
                    <div class="file-name">
                        <div class="name">${file.name}</div>
                    </div>
                    <div class="file-size">${(file.size / (1024 * 1024)).toFixed(2)} MB</div>
                </div>
                <div class="col">
                    <button class="remove-btn" style="border:none; background:transparent; cursor:pointer;">
                        <span class="material-icons" style="color: red;">close</span>
                    </button>
                </div>
            `;

            // Gán file vào input thật #file-upload
            const realInput = document.getElementById("file-upload");
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            realInput.files = dataTransfer.files;

            // Thêm sự kiện xóa
            li.querySelector('.remove-btn').addEventListener('click', () => {
                li.remove();
                realInput.value = ''; // clear file thực sự gửi đi
                if (listContainer.children.length === 0) {
                    listSection.style.display = 'none';
                }
            });

            listContainer.prepend(li);
        }


        // Choose icon based on type
        function iconSelector(type) {
            const map = {
                'application/pdf': 'pdf.png',
                'application/msword': 'word_download_icon.png',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document': 'word.png',
                'text/plain': 'txt.png',
            };
            return `${assetBaseUrl}/${map[type] || 'file.png'}`;
        }

        const notifications = document.querySelector(".notifications-toast")


        const toastDetails = {
            timer: 5000,
            success: {
                icon: 'fa-circle-check',
                text: 'Success: This is a success toast.',
            }
        }

        const removeToast = (toast) => {
            toast.classList.add("hide");
            if (toast.timeoutId) clearTimeout(toast.timeoutId); // Clearing the timeout for the toast
            setTimeout(() => toast.remove(), 500); // Removing the toast after 500ms
        }

        const createToast = (id) => {
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
                            <p>Vocalization created successfully,<br>you can check the result in history.</p>
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
    </script>
@endsection
