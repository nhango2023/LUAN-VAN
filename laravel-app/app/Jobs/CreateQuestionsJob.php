<?php

namespace App\Jobs;

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

class CreateQuestionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $filePath, $originalName, $userId, $questionJson, $model;

    public function __construct($filePath, $originalName, $userId, $questionJson, $model)
    {
        $this->filePath = $filePath;
        $this->originalName = $originalName;
        $this->userId = $userId;
        $this->questionJson = $questionJson;
        $this->model = $model;
    }

    public function handle()
    {
        try {
            Log::debug("Model value: " . $this->model);
            $storagePath = storage_path("app/public/" . $this->filePath);
            $response = Http::timeout(600)
                ->withHeaders([
                    'API-Key' => env('API_KEY') // use env() or hardcode for testing
                ])
                ->attach(
                    'file',
                    file_get_contents($storagePath),
                    $this->originalName
                )->asMultipart()->post(env('API_URL') . 'question/create?model=' . $this->model, [
                    'Nquestion_json' => json_encode($this->questionJson)
                ]);


            $status = $response->status();
            $responseBody = $response->body(); // Get the raw response body
            Log::error("API Response: Status {$status}, Body: {$responseBody}");

            if ($status == 403) {
                event(new testingEvent('Sai API key (403)'));
                return;
            } elseif ($status == 422) {
                event(new testingEvent('Validation error: ' . $responseBody));
                Log::error("Validation error: {$responseBody}");
                return;
            }
            $questions = $response->json();

            $uploadedFile = Uploaded_file::create([
                'id_user' => $this->userId,
                'file_path' => $this->filePath,
                'original_name' => $this->originalName
            ]);

            foreach ($questions as $index => $question) {
                try {
                    Question::create([
                        'id_file' => $uploadedFile->id,
                        'content' => $question['question'],
                        'option_1' => $question['options'][0] ?? null,
                        'option_2' => $question['options'][1] ?? null,
                        'option_3' => $question['options'][2] ?? null,
                        'option_4' => $question['options'][3] ?? null,
                        'answer' => $question['answer'],
                        'level' => $question['level']
                    ]);
                } catch (\Exception $e) {
                    Log::error("Insert Q#{$index} error: " . $e->getMessage());
                }
            }
            Log::info("CreateQuestionsJob done for user {$this->userId}");
            event(new testingEvent('Tạo câu hỏi thành công'));
        } catch (\Exception $e) {
            Log::error("Job failed: " . $e->getMessage());
            event(new testingEvent($e->getMessage())); // ← Only the message is safe
        }
    }
}
