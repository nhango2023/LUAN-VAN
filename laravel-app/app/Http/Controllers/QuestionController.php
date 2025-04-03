<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuestionController extends Controller
{
    //
    public function create(Request $req)
    {
        set_time_limit(300); // Set execution time to 5 minutes (300 seconds)
        // Kiểm tra nếu có file
        if ($req->hasFile('file_upload')) {
            // Lấy file từ request
            // Đặt thời gian thực thi là 5 phút
            $file = $req->file('file_upload');
            $filePath = $file->getPathname();

            // Gọi API bằng Laravel HTTP client
            $response = Http::timeout(300)->attach(
                'file',               // Tên input file trong API
                file_get_contents($filePath),  // Đọc nội dung của file
                $file->getClientOriginalName() // Đặt lại tên file gốc khi upload
            )->asMultipart()->post('http://localhost:8000/question/create', [
                'Nquestion_json' => json_encode([
                    'remember' => $req->n_remember,
                    'understand' => $req->n_understand,
                    'apply' => $req->n_apply,
                    'analyze' => $req->n_analyze,
                    'evaluate' => $req->n_evaluate,
                    'create' => $req->n_create
                ]),
            ]);

            $questions = $response->json()['questions'];
            $groupedQuestions = collect($questions)->groupBy('level');
            return view('history', compact('groupedQuestions'));
        } else {
            dd("Chưa có file"); // Nếu không có file được chọn
        }
    }
    public function show()
    {
        $questions = [
            [
                'question' => 'What is the capital of France?',
                'options' => ['Berlin', 'Madrid', 'Paris', 'Rome'],
                'answer' => 'Paris'
            ],
            [
                'question' => 'Which language is used for web development?',
                'options' => ['Python', 'JavaScript', 'Java', 'C++'],
                'answer' => 'JavaScript'
            ],
        ];
        return view('history', compact('questions'));
    }
}
