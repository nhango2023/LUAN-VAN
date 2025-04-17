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

class CreateQuestionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $filePath, $originalName, $userId, $questionJson;

    public function __construct($filePath, $originalName, $userId, $questionJson)
    {
        $this->filePath = $filePath;
        $this->originalName = $originalName;
        $this->userId = $userId;
        $this->questionJson = $questionJson;
    }

    public function handle()
    {
        try {


            $response = Http::timeout(600)->attach(
                'file',
                file_get_contents($storagePath),
                $this->originalName
            )->asMultipart()->post('http://localhost:8000/question/create', [
                'Nquestion_json' => json_encode($this->questionJson)
            ]);

            $questions = $response->json()['questions'];

            $storagePath = storage_path("app/public/" . $this->filePath);
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
        } catch (\Exception $e) {
            Log::error("Job failed: " . $e->getMessage());
        }
    }
}
