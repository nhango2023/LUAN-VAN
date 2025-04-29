<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Style\ListItem;

class ExportFileController extends Controller
{
    public function exportToWord($fileId)
    {
        // Initialize PHPWord
        $phpWord = new PhpWord();

        // Define paragraph style with precise spacing
        $phpWord->addParagraphStyle('customStyle', [
            'spaceBefore' => 0,
            'spaceAfter' => 0,
            'lineHeight' => 1.3
        ]);

        // Set section with explicit page size and margins
        $section = $phpWord->addSection([
            'pageSizeW' => 11906, // A4 width in twips (21 cm)
            'pageSizeH' => 16838, // A4 height in twips (29.7 cm)
            'orientation' => 'portrait',
            'marginLeft' => 1134,   // 2.0 cm (1 cm = 567 twips)
            'marginRight' => 851,   // 1.5 cm
            'marginTop' => 851,     // 1.5 cm
            'marginBottom' => 851   // 1.5 cm
        ]);

        // Define level labels
        $levelLabels = [
            'remember' => 'Cấp 1',
            'understand' => 'Cấp 2',
            'apply' => 'Cấp 3',
            'analyze' => 'Cấp 4',
            'evaluate' => 'Cấp 5',
            'create' => 'Cấp 6',
        ];

        // Fetch questions
        $questions = DB::table('questions as q')
            ->join('uploaded_files as ulf', 'q.id_file', '=', 'ulf.id')
            ->where('ulf.id', $fileId)
            ->select(
                'ulf.id as file_id',
                'ulf.original_name',
                'ulf.created_at',
                'q.content as question',
                'q.option_1',
                'q.option_2',
                'q.option_3',
                'q.option_4',
                'q.answer',
                'q.level'
            )
            ->get();

        // Check if questions exist
        if ($questions->isEmpty()) {
            $section->addText(
                "No questions found for this file.",
                ['name' => 'Times New Roman', 'size' => 13, 'bold' => true],
                'customStyle'
            );
        } else {
            // Group questions by file and level
            $groupedQuestions = [];
            foreach ($questions as $q) {
                $fileId = $q->file_id;
                $level = $q->level;

                if (!isset($groupedQuestions[$fileId])) {
                    $groupedQuestions[$fileId] = [
                        'original_name' => $q->original_name,
                        'created_at' => $q->created_at,
                        'levels' => []
                    ];
                }

                if (!isset($groupedQuestions[$fileId]['levels'][$level])) {
                    $groupedQuestions[$fileId]['levels'][$level] = [];
                }

                $groupedQuestions[$fileId]['levels'][$level][] = [
                    'question' => $q->question,
                    'options' => array_filter([$q->option_1, $q->option_2, $q->option_3, $q->option_4]),
                    'answer' => $q->answer
                ];
            }

            // Generate document content
            foreach ($groupedQuestions as $fileId => $fileGroup) {
                // File heading
                // $section->addText(
                //     "File: {$fileGroup['original_name']}",
                //     ['name' => 'Times New Roman', 'size' => 13, 'bold' => true],
                //     'customStyle'
                // );

                // Add spacing after file heading
                // $section->addText('', [], ['spaceAfter' => 240]);

                foreach ($fileGroup['levels'] as $level => $questions) {
                    // Category heading
                    $section->addText(
                        "{$levelLabels[$level]}: " . count($questions) . " câu hỏi",
                        ['name' => 'Times New Roman', 'size' => 13, 'bold' => true],
                        'customStyle'
                    );

                    // Add spacing after category heading
                    // $section->addText('', [], ['spaceAfter' => 240]);

                    foreach ($questions as $index => $q) {
                        // Question text
                        $section->addText(
                            "Câu " . ($index + 1) . ": {$q['question']}",
                            ['name' => 'Times New Roman', 'size' => 13, 'bold' => true],
                            'customStyle'
                        );

                        // Options with A, B, C, D labels and underline for correct answer
                        $optionLabels = ['A.', 'B.', 'C.', 'D.'];
                        $optionIndex = 0;
                        foreach ($q['options'] as $option) {
                            $isCorrect = ($option == $q['answer']);
                            $section->addText(
                                $optionLabels[$optionIndex] . ' ' . $option,
                                [
                                    'name' => 'Times New Roman',
                                    'size' => 13,
                                    'underline' => $isCorrect ? \PhpOffice\PhpWord\Style\Font::UNDERLINE_SINGLE : \PhpOffice\PhpWord\Style\Font::UNDERLINE_NONE
                                ],
                                'customStyle'
                            );
                            $optionIndex++;
                        }

                        // Add spacing after question block
                        // $section->addText('', [], ['spaceAfter' => 240]);
                    }
                }
            }
        }

        // Save and download
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = 'questions_' . $fileId . '.docx';
        $objWriter->save($fileName);
        return response()->download($fileName)->deleteFileAfterSend(true);
    }
}
