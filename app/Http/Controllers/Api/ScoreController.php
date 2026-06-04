<?php

namespace App\Http\Controllers\Api;

use App\Models\Quiz;
use App\Models\Attempt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ScoreController extends Controller
{
    /**
     * Get scores for a quiz.
     */
    public function byQuiz(Quiz $quiz)
    {
        if ($quiz->teacher_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $scores = $quiz->scores()
            ->with('attempt.student', 'question')
            ->latest()
            ->paginate(20);

        return response()->json($scores);
    }

    /**
     * Get scores for an attempt.
     */
    public function byAttempt(Attempt $attempt)
    {
        if ($attempt->student_id !== Auth::id() && !Auth::user()->isTeacher()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $scores = $attempt->scores()
            ->with('question')
            ->get();

        return response()->json($scores);
    }
}