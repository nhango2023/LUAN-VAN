<?php

namespace App\Jobs;

use App\Events\QuestionEvent;
use App\Models\Uploaded_file;
use App\Models\Question;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Events\testingEvent;
use App\Models\MessageModel; // Add this if not already imported
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Auth as AttributesAuth;

class CreateQuestionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $filePath, $originalName, $userId, $questionJson, $model, $userCredit;

    public function __construct($filePath, $originalName, $userId, $questionJson, $model, $userCredit)
    {
        $this->filePath = $filePath;
        $this->originalName = $originalName;
        $this->userId = $userId;
        $this->questionJson = $questionJson;
        $this->model = $model;
        $this->userCredit = $userCredit;
    }

    public function handle()
    {
        try {
            $storagePath = storage_path("app/public/" . $this->filePath);

            $response = Http::timeout(1200)
                ->withHeaders([
                    'API-Key' => env('API_KEY')
                ])
                ->attach(
                    'file',
                    file_get_contents($storagePath),
                    $this->originalName
                )
                ->asMultipart()
                ->post(env('API_URL') . 'question/create?model=' . $this->model . '&token=' . $this->userCredit, [
                    'Nquestion_json' => json_encode($this->questionJson)
                ]);

            $status = $response->status();
            $responseData = $response->json();
            Log::error("API Response: Status {$status}, Body: " . json_encode($responseData));

            // Handle failed responses
            if (in_array($status, [402, 403])) {
                event(new QuestionEvent(['code' => $status, 'message' => $responseData['detail']], $this->userId));
                return;
            }

            $responseData = $response->json();

            $questions = $responseData['questions'] ?? [];
            $tokenLeft = $responseData['credit'] ?? $this->userCredit;
            $user = User::find($this->userId);
            if ($user) {
                $user->credit = 0;
                $user->save();
            }

            $uploadedFile = Uploaded_file::create([
                'id_user' => $this->userId,
                'file_path' => $this->filePath,
                'original_name' => $this->originalName
            ]);


            MessageModel::create([
                'id_file' => $uploadedFile->id,
                'seen' => 0,
            ]);

            foreach ($questions as $index => $question) {
                try {
                    Question::create([
                        'id_file'   => $uploadedFile->id,
                        'content'   => $question['question'] ?? '',
                        'option_1'  => $question['options'][0] ?? null,
                        'option_2'  => $question['options'][1] ?? null,
                        'option_3'  => $question['options'][2] ?? null,
                        'option_4'  => $question['options'][3] ?? null,
                        'answer'    => $question['answer'] ?? '',
                        'level'     => $question['level'] ?? '',
                        'page'      => $question['page'] ?? null,
                        'document'  => $question['citation'] ?? '',
                    ]);
                } catch (\Exception $e) {
                    Log::error("Insert Q#{$index} error: " . $e->getMessage());
                }
            }

            event(new QuestionEvent(['code' => 200, 'message' => 'Tạo câu hỏi thành công'], $this->userId));
        } catch (\Exception $e) {
            Log::error("Job failed: " . $e->getMessage());
            event(new QuestionEvent(['code' => 500, 'message' => 'Lỗi khi tạo câu hỏi'], $this->userId));
        }
    }
}
