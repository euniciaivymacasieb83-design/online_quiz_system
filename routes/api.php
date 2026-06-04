<?php

use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\OptionController;
use App\Http\Controllers\Api\AttemptController;
use App\Http\Controllers\Api\ScoreController;
use App\Http\Controllers\Api\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// API Routes - No Authentication Required (for public quizzes)
Route::prefix('v1')->group(function () {
    
    // Public Quiz Endpoints
    Route::get('/quizzes', [QuizController::class, 'index'])->name('api.quizzes.index');
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('api.quizzes.show');
    Route::get('/quizzes/{quiz}/questions', [QuestionController::class, 'indexByQuiz'])->name('api.questions.by-quiz');
    
    // Protected API Routes - Require Authentication
    Route::middleware('auth:sanctum')->group(function () {
        
        // Teacher: Quiz Management (REST)
        Route::middleware('role:teacher')->group(function () {
            Route::post('/quizzes', [QuizController::class, 'store'])->name('api.quizzes.store');
            Route::put('/quizzes/{quiz}', [QuizController::class, 'update'])->name('api.quizzes.update');
            Route::patch('/quizzes/{quiz}', [QuizController::class, 'update'])->name('api.quizzes.patch');
            Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('api.quizzes.destroy');
            
            // Question Management
            Route::post('/questions', [QuestionController::class, 'store'])->name('api.questions.store');
            Route::get('/questions/{question}', [QuestionController::class, 'show'])->name('api.questions.show');
            Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('api.questions.update');
            Route::patch('/questions/{question}', [QuestionController::class, 'update'])->name('api.questions.patch');
            Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('api.questions.destroy');
            
            // Option Management
            Route::post('/options', [OptionController::class, 'store'])->name('api.options.store');
            Route::put('/options/{option}', [OptionController::class, 'update'])->name('api.options.update');
            Route::delete('/options/{option}', [OptionController::class, 'destroy'])->name('api.options.destroy');
            
            // Results & Reports
            Route::get('/quizzes/{quiz}/results', [ReportController::class, 'quizResults'])->name('api.results.quiz');
            Route::get('/quizzes/{quiz}/analytics', [ReportController::class, 'analytics'])->name('api.analytics.quiz');
            Route::get('/reports/quiz/{quiz}/json', [ReportController::class, 'exportJSON'])->name('api.reports.json');
        });
        
        // Student: Take Quizzes
        Route::middleware('role:student')->group(function () {
            Route::get('/quizzes/available', [AttemptController::class, 'availableQuizzesAPI'])->name('api.quizzes.available');
            Route::post('/attempts', [AttemptController::class, 'storeAPI'])->name('api.attempts.store');
            Route::get('/attempts/{attempt}', [AttemptController::class, 'showAPI'])->name('api.attempts.show');
            Route::post('/attempts/{attempt}/answers', [AttemptController::class, 'submitAnswerAPI'])->name('api.attempts.submit-answer');
            Route::post('/attempts/{attempt}/complete', [AttemptController::class, 'completeAPI'])->name('api.attempts.complete');
            Route::get('/my-attempts', [AttemptController::class, 'myAttemptsAPI'])->name('api.attempts.my-attempts');
            Route::get('/my-scores', [ScoreController::class, 'myScoresAPI'])->name('api.scores.my-scores');
        });
        
        // Get current authenticated user data
        Route::get('/user', function () {
            return auth('sanctum')->user();
        });
    });
});

// API v2 (Future expansion)
Route::prefix('v2')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('quizzes', QuizController::class);
    Route::apiResource('questions', QuestionController::class);
    Route::apiResource('attempts', AttemptController::class);
    Route::apiResource('scores', ScoreController::class);
});