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
        // Fetch questions with user answers for the authenticated user
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
        // Not implemented
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Not implemented
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userAnswer = UserAnswer::with('question')
            ->where('question_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $pythonScriptPath = base_path('python/calculate_similarity.py');
        $answer = escapeshellarg($userAnswer->answer);
        $keyAnswer = escapeshellarg($userAnswer->question->answer_key);

        $command = "python $pythonScriptPath $answer $keyAnswer";
        $jsonResult = shell_exec($command);

        if (!$jsonResult) {
            return redirect()->route('ujian.index')->with('error', 'Gagal menghitung skor kesamaan. Silakan coba lagi.');
        }

        $result = json_decode($jsonResult, true);

        if (isset($result['error'])) {
            return redirect()->route('ujian.index')->with('error', $result['error']);
        }

        $processedAnswer = $result['processedAnswer'];
        $processedKeyAnswer = $result['processedKeyAnswer'];
        $tfidfValues = $result['tfidf_values'];
        $score = $result['score'];
        $cosineSimilarity = $result['cosineSimilarity'];
        $threshold = $result['threshold'];
        $isAboveThreshold = $result['isAboveThreshold'];

        $data = [
            'answer' => $userAnswer->answer,
            'tokensAnswer' => $processedAnswer['tokens'], // Tokenized answer
            'stemmedAnswer' => $processedAnswer['stemmed'], // Stemmed answer

            'keyAnswer' => $userAnswer->question->answer_key,
            'tokensKeyAnswer' => $processedKeyAnswer['tokens'], // Tokenized key answer
            'stemmedKeyAnswer' => $processedKeyAnswer['stemmed'], // Stemmed key answer

            'score' => $score,
            'cosineSimilarity' => $cosineSimilarity,
            'isAboveThreshold' => $isAboveThreshold,
            'threshold' => $threshold,
            'tfidfValues' => $tfidfValues,  // TF-IDF values
            'question' => $userAnswer->question->content, // Display the question
        ];

        return view('ujian.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Not implemented
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Not implemented
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Not implemented
    }

    /**
     * Display the form to answer a specific question.
     */
    public function kerjakan($questionId)
    {
        // Fetch the question by ID
        $question = Question::findOrFail($questionId);

        return view('ujian.kerjakan', compact('question'));
    }

    /**
     * Submit the user's answer for a specific question.
     */
    public function submit(Request $request, $questionId)
    {
        // Validate the request
        $validated = $request->validate([
            'answer' => 'required|string',
        ]);

        // Path to the Python script
        $pythonScriptPath = base_path('python/calculate_similarity.py');
        $answer = escapeshellarg($validated['answer']);
        $keyAnswer = escapeshellarg(Question::find($questionId)->answer_key);

        // Execute the Python script and get the result
        $command = "python $pythonScriptPath $answer $keyAnswer";
        $jsonResult = shell_exec($command);

        // Handle error if the result is empty
        if (!$jsonResult) {
            return redirect()->route('ujian.index')->with('error', 'Gagal menghitung skor kesamaan. Silakan coba lagi.');
        }

        // Convert JSON result to PHP array
        $result = json_decode($jsonResult, true);

        // Check for errors in the Python script (e.g., insufficient arguments)
        if (isset($result['error'])) {
            return redirect()->route('ujian.index')->with('error', $result['error']);
        }

        // Extract the similarity score from the result
        $similarityScore = $result['score'];

        // Save the user's answer and score to the database
        $userAnswer = UserAnswer::updateOrCreate(
            ['question_id' => $questionId, 'user_id' => Auth::id()],
            [
                'answer' => $validated['answer'],
                'score' => (int) $similarityScore, // Ensure the score is saved as an integer
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return redirect()->route('ujian.index')->with('success', 'Jawaban berhasil disubmit dengan skor: ' . $similarityScore);
    }
}
