<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Show the form for creating a new question.
     */
    public function create(Quiz $quiz)
    {
        $this->authorize('update', $quiz);
        return view('questions.create', compact('quiz'));
    }

    /**
     * Store a newly created question in storage.
     */
    public function store(Request $request, Quiz $quiz)
    {
        $this->authorize('update', $quiz);

        $validated = $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|in:multiple_choice,true_false,short_answer',
            'points' => 'required|integer|min:1|max:100',
        ]);

        $validated['quiz_id'] = $quiz->id;
        $validated['order'] = $quiz->questions()->max('order') + 1;

        Question::create($validated);

        return redirect()
            ->route('quizzes.show', $quiz)
            ->with('success', 'Question added successfully.');
    }

    /**
     * Show the form for editing the specified question.
     */
    public function edit(Question $question)
    {
        $this->authorize('update', $question->quiz);
        $question->load('options');
        $quiz = $question->quiz;
        return view('questions.edit', compact('question', 'quiz'));
    }

    /**
     * Update the specified question in storage.
     */
    public function update(Request $request, Question $question)
    {
        $this->authorize('update', $question->quiz);

        $validated = $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|in:multiple_choice,true_false,short_answer',
            'points' => 'required|integer|min:1|max:100',
        ]);

        $question->update($validated);

        return redirect()
            ->route('quizzes.show', $question->quiz)
            ->with('success', 'Question updated successfully.');
    }

    /**
     * Remove the specified question from storage.
     */
    public function destroy(Question $question)
    {
        $this->authorize('update', $question->quiz);

        $quiz = $question->quiz;
        $question->delete();

        return redirect()
            ->route('quizzes.show', $quiz)
            ->with('success', 'Question deleted successfully.');
    }
}