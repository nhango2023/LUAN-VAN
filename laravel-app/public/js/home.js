       if (window.user) {
            console.log("User is logged in:", window.user.id);
        } else {
            console.log("User is not logged in.");
        }
       
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

            form.addEventListener('submit', async function(e) {
                e.preventDefault(); // prevent regular form submission
                if (!realInput.files || realInput.files.length === 0) {
                    createToastError('error', 'Vui lòng chọn file trước khi tạo câu hỏi.');

                    return;
                }
                if (CanSendInput() == 0) {
                    return;
                }
                const formData = new FormData(form);

                formData.append('model', 'gpt');
                const csrfToken = document.querySelector('input[name="_token"]').value;

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
                        if (data.code == 402) {
                            createToastError('error', 'Không đủ credit');
                            return;
                        } else if (data.code == 200) {
                            document.querySelector('.file-selector').disabled = true;
                            document.getElementById('btn-submit').disabled = true;
                            createToastInfor('info', data.message);
                            document.getElementById('loading_logo').classList.add('bloom-loading');
                            return;
                        }


                    })
                    .catch(error => {
                        console.error(error);
                        createToastError('error', error.message || 'Lỗi không xác định.');

                    });

            });


        });
    