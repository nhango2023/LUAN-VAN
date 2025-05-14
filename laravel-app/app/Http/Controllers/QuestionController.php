<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\CreateQuestionsJob;
use App\Models\Configweb;
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



    public function show($id_file = null)
    {
        if (Auth::check()) {
            $userId = Auth::user()->id;

            // Query chính
            $query = DB::table('questions as q')
                ->join('uploaded_files as ulf', 'q.id_file', '=', 'ulf.id')
                ->where('ulf.id_user', $userId);

            // Nếu có truyền $id_file thì thêm điều kiện lọc
            if (!is_null($id_file)) {
                $query->where('ulf.id', $id_file);
            }

            $questions = $query->select(
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

            // Group by file_id rồi tiếp tục group theo level
            $grouped = $questions->groupBy('file_id')->map(function ($groupByFile) {
                $filePath = $groupByFile->first()->file_path;
                $fileName = $groupByFile->first()->original_name;
                $created_at = $groupByFile->first()->created_at;

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

            $configWeb = ConfigWeb::where('isUse', 1)->first();

            return view('history', ['groupedQuestions' => $grouped, 'configWeb' => $configWeb]);
        } else {
            return view('history');
        }
    }
}
