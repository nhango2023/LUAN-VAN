<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\CreateQuestionsJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Uploaded_file;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    public function create(Request $req)
    {
        if ($req->hasFile('file_upload')) {
            $file = $req->file('file_upload');
            $originalName = $file->getClientOriginalName();
            $uniqueName = time() . '_' . $originalName;
            $filePath = $file->storeAs('uploads', $uniqueName, 'public');

            $questionJson = [
                'remember' => $req->n_remember,
                'understand' => $req->n_understand,
                'apply' => $req->n_apply,
                'analyze' => $req->n_analyze,
                'evaluate' => $req->n_evaluate,
                'create' => $req->n_create,
            ];
            CreateQuestionsJob::dispatch($filePath, $originalName, Auth::id(), $questionJson, $req->model);

            return response()->json([
                'message' => 'Đang tạo câu hỏi, vui lòng chờ...',
                'code' => 202
            ]);
        }
    }



    public function show()
    {
        if (Auth::check()) {
            $userId = Auth::user()->id;
            // Query to join uploaded_files and questions, then group by level
            $questions = DB::table('questions as q')
                ->join('uploaded_files as ulf', 'q.id_file', '=', 'ulf.id')
                ->where('ulf.id_user', $userId)
                ->select(
                    'ulf.id as file_id',
                    'ulf.file_path',
                    'ulf.created_at',
                    'ulf.original_name',
                    'q.content as question',
                    'q.option_1',
                    'q.option_2',
                    'q.option_3',
                    'q.option_4',
                    'q.answer',
                    'q.level'
                )
                ->orderBy('ulf.created_at', 'desc')
                ->get();
            // Group by file_id then by level
            $grouped = $questions->groupBy('file_id')->map(function ($groupByFile) {
                $filePath = $groupByFile->first()->file_path;
                $fileName = $groupByFile->first()->original_name;
                $created_at = $groupByFile->first()->created_at;

                // Group again by level inside each file
                $levels = $groupByFile->groupBy('level')->map(function ($questionsByLevel) {
                    return $questionsByLevel->map(function ($q) {
                        return [
                            'question' => $q->question,
                            'options' => [
                                'A: ' . $q->option_1,
                                'B: ' . $q->option_2,
                                'C: ' . $q->option_3,
                                'D: ' . $q->option_4,
                            ],
                            'answer' => $q->answer,
                        ];
                    });
                });

                return [
                    'file_path' => $filePath,
                    'original_name' => $fileName,
                    'created_at' => $created_at,
                    'levels' => $levels,
                ];
            });
            return view('history', ['groupedQuestions' => $grouped]);
        } else {
            return view('history');
        }
    }
}
