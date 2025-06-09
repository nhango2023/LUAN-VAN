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
    public function new(Request $req)
    {
        if (Auth::user()->credit == 0) {
            return response()->json([
                'message' => 'Not enough token',
                'code' => 402
            ]);
        }
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
            CreateQuestionsJob::dispatch($filePath, $originalName, Auth::id(), $questionJson, $req->model, Auth::user()->credit);

            return response()->json([
                'message' => 'Đang tạo câu hỏi, vui lòng chờ...',
                'code' => 200
            ]);
        }
    }

    public function start(Request $req)
    {
        $taskId = $req->input('task_id');
        $user = Auth::User();
        $user->task_id = $taskId;
        $user->save();

        return response()->json(['message' => 'Task ID saved successfully']);
    }


    // public function show($id_file = null)
    // {
    //     $configWeb = ConfigWeb::where('isUse', 1)->first();
    //     if (Auth::check()) {
    //         $userId = Auth::user()->id;

    //         // Query chính
    //         $query = DB::table('questions as q')
    //             ->join('uploaded_files as ulf', 'q.id_file', '=', 'ulf.id')
    //             ->where('ulf.id_user', $userId);

    //         // Nếu có truyền $id_file thì thêm điều kiện lọc
    //         if (!is_null($id_file)) {
    //             $query->where('ulf.id', $id_file);
    //         }

    //         $questions = $query->select(
    //             'ulf.id as file_id',
    //             'ulf.file_path',
    //             'ulf.created_at',
    //             'ulf.original_name',
    //             'q.content as question',
    //             'q.option_1',
    //             'q.option_2',
    //             'q.option_3',
    //             'q.option_4',
    //             'q.answer',
    //             'q.level'
    //         )
    //             ->orderBy('ulf.created_at', 'desc')
    //             ->get();

    //         // Group by file_id rồi tiếp tục group theo level
    //         $grouped = $questions->groupBy('file_id')->map(function ($groupByFile) {
    //             $filePath = $groupByFile->first()->file_path;
    //             $fileName = $groupByFile->first()->original_name;
    //             $created_at = $groupByFile->first()->created_at;

    //             $levels = $groupByFile->groupBy('level')->map(function ($questionsByLevel) {
    //                 return $questionsByLevel->map(function ($q) {
    //                     return [
    //                         'question' => $q->question,
    //                         'options' => [
    //                             'A: ' . $q->option_1,
    //                             'B: ' . $q->option_2,
    //                             'C: ' . $q->option_3,
    //                             'D: ' . $q->option_4,
    //                         ],
    //                         'answer' => $q->answer,
    //                     ];
    //                 });
    //             });

    //             return [
    //                 'file_path' => $filePath,
    //                 'original_name' => $fileName,
    //                 'created_at' => $created_at,
    //                 'levels' => $levels,
    //             ];
    //         });



    //         return view('history', ['groupedQuestions' => $grouped, 'configWeb' => $configWeb]);
    //     } else {
    //         return view('history', ['configWeb' => $configWeb]);
    //     }
    // }
    public function show($id_file = null)
    {
        $configWeb = ConfigWeb::where('isUse', 1)->first();
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

            // Paginate the grouped questions
            $perPage = 5;
            $groupedQuestions = new \Illuminate\Pagination\LengthAwarePaginator(
                $grouped->forPage(request()->input('page', 1), $perPage),
                $grouped->count(),
                $perPage,
                request()->input('page', 1),
                ['path' => url()->current()]
            );

            return view('history', [
                'groupedQuestions' => $groupedQuestions,
                'configWeb' => $configWeb
            ]);
        } else {
            return view('history', ['configWeb' => $configWeb]);
        }
    }
}
