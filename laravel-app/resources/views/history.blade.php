@extends('layout')
@section('content')
    <style>
        .history-header {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
        }

        .history-header .tabs a {
            text-decoration: none;
            padding: 10px;
            color: #0078d4;
            margin-right: 10px;
            font-weight: 500;
        }

        .history-header .tabs a.active {
            color: #28a745;
            font-weight: bold;
        }

        .history-header .delete-all {
            color: #ff4c4c;
            font-weight: bold;
            cursor: pointer;
        }

        .history-item {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .history-item .audio-controls {
            display: flex;
            align-items: center;
        }

        .history-item .audio-controls button {
            background-color: #0078d4;
            color: #fff;
            border: none;
            padding: 5px 10px;
            margin-right: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .history-item .audio-controls button:hover {
            background-color: #005fa3;
        }

        .history-item .details {
            margin-top: 10px;
            font-size: 12px;
            color: #666;
        }

        .history-item .details span {
            color: #0078d4;
            cursor: pointer;
            text-decoration: underline;
        }

        .history-item .actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .history-item .actions button {
            background-color: #fff;
            color: #0078d4;
            border: 1px solid #0078d4;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .history-item .actions button:hover {
            background-color: #0078d4;
            color: #fff;
        }

        .history-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
            margin-top: 10px;
        }

        .history-card .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .history-card .header .voice-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .history-card .header .voice-info .icon {
            background-color: #e0e0e0;
            border-radius: 50%;
            padding: 5px;
        }

        .history-card .header .voice-info .tags {
            display: flex;
            gap: 5px;
        }

        .history-card .header .voice-info .tags span {
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 12px;
        }

        .history-card .header .voice-info .tags .id {
            background-color: #f0f0f0;
        }

        .history-card .header .voice-info .tags .name {
            background-color: #ffe6e6;
        }

        .history-card .header .voice-info .tags .credits {
            background-color: #e6f7fa;
        }

        .history-card .header .voice-info .tags .quality {
            background-color: #fff3cd;
        }

        .history-card .header .voice-info .tags .speed {
            background-color: #e6e6e6;
            color: #666;
        }

        .history-card .header .timestamp {
            font-size: 12px;
            color: #666;
        }

        .history-card .text {
            font-size: 14px;
            color: #333;
            margin-bottom: 10px;
        }

        .history-card .audio-player {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .history-card .audio-player .play-btn {
            background: none;
            border: none;
            cursor: pointer;
        }

        .history-card .audio-player .timeline {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .history-card .audio-player .timeline input {
            width: 100%;
        }

        .history-card .audio-player .actions {
            display: flex;
            gap: 10px;
        }

        .history-card .audio-player .actions button {
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
        }

        .history-card .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #666;
        }

        .history-card .footer .details {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }

        .history-card .footer .actions {
            display: flex;
            gap: 10px;
        }

        .history-card .footer .actions span {
            color: #666;
        }

        .history-card .footer .actions button {
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
        }

        .questionnaire {}

        .category {
            margin-bottom: 20px;
        }

        .category-btn {
            width: 100%;
            padding: 15px;
            text-align: left;
            background-color: #007bff;
            color: white;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }

        .questions-container {
            display: none;
            margin-top: 10px;
            padding-left: 20px;
        }

        .question {
            margin-bottom: 15px;
        }

        .question-text {
            font-weight: bold;
        }

        .options {
            list-style-type: none;
            padding: 0;
        }

        .options li {
            margin: 5px 0;
        }

        .correct-answer {
            margin-top: 10px;
            color: green;
        }

        .category-btn:focus {
            outline: none;
        }

        .category-btn:hover {
            background-color: #0056b3;
        }

        .category-btn:active {
            background-color: #004085;
        }

        .tab-QG {
            color: black;

        }

        .tab-history {
            color: #238a6a;
        }

        .info-box {
            background-color: #fffde7;
            border: 1px solid #f0c14b;
            padding: 30px;
            border-radius: 8px;
            max-width: 512px;
            margin: 80px auto;
            text-align: center;
        }

        .info-box a i {
            color: white;
            font-size: 20px;
            vertical-align: middle;
            margin-right: 10px;
        }

        .info-box h5 {
            font-weight: 600;
            color: #5a3310;
            margin-top: 15px;
        }

        .info-box h5 i {
            color: #5a3310;
            font-size: 20px;
            vertical-align: middle;
            margin-right: 10px;
        }

        .info-box p {
            color: #5a3310;
            margin: 15px 0 25px;
        }

        .info-box .btn {
            margin: 5px;
            font-weight: 500;
        }

        .btn-brown {
            background-color: #6b3c0f;
            color: white;
            border: none;
        }

        .btn-brown:hover {
            background-color: #5a2e0d;
        }
    </style>

    <div class="history-header">
        <div class="tabs">
            <a href="#" class="active">All</a>
            <a href="#">Text</a>
            <a href="#">Documents</a>
            <a href="#">Stories</a>
        </div>
        <div class="delete-all">
            Delete all
        </div>
    </div>

    @auth
        @php
            $levelLabels = [
                'remember' => 'Cấp 1',
                'understand' => 'Cấp 2',
                'apply' => 'Cấp 3',
                'analyze' => 'Cấp 4',
                'evaluate' => 'Cấp 5',
                'create' => 'Cấp 6',
            ];

            $levelColors = [
                'remember' => '#848fc6',
                'understand' => '#89c0e6',
                'apply' => '#75ac82',
                'analyze' => '#aed981',
                'evaluate' => '#f3da69',
                'create' => '#e78b76',
            ];
        @endphp

        @foreach ($groupedQuestions as $fileId => $fileGroup)
            <div class="history-card mt-3">
                <div class="header">

                    <div class="tags">
                        <h6>📝 File: {{ $fileGroup['original_name'] }}</h6>
                    </div>

                    <div class="timestamp" style="color: #94a3b8">{{ $fileGroup['created_at'] }}</div>
                </div>
                <div id="export-content">
                    <div class="text">
                        @foreach ($fileGroup['levels'] as $level => $questions)
                            <div class="category" id="{{ $level }}">
                                <button class="category-btn" style="background-color: {{ $levelColors[$level] }}; color: black">
                                    {{ $levelLabels[$level] }} - {{ count($questions) }} câu hỏi
                                </button>
                                <div class="questions-container">
                                    @foreach ($questions as $index => $q)
                                        <div class="question">
                                            <p class="question-text"><strong>Câu {{ $index + 1 }}:</strong>
                                                {{ $q['question'] }}</p>
                                            <ul class="options">
                                                @foreach ($q['options'] as $option)
                                                    <li>{{ $option }}</li>
                                                @endforeach
                                            </ul>
                                            <p class="correct-answer">✅ <strong>Đáp án đúng:</strong> {{ $q['answer'] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="footer">
                    <div class="details"><i class="fa fa-info-circle"></i>Details</div>
                    <div class="actions">
                        <span># {{ \Illuminate\Support\Str::uuid() }}</span>
                        <button><i class="fa fa-thumbs-up"></i></button>
                        <button><i class="fa fa-thumbs-down"></i></button>
                    </div>
                </div>
                <div class="d-flex align-items-center my-1" style="margin-left: -5px; color: black">
                    <i class="material-icons">download</i>
                    <div>Download</div>
                </div>
                <div class="d-flex justify-content-left">
                    <button onclick="exportQuestionsToExcel()" style="" type="button"
                        class="btn btn-light d-flex align-items-center">
                        <img style="width: 50px; height: 30px" src="{{ asset('storage/images/excel_download_icon.png') }}"
                            alt="">
                    </button>
                    <button id="btn-word" onclick="Export2Doc('export-content')" style="" type="button"
                        class="btn btn-light d-flex align-items-center mx-1">
                        <img style="width: 50px; height: 30px" src="{{ asset('storage/images/word_download_icon.png') }}"
                            alt="">
                    </button>
                    <button onclick="exportToText()" style="" type="button"
                        class="btn btn-light d-flex align-items-center">
                        <img style="width: 50px; height: 30px" src="{{ asset('storage/images/txt_download_icon.png') }}"
                            alt="">
                    </button>
                </div>
            </div>
        @endforeach
    @else
        <div class="info-box shadow-sm">
            <h5><i class="fas fa-info-circle"></i> Bạn muốn xem lịch sử tạo câu hỏi của mình?</h5>
            <p>Bạn có thể xem lịch sử tạo câu hỏi sau khi đăng nhập hoặc đăng ký nếu cho có tài khoản</p>
            <a href="{{ route('signup') }}" class="btn btn-brown">
                Sign in<i class="fas fa-arrow-right ml-1"></i>
            </a>
            <a href="{{ route('login') }}" class="btn btn-brown">Login</a>
        </div>
    @endauth

    @vite('resources/js/app.js')
    <script>
        setTimeout(() => {
            console.log('test')
            window.Echo.channel('testChannel')
                .listen('testingEvent', (e) => {
                    console.log(e);
                })
        }, 3000);
    </script>
    <script>
        document.querySelectorAll('.category-btn').forEach(button => {
            button.addEventListener('click', function() {
                const questionsContainer = this.nextElementSibling;
                questionsContainer.style.display =
                    questionsContainer.style.display === 'block' ? 'none' : 'block';
            });
        });

        function exportQuestionsToExcel() {
            const data = [];
            const categories = document.querySelectorAll('.category');

            categories.forEach(category => {
                const level = category.getAttribute('id');
                const questions = category.querySelectorAll('.question');

                questions.forEach((qEl, index) => {
                    const questionText = qEl.querySelector('.question-text')?.innerText.replace(
                        /^Câu \d+:\s*/, '') || '';
                    const answer = qEl.querySelector('.correct-answer')?.innerText.replace(
                        /^✅\s*Đáp án đúng:\s*/, '') || '';
                    const options = Array.from(qEl.querySelectorAll('.options li')).map(li => li.innerText);

                    data.push({
                        'Cấp độ': level,
                        'Câu hỏi': questionText,
                        'A': options[0] || '',
                        'B': options[1] || '',
                        'C': options[2] || '',
                        'D': options[3] || '',
                        'Đáp án đúng': answer
                    });
                });
            });

            // Convert to worksheet
            const worksheet = XLSX.utils.json_to_sheet(data);
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Questions");

            // Trigger download
            XLSX.writeFile(workbook, "cau_hoi.xlsx");
        }

        function exportToText() {
            let content = '';
            const categories = document.querySelectorAll('.category');

            categories.forEach(category => {
                const level = category.getAttribute('id');
                content += `=== ${level.toUpperCase()} ===\n`;

                const questions = category.querySelectorAll('.question');
                questions.forEach((qEl, index) => {
                    const questionText = qEl.querySelector('.question-text')?.innerText || '';
                    const answer = qEl.querySelector('.correct-answer')?.innerText || '';
                    const options = Array.from(qEl.querySelectorAll('.options li')).map(li => li.innerText);

                    content += `\n${questionText}\n`;
                    options.forEach(opt => content += `${opt}\n`);
                    content += `${answer}\n\n`;
                });
            });

            const blob = new Blob([content], {
                type: 'text/plain'
            });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'cau_hoi.txt';
            link.click();
        }



        async function Export2Doc(elementId) {
            const preHtml = `
                <html xmlns:o='urn:schemas-microsoft-com:office:office' 
                    xmlns:w='urn:schemas-microsoft-com:office:word' 
                    xmlns='http://www.w3.org/TR/REC-html40'>
                <head><meta charset='utf-8'><title>Export HTML to Word</title></head><body>`;
            const postHtml = "</body></html>";
            const content = document.getElementById(elementId).innerHTML;

            const html = preHtml + content + postHtml;

            const blob = new Blob(['\ufeff', html], {
                type: 'application/msword'
            });

            // Use File System Access API if available
            if (window.showSaveFilePicker) {
                try {
                    const handle = await window.showSaveFilePicker({
                        suggestedName: 'questions.doc',
                        types: [{
                            description: 'Word Document',
                            accept: {
                                'application/msword': ['.doc']
                            },
                        }],
                    });

                    const writable = await handle.createWritable();
                    await writable.write(blob);
                    await writable.close();
                    alert("Save file successfully!");
                } catch (err) {

                    alert("failed!, please try again");
                }
            } else {
                // Fallback for older browsers
                const url = URL.createObjectURL(blob);
                const link = document.createElement("a");
                link.href = url;
                link.download = "questions.doc";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }
    </script>
@endsection
