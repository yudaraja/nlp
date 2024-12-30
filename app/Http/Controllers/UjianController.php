<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Sastrawi\Stemmer\StemmerFactory;

class UjianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::with([
            'userAnswers' => function ($query) {
                $query->where('user_id', auth()->id());
            }
        ])->paginate(10);
        return view('ujian.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Temukan jawaban berdasarkan ID dan user_id
        $userAnswer = UserAnswer::with('question')
            ->where('question_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Path ke skrip Python
        $pythonScriptPath = base_path('python/calculate_similarity.py');
        $answer = escapeshellarg($userAnswer->answer);
        $keyAnswer = escapeshellarg($userAnswer->question->answer_key);

        // Menjalankan skrip Python dan mengambil hasilnya
        $command = "python $pythonScriptPath $answer $keyAnswer";
        $jsonResult = shell_exec($command);  // Mengambil hasil output JSON

        // Menangani error jika hasilnya kosong
        if (!$jsonResult) {
            return redirect()->route('ujian.index')->with('error', 'Gagal menghitung skor kesamaan. Silakan coba lagi.');
        }

        // Mengonversi JSON ke array PHP
        $result = json_decode($jsonResult, true);

        // Cek apakah terjadi error pada Python (misal: argumen tidak cukup)
        if (isset($result['error'])) {
            return redirect()->route('ujian.index')->with('error', $result['error']);
        }

        // Ambil nilai-nilai yang ingin ditampilkan
        $processedAnswer = $result['processedAnswer'];
        $processedKeyAnswer = $result['processedKeyAnswer'];
        $tfidfValues = $result['tfidf_values'];
        $score = $result['score'];
        $cosineSimilarity = $result['cosineSimilarity'];
        $threshold = $result['threshold'];
        $isAboveThreshold = $result['isAboveThreshold'];

        // Data untuk ditampilkan
        $data = [
            'answer' => $userAnswer->answer,
            'tokensAnswer' => $processedAnswer['tokens'], // Tokenisasi jawaban
            'stemmedAnswer' => $processedAnswer['stemmed'], // Hasil stemming jawaban

            'keyAnswer' => $userAnswer->question->answer_key,
            'tokensKeyAnswer' => $processedKeyAnswer['tokens'], // Tokenisasi jawaban kunci
            'stemmedKeyAnswer' => $processedKeyAnswer['stemmed'], // Hasil stemming jawaban kunci

            'score' => $score,
            'cosineSimilarity' => $cosineSimilarity,
            'isAboveThreshold' => $isAboveThreshold,
            'threshold' => $threshold,
            'tfidfValues' => $tfidfValues,  // Nilai TF-IDF
            'question' => $userAnswer->question->content, // Menampilkan soal atau pertanyaan
        ];

        return view('ujian.show', compact('data'));
    }





    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function kerjakan($questionId)
    {
        // Ambil soal berdasarkan ID
        $question = Question::findOrFail($questionId);

        return view('ujian.kerjakan', compact('question'));
    }

    public function submit(Request $request, $questionId)
    {
        $validated = $request->validate([
            'answer' => 'required|string',
        ]);

        // Path ke skrip Python
        $pythonScriptPath = base_path('python/calculate_similarity.py');
        $answer = escapeshellarg($validated['answer']);
        $keyAnswer = escapeshellarg(Question::find($questionId)->answer_key);

        // Menjalankan skrip Python dan mengambil hasilnya
        $command = "python $pythonScriptPath $answer $keyAnswer";
        $jsonResult = shell_exec($command);  // Mengambil hasil output JSON

        // Menangani error jika hasilnya kosong
        if (!$jsonResult) {
            return redirect()->route('ujian.index')->with('error', 'Gagal menghitung skor kesamaan. Silakan coba lagi.');
        }

        // Mengonversi JSON ke array PHP
        $result = json_decode($jsonResult, true);

        // Cek apakah terjadi error pada Python (misal: argumen tidak cukup)
        if (isset($result['error'])) {
            return redirect()->route('ujian.index')->with('error', $result['error']);
        }

        // Ambil score dari hasil JSON
        $similarityScore = $result['score'];

        // Simpan jawaban dan skor ke database
        $userAnswer = UserAnswer::updateOrCreate(
            ['question_id' => $questionId, 'user_id' => Auth::id()],
            [
                'answer' => $validated['answer'],
                'score' => (int) $similarityScore, // Pastikan skor disimpan sebagai integer
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return redirect()->route('ujian.index')->with('success', 'Jawaban berhasil disubmit dengan skor: ' . $similarityScore);
    }




}
