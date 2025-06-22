<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\CreateQuestionsJob;
use App\Models\Configweb;
use App\Models\MessageModel;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Uploaded_file;
use App\Models\Question;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    public function new(Request $req)
    {
        $task_id = $req->input('task_id');
        $task = Task::where('id', $task_id)->first();

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        $task->status = 'done';
        $task->save();
        $idFile = $task->id_file;

        MessageModel::create([
            'id_file' => $idFile,       // hoặc giá trị thực tế
            'seen'    => 0,         // hoặc 1 nếu đã xem
        ]);
        $questions = $req->input('results');
        $questionsLength = count($questions);
        foreach ($questions as $q) {
            Question::create([
                'id_file'   => $idFile,
                'content'   => $q['question'],
                'option_1'  => $q['options'][0],
                'option_2'  => $q['options'][1],
                'option_3'  => $q['options'][2],
                'option_4'  => $q['options'][3],
                'answer'    => $q['answer'],
                'level'     => $q['level'],
                'page'      => $q['page'],
                'document'  => $q['citation']
            ]);
        }
        $user = Auth::User();
        $user->available_question = $user->available_question - $questionsLength;
        $user->save();
        return response()->json(['message' => 'Luu cau hoi thanh cong']);
    }

    public function start(Request $req)
    {
        $user = Auth::User();
        $file = $req->file('file');
        $taskId = $req->input('task_id');
        // Log::debug('task_id' . $taskId);
        $status = $req->input('status');
        $total_question = $req->input('total_question');
        //$filePath = $file->store('uploads', 'public');  // Store file in 'public/uploads'
        $filePath = "";
        // Save the file data into the database

        $uploadedFile = new Uploaded_file();
        $uploadedFile->id_user = $user->id;  // Assuming you're saving the file for the authenticated user
        $uploadedFile->file_path = $filePath;
        $uploadedFile->original_name = $file->getClientOriginalName();
        $uploadedFile->created_at = now(); // Optional: This is automatically handled by Eloquent
        $uploadedFile->save();

        $fileId = $uploadedFile->id;

        $task = new Task();
        $task->id = $taskId;
        $task->id_user = $user->id;
        $task->id_file = $fileId;
        $task->status = $status;
        $task->total_question = $total_question;
        $task->save();

        // $user->task_id = $taskId;
        // $user->save();

        return response()->json(['id_file' => $fileId, "message" => "Luu task thanh cong"]);
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
        $currentPlan = "";
        $user = Auth::user();
        $configWeb = ConfigWeb::where('isUse', 1)->first();
        if (Auth::check()) {
            $currentPlan = Plan::find($user->id_plan);
            $tasks = Task::join('uploaded_files', 'uploaded_files.id', '=', 'tasks.id_file')
                ->where('tasks.id_user', $user->id)
                ->where('tasks.status', 'processing')
                ->select('tasks.*', 'uploaded_files.original_name')
                ->get();
            // Query chính
            $userId = $user->id;
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
                'configWeb' => $configWeb,
                'tasks' => $tasks,
                'currentPlan' => $currentPlan
            ]);
        } else {
            $tasks = [];
            return view('history', ['configWeb' => $configWeb, 'tasks' => $tasks, '$currentPlan' => $currentPlan]);
        }
    }
}
