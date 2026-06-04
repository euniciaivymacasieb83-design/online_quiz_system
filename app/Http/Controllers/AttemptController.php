<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Attempt;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttemptController extends Controller
{
    /**
     * Start a quiz attempt.
     */
    public function start(Quiz $quiz)
    {
        // Check if quiz is published
        if (!$quiz->is_published) {
            return redirect()->back()->with('error', 'Quiz is not published.');
        }

        // Check if student already has an incomplete attempt
        $existingAttempt = $quiz->attempts()
            ->where('student_id', Auth::id())
            ->whereNull('completed_at')
            ->first();

        if ($existingAttempt) {
            return redirect()->route('attempts.show', $existingAttempt);
        }

        // Create new attempt
        $attempt = Attempt::create([
            'student_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'started_at' => now(),
            'status' => 'in_progress',
        ]);

        return redirect()->route('attempts.show', $attempt);
    }

    /**
     * Display the quiz attempt form.
     */
    public function show(Attempt $attempt)
    {
        // Check authorization
        if ($attempt->student_id !== Auth::id() && !Auth::user()->isTeacher()) {
            abort(403);
        }

        // Check if time is up
        $duration = $attempt->quiz->duration;
        $elapsedMinutes = now()->diffInMinutes($attempt->started_at);

        if ($elapsedMinutes > $duration && is_null($attempt->completed_at)) {
            $attempt->update(['completed_at' => now(), 'status' => 'completed']);
            return redirect()->route('attempts.result', $attempt)
                ->with('info', 'Time is up! Your quiz has been submitted.');
        }

        $attempt->load('quiz.questions.options', 'scores');
        $timeRemaining = max(0, $duration - $elapsedMinutes);

        return view('attempts.show', compact('attempt', 'timeRemaining'));
    }

    /**
     * Submit quiz answers.
     */
    public function submit(Request $request, Attempt $attempt)
    {
        // Check authorization
        if ($attempt->student_id !== Auth::id()) {
            abort(403);
        }

        // Check if already submitted
        if ($attempt->completed_at) {
            return redirect()->back()->with('error', 'Quiz already submitted.');
        }

        $answers = $request->input('answers', []);

        // Save each answer as a score
        foreach ($answers as $questionId => $answer) {
            $question = $attempt->quiz->questions()->find($questionId);

            if ($question) {
                $isCorrect = $question->isAnswerCorrect($answer);
                $points = $isCorrect ? $question->points : 0;

                Score::create([
                    'attempt_id' => $attempt->id,
                    'question_id' => $questionId,
                    'student_answer' => $answer,
                    'is_correct' => $isCorrect,
                    'points' => $points,
                ]);
            }
        }

        // Mark attempt as completed
        $attempt->update([
            'completed_at' => now(),
            'status' => 'completed',
        ]);

        $attempt->calculateTotalScore();

        return redirect()->route('attempts.result', $attempt)
            ->with('success', 'Quiz submitted successfully.');
    }

    /**
     * Display attempt result.
     */
    public function result(Attempt $attempt)
    {
        // Check authorization
        if ($attempt->student_id !== Auth::id() && !Auth::user()->isTeacher()) {
            abort(403);
        }

        $attempt->load('scores.question', 'quiz');

        return view('attempts.result', compact('attempt'));
    }

    /**
     * Display all attempts for a quiz.
     */
    public function listByQuiz(Quiz $quiz)
    {
        $this->authorize('update', $quiz);

        $attempts = $quiz->attempts()
            ->with('student')
            ->latest()
            ->paginate(20);

        return view('attempts.index', compact('quiz', 'attempts'));
    }

    /**
     * Display student's all attempts.
     */
    public function listByStudent()
    {
        $attempts = Auth::user()->attempts()
            ->with('quiz')
            ->latest()
            ->paginate(20);

        return view('attempts.student-attempts', compact('attempts'));
    }
}