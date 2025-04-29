@extends('layout')
@section('content')
    <style>
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
            height: 150px;
            overflow-y: scroll
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


        .payment-options {
            display: flex;
            gap: 12px;
        }

        .payment-options input[type="radio"] {
            display: none;
        }

        .payment-options label {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            border: 2px solid #3b82f6;
            /* blue-500 */
            border-radius: 8px;
            cursor: pointer;
            color: #3b82f6;
            font-weight: 600;
            font-family: sans-serif;
            transition: all 0.2s ease;
        }

        .payment-options label .custom-radio {
            width: 20px;
            height: 20px;
            border: 2px solid #3b82f6;
            border-radius: 50%;
            margin-right: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .payment-options label .custom-radio::after {
            content: "";
            width: 10px;
            height: 10px;
            background: white;
            border-radius: 50%;
            display: none;
        }

        .payment-options input[type="radio"]:checked+label {
            background-color: #3b82f6;
            color: white;
        }

        .payment-options input[type="radio"]:checked+label .custom-radio {
            background-color: white;
        }

        .payment-options input[type="radio"]:checked+label .custom-radio::after {
            display: block;
        }
    </style>
    <!-- Main Content -->

    <!-- Text Input Section -->
    <div class="text-input-section">
        <div class="container">
            <div class="header-section">
                <h1>Tải file</h1>
            </div>
            <div class="drop-section">
                <div class="col" style="text-align: center">
                    <div class="cloud-icon">
                        <img src="{{ asset('storage/images/cloud.png') }}" alt="cloud">
                    </div>
                    <span>Kéo và thả file</span>
                    <span>Hoặc</span>
                    <button {{ !Auth::check() ? 'disabled' : '' }} class="file-selector">Tải lên file</button>
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
        <div class="payment-options">
            <input type="radio" id="rdo_number" name="payment" checked>
            <label for="rdo_number">
                <span class="custom-radio"></span>
                Số lượng
            </label>
            <input type="radio" id="rdo_percent" name="payment">
            <label for="rdo_percent">
                <span class="custom-radio"></span>
                Số lượng (theo %)
            </label>
        </div>

        <form method="post" enctype="multipart/form-data" action="javascript:void(0);">
            @csrf
            <!-- Hidden input file (vẫn có thể trigger bằng JS) -->
            <input type="file" name="file_upload" id="file-upload" style="display: none;">

            <div class="input-group mb-3 d-none" id='div_total'>
                <div class="input-group-prepend">
                    <span class="input-group-text" style=" color: black;">Tổng số</span>
                </div>
                <input id="total" type="number" class="form-control"
                    aria-label="Dollar amount (with dot and two decimal places)">
            </div>

            <div class="form-row">
                <div class="form-group col-md-6 d-none">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="background-color: #848fc6; color: black">Cấp 1</span>
                        </div>
                        <input type="number" aria-label="First name" class="form-control" name="%_remember">
                        <span class="input-group-text">%</span>
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <div class="input-group ">
                        <input type="number" class="form-control" aria-label="" name="n_remember">
                        <div class="input-group-append">
                            <span class="input-group-text" style="background-color: #848fc6; color: black">Cấp 1</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6 d-none">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="background-color: #89c0e6; color: black">Cấp 2</span>
                        </div>
                        <input type="number" aria-label="First name" class="form-control" name="%_understand">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="input-group ">
                        <input type="number" class="form-control" name="n_understand"
                            aria-label="Dollar amount (with dot and two decimal places)">
                        <div class="input-group-append">
                            <span class="input-group-text" style="background-color: #89c0e6; color: black">Cấp 2</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 d-none">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="background-color: #75ac82; color: black">Cấp 3</span>
                        </div>
                        <input type="number" name="%_apply" aria-label="First name" class="form-control">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="input-group ">
                        <input type="number" class="form-control" name="n_apply"
                            aria-label="Dollar amount (with dot and two decimal places)">
                        <div class="input-group-append">
                            <span class="input-group-text" style="background-color: #75ac82; color: black">Cấp
                                3</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 d-none">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="background-color: #aed981; color: black">Cấp
                                4</span>
                        </div>
                        <input type="number" aria-label="First name" class="form-control" name="%_analyze">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="input-group ">
                        <input type="number" class="form-control" name="n_analyze"
                            aria-label="Dollar amount (with dot and two decimal places)">
                        <div class="input-group-append">
                            <span class="input-group-text" style="background-color: #aed981; color: black">Cấp
                                4</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 d-none">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="background-color: #f3da69; color: black">Cấp
                                5</span>
                        </div>
                        <input type="number" aria-label="First name" class="form-control" name="%_evaluate">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="input-group ">
                        <input type="number" class="form-control" name="n_evaluate"
                            aria-label="Dollar amount (with dot and two decimal places)">
                        <div class="input-group-append">
                            <span class="input-group-text" style="background-color: #f3da69; color: black">Cấp
                                5</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6 d-none">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="background-color: #e78b76; color: black">Cấp
                                6</span>
                        </div>
                        <input type="number" aria-label="First name" class="form-control" name="%_create">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="input-group ">
                        <input type="number" class="form-control" name="n_create"
                            aria-label="Dollar amount (with dot and two decimal places)">
                        <div class="input-group-append">
                            <span class="input-group-text" style="background-color: #e78b76; color: black">Cấp
                                6</span>
                        </div>
                    </div>
                </div>
            </div>
            <button id='btn-submit' type="submit" {{ !Auth::check() ? 'disabled' : '' }} class="btn btn-primary">Tạo
                câu hỏi</button>
        </form>

        {{-- <div class="buttons">
                <button class="btn" id="success">Success</button>
            </div> --}}

    </div>


    </div>
    {{-- @vite(['resources/js/app.js', 'resources/css/app.css']) --}}
    {{-- <script>
        
            console.log("eeeddd")
            Echo.channel('testchanel')
                .listen('App\\Events\\testEvent', (e) => {
                    console.log("fdasfasfasd", e);
                });
        }
    </script> --}}
    @vite('resources/js/app.js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rdoPercentage = document.getElementById('rdo_percent');
            const rdoNumber = document.getElementById('rdo_number');
            const formRows = document.querySelectorAll('.form-row');
            const total = document.getElementById('div_total');
            const rows = document.querySelectorAll('.form-row'); // gets the first .form-row

            function toggleVisibility() {

                if (rdoPercentage.checked) {
                    rows.forEach(row => {
                        const firstChild = row.firstElementChild;
                        if (firstChild) {
                            firstChild.classList.remove('d-none');
                        }
                    });
                    total.classList.remove('d-none');
                } else {
                    rows.forEach(row => {
                        const firstChild = row.firstElementChild;
                        if (firstChild) {
                            firstChild.classList.add('d-none');
                        }
                    });
                    total.classList.add('d-none');
                }
            }

            // Set correct state on page load
            // toggleVisibility();

            // Event listeners
            rdoPercentage.addEventListener('change', toggleVisibility);
            rdoNumber.addEventListener('change', toggleVisibility);
        });


        document.addEventListener('DOMContentLoaded', function() {
            const totalInput = document.getElementById('total');

            // List of field names (without prefixes)
            const fields = ['remember', 'understand', 'apply', 'analyze', 'evaluate', 'create'];

            fields.forEach(field => {
                const percentInput = document.querySelector(`input[name="%_${field}"]`);
                const numberInput = document.querySelector(`input[name="n_${field}"]`);

                if (percentInput && numberInput) {
                    percentInput.addEventListener('mouseleave', function() {
                        const total = parseFloat(totalInput.value);
                        const percent = parseFloat(percentInput.value);

                        if (!isNaN(total) && !isNaN(percent)) {
                            numberInput.value = Math.round(total * percent / 100);
                        }
                    });
                }
            });
        });



        // document.getElementById("success").addEventListener("click", () => {
        //     createToast('success');
        // });

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
                    alert(' Only PDF, Word (.doc/.docx), and TXT files are allowed!');
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



        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitButton = form.querySelector('button[type="submit"]');
            const realInput = document.getElementById('file-upload');

            form.addEventListener('submit', async function(e) {
                e.preventDefault(); // prevent regular form submission
                if (!realInput.files || realInput.files.length === 0) {
                    createToastError('error', 'Vui lòng chọn file trước khi tạo câu hỏi.');

                    return;
                }
                const formData = new FormData(form);
                const csrfToken = document.querySelector('input[name="_token"]').value;
                document.getElementById('btn-submit').disabled = true;
                fetch('/question/create', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Tạo câu hỏi thất bại.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        createToastInfor('info', data.message);
                    })
                    .catch(error => {
                        console.error(error);
                        createToastError('error', error.message || 'Lỗi không xác định.');
                    });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            console.log('test');
            window.Echo.channel('testChannel')
                .listen('testingEvent', (e) => {
                    document.getElementById('btn-submit').disabled = true;
                    createToastSuccess('success');
                })
        })
    </script>
@endsection
