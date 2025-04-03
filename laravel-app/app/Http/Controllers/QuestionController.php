<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Uploaded_file;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function create(Request $req)
    {
        set_time_limit(300); // Set execution time to 5 minutes (300 seconds)

        // Kiểm tra nếu có file
        if ($req->hasFile('file_upload')) {
            // Lấy file từ request
            $file = $req->file('file_upload');
            $originalName = $file->getClientOriginalName();

            // Save the file locally in the 'uploads' directory (you can change the directory as needed)
            $uniqueName = time() . '_' . $originalName;
            $filePath = $file->storeAs('uploads', $uniqueName, 'public');
            // Insert the file data into the uploaded_files table
            $uploadedFile = Uploaded_file::create([
                'id_user' => Auth::user()->id, // Assuming you have user authentication
                'file_path' => $filePath,
                'original_name' => $originalName
            ]);

            // Call API to get questions
            $response = Http::timeout(300)->attach(
                'file',               // Tên input file trong API
                file_get_contents($file->getPathname()),  // Read the content of the file
                $file->getClientOriginalName() // Keep the original file name
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

            // Get questions from API response
            $questions = $response->json()['questions'];

            // Insert questions into the database
            foreach ($questions as $question) {
                Question::create([
                    'id_file' => $uploadedFile->id, // Set id_file from uploaded file's ID
                    'content' => $question['question'],
                    'option_1' => $question['options'][0],
                    'option_2' => $question['options'][1],
                    'option_3' => $question['options'][2],
                    'option_4' => $question['options'][3],
                    'answer' => $question['answer'],
                    'level' => $question['level']
                ]);
            }

            // After inserting, you can return the questions to the view if needed
            return view('history', compact('questions'));
        } else {
            dd("Chưa có file"); // If no file was uploaded
        }
    }
}
