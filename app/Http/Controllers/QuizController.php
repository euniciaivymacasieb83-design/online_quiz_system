<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    /**
     * Display a listing of quizzes.
     */
    public function index(Request $request)
    {
        $query = Quiz::query();

        // Filter by search
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filter by status (for teachers)
        if (Auth::user()->isTeacher()) {
            $query->where('teacher_id', Auth::id());
            $quizzes = $query->latest()->paginate(10);
            return view('quizzes.index', compact('quizzes'));
        }

        // Show published quizzes only for students
        $query->where('is_published', true);
        $quizzes = $query->latest()->paginate(10);
        return view('quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new quiz.
     */
    public function create()
    {
        $this->authorize('create', Quiz::class);
        return view('quizzes.create');
    }

    /**
     * Store a newly created quiz in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Quiz::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1|max:480',
            'passing_score' => 'nullable|integer|min:0|max:100',
        ]);

        $validated['teacher_id'] = Auth::id();
        $validated['passing_score'] = $validated['passing_score'] ?? 50;
        $validated['is_published'] = false;

        $quiz = Quiz::create($validated);

        return redirect()
            ->route('quizzes.show', $quiz)
            ->with('success', 'Quiz created successfully.');
    }

    /**
     * Display the specified quiz.
     */
    public function show(Quiz $quiz)
    {
        // Check authorization
        if (Auth::user()->isTeacher() && $quiz->teacher_id !== Auth::id()) {
            abort(403);
        }

        $quiz->load('questions.options', 'attempts');
        return view('quizzes.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified quiz.
     */
    public function edit(Quiz $quiz)
    {
        $this->authorize('update', $quiz);
        return view('quizzes.edit', compact('quiz'));
    }

    /**
     * Update the specified quiz in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        $this->authorize('update', $quiz);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1|max:480',
            'passing_score' => 'nullable|integer|min:0|max:100',
            'is_published' => 'nullable|boolean',
        ]);

        $validated['passing_score'] = $validated['passing_score'] ?? 50;

        $quiz->update($validated);

        return redirect()
            ->route('quizzes.show', $quiz)
            ->with('success', 'Quiz updated successfully.');
    }

    /**
     * Remove the specified quiz from storage.
     */
    public function destroy(Quiz $quiz)
    {
        $this->authorize('delete', $quiz);

        $quiz->delete();

        return redirect()
            ->route('quizzes.index')
            ->with('success', 'Quiz deleted successfully.');
    }

    /**
     * Publish a quiz.
     */
    public function publish(Quiz $quiz)
    {
        $this->authorize('update', $quiz);

        if ($quiz->questions()->count() === 0) {
            return redirect()
                ->back()
                ->with('error', 'Add questions before publishing.');
        }

        $quiz->update(['is_published' => true]);

        return redirect()
            ->back()
            ->with('success', 'Quiz published successfully.');
    }

    /**
     * Unpublish a quiz.
     */
    public function unpublish(Quiz $quiz)
    {
        $this->authorize('update', $quiz);

        $quiz->update(['is_published' => false]);

        return redirect()
            ->back()
            ->with('success', 'Quiz unpublished successfully.');
    }
}