<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::paginate(10); // Adjust the number of items per page as needed
        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'answer_key' => 'required',
        ]);

        Question::create([
            'title' => $request->title,
            'content' => $request->content,
            'answer_key' => $request->answer_key,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('soal.index')->with('success', 'Soal berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $question = Question::findOrFail($id);
        return view('questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $question = Question::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'answer_key' => 'required',
        ]);

        $question->update([
            'title' => $request->title,
            'content' => $request->content,
            'answer_key' => $request->answer_key,
            'updated_at' => auth()->id(),
        ]);

        return redirect()->route('soal.index')->with('success', 'Soal berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
