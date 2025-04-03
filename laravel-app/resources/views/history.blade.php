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
        .questionnaire {
            
        }

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

    <!-- History Card -->
    <div class="history-card">
        <div class="header">
            <div class="voice-info">           
                <div class="tags">
                    <span class="id" style="background-color: #848fc6;color: black">8 Remember</span>
                    <span class="id" style="background-color: #89c0e6;color: black">8 Understand</span>
                    <span class="id" style="background-color: #75ac82;color: black">8 Apply</span>
                    <span class="id" style="background-color: #aed981;color: black">8 Analyze</span>
                    <span class="id" style="background-color: #f3da69;color: black">8 Evaculate</span>
                    <span class="id" style="background-color: #e78b76;color: black">8 Create</span>
                </div>
            </div>
            <div class="timestamp">37 minutes ago</div>
        </div>
        <div class="text">

            <div class="questionnaire">
                @php
                $levels = [
                    'remember' => 'Remembering',
                    'understand' => 'Understanding',
                    'apply' => 'Applying',
                    'analyze' => 'Analyzing',
                    'evaluate' => 'Evaluating',
                    'create' => 'Creating',
                ];
            
                $colors = [
                    'remember' => '#848fc6',
                    'understand' => '#89c0e6',
                    'apply' => '#75ac82',
                    'analyze' => '#aed981',
                    'evaluate' => '#f3da69',
                    'create' => '#e78b76',
                ];
            @endphp
            
            @foreach($levels as $levelKey => $levelName)
                @if(isset($groupedQuestions[$levelKey]))
                    <div class="category" id="{{ $levelKey }}">
                        <button class="category-btn" style="background-color: {{ $colors[$levelKey] }}; color: black">
                            {{ $levelName }} - {{ count($groupedQuestions[$levelKey]) }} câu hỏi
                        </button>
                        <div class="questions-container">
                            @foreach($groupedQuestions[$levelKey] as $index => $question)
                                <div class="question">
                                    <p class="question-text"><strong>Câu {{ $index + 1 }}:</strong> {{ $question['question'] }}</p>
                                    <ul class="options">
                                        @foreach($question['options'] as $option)
                                            <li>{{ $option }}</li>
                                        @endforeach
                                    </ul>
                                    <p class="correct-answer">✅ <strong>Đáp án đúng:</strong> {{ $question['answer'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
            
            
            </div>
        
        <div class="footer">
            <div class="details">
                <i class="fa fa-info-circle"></i> Details for each block
            </div>
            <div class="actions">
                <span># 45c5a664-0f75-11f0-bf80-9645d7b8ec08</span>
                <button><i class="fa fa-thumbs-up"></i></button>
                <button><i class="fa fa-thumbs-down"></i></button>
            </div>
        </div>
        <div class="actions mt-1">
            Download
        </div>
        <div class="d-flex justify-content-left">
            <button type="button" class="btn btn-primary">Download exel file</button>
            <button type="button" class="btn btn-primary mx-3">Download word file</button>
            <button type="button" class="btn btn-primary">Download txt file</button>
        </div>
    </div>

    <script >
        document.querySelectorAll('.category-btn').forEach(button => {
        button.addEventListener('click', function() {
            const questionsContainer = this.nextElementSibling;
            questionsContainer.style.display = 
                questionsContainer.style.display === 'block' ? 'none' : 'block';
        });
    });
    
    </script>

  
@endsection