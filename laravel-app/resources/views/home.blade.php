@extends('layout')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

    <div class="container-fluid">
        <div class="row">
            <div class="text-input-section col-md-5">
                <div class="h-100 container d-flex flex-column justify-content-center">

                    <div class="drop-section">
                        <div class="col" style="text-align: center">
                            <div class="cloud-icon">
                                <img src="{{ asset('storage/images/cloud.png') }}" alt="cloud">
                            </div>
                            <span>Kéo và thả file</span>
                            <span>Hoặc</span>
                            <button {{ !Auth::check() || Auth::user()->isCreated ? 'disabled' : '' }}
                                class="file-selector">Tải lên file</button>
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
            <div class="voice-selection-section col-md-7">
                <div class="payment-options d-flex justify-content-between">
                    <div class="d-flex">
                        <input type="radio" id="rdo_number" name="payment" checked>
                        <label for="rdo_number" class="mr-2">
                            <span class="custom-radio"></span>
                            Số lượng
                        </label>
                        <input type="radio" id="rdo_percent" name="payment">
                        <label for="rdo_percent">
                            <span class="custom-radio"></span>
                            Số lượng (%)
                        </label>
                    </div>
                    {{-- <div>
                        <select class="form-select" name="provider" aria-label="Default select example">
                            <option value="gpt" selected>GPT</option>
                            <option value="gemini">GEMINI</option>
                            <option value="grok">GROK</option>
                        </select>
                    </div> --}}
                </div>

                <form method="post" enctype="multipart/form-data" action="javascript:void(0);">
                    @csrf
                    <!-- Hidden input file (vẫn có thể trigger bằng JS) -->
                    <input type="file" name="file_upload" id="file-upload" style="display: none;">

                    <div class="input-group mb-3" id='div_total'>
                        <div class="input-group-prepend">
                            <span class="input-group-text" style=" color: black;"><strong>Tổng số</strong></span>
                        </div>
                        <input id="total" type="number" min="0" value="0" class="form-control"
                            aria-label="Dollar amount (with dot and two decimal places)">
                        <button class="btn btn-success" {{ !Auth::check() || Auth::user()->isCreated ? 'disabled' : '' }}
                            id="suggest-btn" type="button">Đề xuất</button>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 d-none">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="background-color: #848fc6; color: black">Cấp
                                        1</span>
                                </div>
                                <input type="number" min="0" value="0" max="100" aria-label="First name"
                                    class="form-control" name="%_remember">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="input-group ">
                                <input onchange="updateTotal()" type="number" min="0" class="form-control"
                                    value="2" aria-label="" name="n_remember">
                                <div class="input-group-append">
                                    <span class="input-group-text" style="background-color: #848fc6; color: black">Cấp
                                        1</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 d-none">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="background-color: #89c0e6; color: black">Cấp
                                        2</span>
                                </div>
                                <input type="number" min="0" value="0" max="100" aria-label="First name"
                                    class="form-control" name="%_understand">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group ">
                                <input type="number" onchange="updateTotal()" min="0" class="form-control"
                                    value="2" name="n_understand"
                                    aria-label="Dollar amount (with dot and two decimal places)">
                                <div class="input-group-append">
                                    <span class="input-group-text" style="background-color: #89c0e6; color: black">Cấp
                                        2</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 d-none">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="background-color: #75ac82; color: black">Cấp
                                        3</span>
                                </div>
                                <input type="number" min="0" value="0" max="100" name="%_apply"
                                    aria-label="First name" class="form-control">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group ">
                                <input onchange="updateTotal()" type="number" min="0" class="form-control"
                                    value="2" name="n_apply"
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
                                <input type="number" min="0" max="100" aria-label="First name"
                                    class="form-control" value="0" name="%_analyze">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group ">
                                <input onchange="updateTotal()" type="number" min="0" class="form-control"
                                    value="2" name="n_analyze"
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
                                <input type="number" min="0" max="100" aria-label="First name"
                                    class="form-control" value="0" name="%_evaluate">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group ">
                                <input onchange="updateTotal()" type="number" min="0" class="form-control"
                                    value="2" name="n_evaluate"
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
                                <input type="number" min="0" max="100" aria-label="First name"
                                    class="form-control" value="0" name="%_create">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group ">
                                <input onchange="updateTotal()" type="number" min="0" class="form-control"
                                    value="2" name="n_create"
                                    aria-label="Dollar amount (with dot and two decimal places)">
                                <div class="input-group-append">
                                    <span class="input-group-text" style="background-color: #e78b76; color: black">Cấp
                                        6</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button id='btn-submit' type="submit"
                        {{ !Auth::check() || Auth::user()->isCreated ? 'disabled' : '' }} class="btn btn-primary">Tạo
                        câu hỏi</button>

                </form>
            </div>
        </div>
    </div>

    </div>


    {{-- <script src="{{ asset('js/home.js') }}" defer></script> --}}
    <script>
        function updateTotal() {
            const levelNames = [
                "n_remember", "n_understand", "n_apply",
                "n_analyze", "n_evaluate", "n_create"
            ];

            let total = 0;

            levelNames.forEach(name => {
                const input = document.querySelector(`input[name="${name}"]`);
                if (input && !isNaN(parseInt(input.value))) {
                    total += parseInt(input.value);
                }
            });

            document.getElementById("total").value = total;
        }

        // Gắn sự kiện onchange cho các trường n_*
        ["n_remember", "n_understand", "n_apply", "n_analyze", "n_evaluate", "n_create"].forEach(name => {
            const input = document.querySelector(`input[name="${name}"]`);
            if (input) {
                input.addEventListener("change", updateTotal);
                input.addEventListener("input", updateTotal); // xử lý cả khi gõ trực tiếp
            }
        });
        updateTotal();
        document.getElementById("suggest-btn").addEventListener("click", async () => {
            const numberQuestion = document.getElementById("total").value;
            if (numberQuestion < 1) {
                createToastError('error', 'Tổng số lượng câu hỏi phải lớn hơn 0');
                return;
            }

            const API_URL = "{{ env('API_URL') }}"
            try {
                document.getElementById("suggest-btn").disabled = true;
                const response = await fetch(`${API_URL}question/suggest-number-question/${numberQuestion}`);

                if (!response.ok) {
                    throw new Error("Lỗi khi gọi API");
                }

                const data = await response.json();
                // Gán kết quả vào các ô input tương ứng
                const fields = [
                    "n_remember", // cấp 1
                    "n_understand", // cấp 2
                    "n_apply", // cấp 3
                    "n_analyze", // cấp 4
                    "n_evaluate", // cấp 5
                    "n_create" // cấp 6
                ];

                fields.forEach((name, index) => {
                    const input = document.querySelector(`input[name="${name}"]`);
                    if (input) {
                        input.value = data.counts[index] ?? 0;
                    }
                });
                document.getElementById("suggest-btn").disabled = false;
            } catch (error) {
                document.getElementById("suggest-btn").disabled = false;
                createToastError('error', 'Không thể đề xuất câu hỏi');
            }
        });

        //toggle an hien input %
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
                    // total.classList.remove('d-none');
                } else {
                    rows.forEach(row => {
                        const firstChild = row.firstElementChild;
                        if (firstChild) {
                            firstChild.classList.add('d-none');
                        }
                    });
                    // total.classList.add('d-none');
                }
            }
            rdoPercentage.addEventListener('change', toggleVisibility);
            rdoNumber.addEventListener('change', toggleVisibility);
        });

        //tinh toan sau user nhap %
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

            async function startCreateQuestion(taskId) {
                const csrfToken = document.querySelector('input[name="_token"]').value;

                try {
                    const response = await fetch("/question/start", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken
                        },
                        body: JSON.stringify({
                            task_id: taskId
                        })
                    });

                    if (!response.ok) throw new Error("Failed to send task_id to Laravel");

                    // const result = await response.json();
                    // console.log("Laravel received task ID:", result);
                    const data = await res.json();
                    const insertedFileId = data.id_file;
                    return insertedFileId;
                } catch (err) {
                    console.error("Error sending task_id to Laravel:", err);
                }
            }

            function CanSendInput() {
                const isPercentMode = document.getElementById('rdo_percent').checked;
                const total = parseInt(document.getElementById('total').value);
                const getInputVal = name => parseInt(document.querySelector(`[name="${name}"]`)?.value || 0);
                const values = {
                    remember: getInputVal('n_remember'),
                    understand: getInputVal('n_understand'),
                    apply: getInputVal('n_apply'),
                    analyze: getInputVal('n_analyze'),
                    evaluate: getInputVal('n_evaluate'),
                    create: getInputVal('n_create'),
                };

                if (isPercentMode) {
                    if (isNaN(total) || total <= 0) {
                        createToastError('error', 'Tổng số câu hỏi phải lớn hơn 0.');
                        return 0;
                    }
                    const sum = Object.values(values).reduce((acc, val) => acc + val, 0);
                    if (sum > total) {
                        createToastError('error', `Tổng số câu hỏi (${sum}) vượt quá tổng (${total}).`);
                        return 0;
                    } else if (sum < total) {
                        createToastError('error', `Tổng số câu hỏi (${sum}) nhỏ hơn tổng (${total}).`);
                        return 0;
                    }
                } else {
                    const allZero = Object.values(values).every(v => v === 0);
                    if (allZero) {
                        createToastError('error', 'Bạn phải nhập ít nhất một số lượng câu hỏi.');
                        return 0;
                    }
                }
                return 1;
            }


            const form = document.querySelector('form');
            const submitButton = form.querySelector('button[type="submit"]');
            const realInput = document.getElementById('file-upload');

            //save file and task id to user
            async function saveTaskId(taskId, status, total_question) {

                const file = realInput.files[0]; // Get the selected file

                const formData = new FormData();
                formData.append('task_id', taskId); // Append task_id to FormData
                formData.append('file', file); // Append the file to FormData
                formData.append('status', status)
                formData.append('total_question', total_question)
                try {
                    const response = await fetch('/question/start', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'), // CSRF Token
                        },
                        body: formData
                    });

                    if (!response.ok) {
                        throw new Error('Save task failed');
                    }

                    const result = await response.json();
                    console.log("File uploaded successfully:", result);
                } catch (error) {
                    console.error("Error uploading file:", error);
                }
            }


            form.addEventListener('submit', async function(e) {
                e.preventDefault(); // prevent normal submission

                if (!realInput.files || realInput.files.length === 0) {
                    createToastError('error', 'Vui lòng chọn file trước khi tạo câu hỏi.');
                    return;
                }

                if (CanSendInput() == 0) {
                    return;
                }

                const formData = new FormData(form);

                formData.append('model', 'gpt');
                formData.append('token', 5000); // Ví dụ: truyền số token hiện có

                // Convert từng cấp độ thành JSON để gửi cho FastAPI
                const Nquestion = {
                    remember: parseInt(form.querySelector('input[name="n_remember"]').value),
                    understand: parseInt(form.querySelector('input[name="n_understand"]').value),
                    apply: parseInt(form.querySelector('input[name="n_apply"]').value),
                    analyze: parseInt(form.querySelector('input[name="n_analyze"]').value),
                    evaluate: parseInt(form.querySelector('input[name="n_evaluate"]').value),
                    create: parseInt(form.querySelector('input[name="n_create"]').value)
                };
                formData.append('Nquestion_json', JSON.stringify(Nquestion));
                const total_question =
                    Nquestion.remember +
                    Nquestion.understand +
                    Nquestion.apply +
                    Nquestion.analyze +
                    Nquestion.evaluate +
                    Nquestion.create;
                const currentPlan = @json($currentPlan);
                const tasks = @json($tasks);
                const number_task = tasks.length;
                const authUser = @json(Auth::user());
                if (total_question > authUser.available_question) {
                    createToastError('error',
                        'Số lượng câu hỏi có thể tạo nhỏ hơn số lượng bạn yêu cầu, vui lòng mua thêm gói của bạn'
                    );
                    return;
                }
                if (number_task >= currentPlan.processes) {
                    createToastError('error',
                        'Bạn đã đạt tối đa tiến trình tạo câu hỏi, vui lòng đợi các tiến trình tạo xong câu, sau đó tiếp tục tạo'
                    );
                    return;
                }
                const file = realInput.files[0];
                formData.append('file', file);
                const fileName = file.name;
                const API_BASE_URL = "{{ env('API_URL') }}";
                document.querySelector('.file-selector').disabled = true;
                document.getElementById('btn-submit').disabled = true;
                try {
                    const response = await fetch(`${API_BASE_URL}question/create`, {
                        method: 'POST',
                        headers: {
                            'API-Key': window.API_KEY,
                        },
                        body: formData
                    });
                    if (!response.ok) {
                        throw new Error('Tạo câu hỏi thất bại.');
                    }

                    const data = await response.json();
                    const taskId = data.task_id;
                    const status = data.status;
                    id_file = await saveTaskId(taskId, status, total_question);

                    // document.querySelector('.file-selector').disabled = false;
                    // document.getElementById('btn-submit').disabled = false;
                    window.activeTaskCount++;

                    // const isLoading = document.getElementById('loading_logo').classList.contains(
                    //     'bloom-loading');

                    // if (!isLoading) {
                    //     document.getElementById('loading_logo').classList.add('bloom-loading');
                    // }
                    createToastInfor('info', 'Đang tạo câu hỏi...');
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                } catch (error) {
                    document.querySelector('.file-selector').disabled = false;
                    document.getElementById('btn-submit').disabled = false;
                    console.error('Fetch Error:', error);
                    createToastError('error', error.message || 'Lỗi không xác định.');
                }
            });

        });
    </script>
@endsection
