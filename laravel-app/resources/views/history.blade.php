@extends('layout')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/history.css') }}">

    <div class="mx-auto">
        <div class="main-navbar-section">
            <div class="main-navbar-tabs">
                <div>
                    <span><i class="fa fa-cube"></i></span>
                    <span><b>All</b></span>
                </div>

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
            {{-- <div class="delete-history-section">
                <div class="mx-auto">
                    <div class="delete-history-text d-inline-block mr-5">
                        All history after 30 days will be deleted automatically.
                    </div>
                    <button class="delete-history-btn d-inline">
                        <i class="fa fa-trash-o"></i> Delete all
                    </button>
                </div>
            </div> --}}
            @foreach ($groupedQuestions as $fileId => $fileGroup)
                <div class="history-card mt-3">
                    <div class="header">

                        <div class="tags">
                            <h6>📝 File: {{ $fileGroup['original_name'] }}</h6>
                        </div>

                        <div class="timestamp ml-5" style="color: #94a3b8">{{ $fileGroup['created_at'] }}</div>
                    </div>
                    <div id="export-content">
                        <div class="text">
                            @foreach ($fileGroup['levels'] as $level => $questions)
                                <div class="category" id="{{ $level }}">
                                    <button class="category-btn"
                                        style="background-color: {{ $levelColors[$level] }}; color: black">
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
                                                <p class="correct-answer">✅ <strong>Đáp án đúng:</strong> {{ $q['answer'] }}
                                                </p>
                                                <button class="btn text-start w-100" type="button" data-toggle="collapse"
                                                    data-target="#collapse-details-{{ $q['id'] }}" aria-expanded="false"
                                                    aria-controls="collapse-details-{{ $q['id'] }}"
                                                    style="background: #f8fafc">
                                                    <i class="fa fa-box"></i>
                                                    <span class="ml-2">Đoạn văn gốc</span>
                                                </button>
                                                <div class="collapse" id="collapse-details-{{ $q['id'] }}">
                                                    <div class="card card-body">
                                                        <p>{{ $q['document'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    {{-- <div class="footer w-100 mb-3">
                        <button class="btn text-start w-100 py-1" type="button" data-toggle="collapse"
                            data-target="#collapse-details-{{ $fileId }}" aria-expanded="false"
                            aria-controls="collapse-details-{{ $fileId }}" style="background: #f8fafc">
                            <i class="fa fa-info-circle"></i><span class="ml-2">Details</span>
                        </button>
                        <div class="collapse" id="collapse-details-{{ $fileId }}">
                            <div class="card card-body">
                                <form>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Môn học</label>
                                        <input type="text" class="form-control" name="subject_name" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" value="{{ $fileGroup['subject_name'] }}">

                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Thời gian làm bài (phút)</label>
                                        <input type="number" name="time" class="form-control" id="exampleInputPassword1"
                                            value="">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Change</button>
                                    <small id="emailHelp" class="form-text text-muted mt-2">Thông tin trên sẽ được hiển thị
                                        trong
                                        file tải về</small>
                                </form>
                            </div>
                        </div>
                    </div> --}}
                    <div class="d-flex align-items-center my-1 ml-3" style=" color: black">
                        <i class="material-icons">download</i>
                        <div>Download</div>
                    </div>
                    <div class="d-flex justify-content-left">
                        <button onclick="exportQuestionsToExcel()" style="" type="button"
                            class="btn btn-light d-flex align-items-center">
                            <img style="width: 50px; height: 30px" src="{{ asset('storage/images/excel_download_icon.png') }}"
                                alt="">
                        </button>
                        <button id="btn-word" onclick="window.location.href='{{ route('export.word', $fileId) }}'"
                            style="" type="button" class="btn btn-light d-flex align-items-center mx-1">
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
            <div class="clearfix mt-3">
                {{-- <div class="hint-text">
                    Showing <b>{{ $groupedQuestions->count() }}</b> out of <b>{{ $groupedQuestions->total() }}</b> entries
                </div> --}}
                <ul class="pagination justify-content-center">
                    {{-- Previous Page --}}
                    <li class="page-item {{ $groupedQuestions->onFirstPage() ? 'disabled' : '' }}">
                        <a href="{{ $groupedQuestions->previousPageUrl() }}" class="page-link">Previous</a>
                    </li>

                    {{-- Page Numbers --}}
                    @php
                        $currentPage = $groupedQuestions->currentPage();
                        $lastPage = $groupedQuestions->lastPage();
                        $maxPagesToShow = 5; // Max number of pages to show in the pagination
                        $halfMaxPages = floor($maxPagesToShow / 2);
                        $start = max(1, $currentPage - $halfMaxPages);
                        $end = min($lastPage, $currentPage + $halfMaxPages);

                        // Adjust if the end page is less than the total pages
                        if ($end - $start + 1 < $maxPagesToShow) {
                            $start = max(1, $end - $maxPagesToShow + 1);
                        }
                    @endphp

                    {{-- Show first page --}}
                    @if ($start > 1)
                        <li class="page-item">
                            <a href="{{ $groupedQuestions->url(1) }}" class="page-link">1</a>
                        </li>
                        @if ($start > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    {{-- Show page numbers in the range --}}
                    @for ($i = $start; $i <= $end; $i++)
                        <li class="page-item {{ $groupedQuestions->currentPage() == $i ? 'active' : '' }}">
                            <a href="{{ $groupedQuestions->url($i) }}" class="page-link">{{ $i }}</a>
                        </li>
                    @endfor

                    {{-- Show last page --}}
                    @if ($end < $lastPage)
                        @if ($end < $lastPage - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item">
                            <a href="{{ $groupedQuestions->url($lastPage) }}" class="page-link">{{ $lastPage }}</a>
                        </li>
                    @endif

                    {{-- Next Page --}}
                    <li class="page-item {{ $groupedQuestions->hasMorePages() ? '' : 'disabled' }}">
                        <a href="{{ $groupedQuestions->nextPageUrl() }}" class="page-link">Next</a>
                    </li>
                </ul>
            </div>
        @else
            <div class="history-alert-section">
                <div class="history-alert-card">
                    <div class="history-alert-icon-title">
                        <span class="history-alert-icon"><i class="fa fa-info-circle"></i></span>
                        <span class="history-alert-title">Want to see your history of speech creation?</span>
                    </div>
                    <div class="history-alert-desc">
                        You can see your history of speech creation after you sign in. It is free and easy to sign up.
                    </div>
                    <div class="history-alert-actions">
                        <a href="{{ route('signup') }}" style="text-decoration: none"><button class="history-alert-signup">Sign
                                up for free <i class="fa fa-arrow-right"></i></button></a>
                        <a href="{{ route('login') }}" style="text-decoration: none"><button class="history-alert-signin">Sign
                                In</button></a>
                    </div>
                </div>
            </div>
        @endauth


    </div>


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
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/docx/6.2.0/docx.min.js"></script>
@endsection
