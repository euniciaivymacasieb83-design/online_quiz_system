<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\AttemptController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes (from Laravel Breeze)
Route::middleware('guest')->group(function () {
    Route::get('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);
    Route::get('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
    Route::get('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [\App\Http\Controllers\Auth\NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\Auth\NewPasswordController::class, 'store'])->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/verify-email', [\App\Http\Controllers\Auth\EmailNotificationController::class, 'create'])->name('verification.notice');
    Route::get('/verify-email/{id}/{hash}', [\App\Http\Controllers\Auth\VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('/email/verification-notification', [\App\Http\Controllers\Auth\EmailNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');
    Route::get('/confirm-password', [\App\Http\Controllers\Auth\ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('/confirm-password', [\App\Http\Controllers\Auth\ConfirmablePasswordController::class, 'store']);
    Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Protected Routes - Authenticated Users Only
Route::middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Student Routes - Take Quizzes
    Route::middleware('role:student')->group(function () {
        Route::get('/quizzes/available', [AttemptController::class, 'availableQuizzes'])->name('quizzes.available');
        Route::get('/quizzes/{quiz}/take', [AttemptController::class, 'start'])->name('attempts.start');
        Route::post('/attempts/{attempt}/submit', [AttemptController::class, 'submitAnswer'])->name('attempts.submit-answer');
        Route::post('/attempts/{attempt}/complete', [AttemptController::class, 'complete'])->name('attempts.complete');
        Route::get('/attempts/{attempt}', [AttemptController::class, 'show'])->name('attempts.show');
        Route::get('/my-scores', [AttemptController::class, 'myScores'])->name('scores.my-scores');
    });
    
    // Teacher Routes - Create and Manage Quizzes
    Route::middleware('role:teacher')->group(function () {
        
        // Quiz Management
        Route::resource('quizzes', QuizController::class)->names([
            'index' => 'quizzes.index',
            'create' => 'quizzes.create',
            'store' => 'quizzes.store',
            'show' => 'quizzes.show',
            'edit' => 'quizzes.edit',
            'update' => 'quizzes.update',
            'destroy' => 'quizzes.destroy',
        ]);
        
        // Question Management
        Route::prefix('quizzes/{quiz}/questions')->group(function () {
            Route::get('/', [QuestionController::class, 'index'])->name('questions.index');
            Route::get('/create', [QuestionController::class, 'create'])->name('questions.create');
            Route::post('/', [QuestionController::class, 'store'])->name('questions.store');
            Route::get('{question}', [QuestionController::class, 'show'])->name('questions.show');
            Route::get('{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
            Route::put('{question}', [QuestionController::class, 'update'])->name('questions.update');
            Route::delete('{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
        });
        
        // Option Management (nested under questions)
        Route::prefix('questions/{question}/options')->group(function () {
            Route::post('/', [OptionController::class, 'store'])->name('options.store');
            Route::put('{option}', [OptionController::class, 'update'])->name('options.update');
            Route::delete('{option}', [OptionController::class, 'destroy'])->name('options.destroy');
        });
        
        // Results and Analytics
        Route::get('/quizzes/{quiz}/results', [ReportController::class, 'quizResults'])->name('quizzes.results');
        Route::get('/quizzes/{quiz}/analytics', [ReportController::class, 'analytics'])->name('quizzes.analytics');
        
        // Export Routes
        Route::get('/reports/quiz/{quiz}/export-pdf', [ReportController::class, 'exportQuizResultsPDF'])->name('reports.quiz-pdf');
        Route::get('/reports/quiz/{quiz}/export-excel', [ReportController::class, 'exportQuizResultsExcel'])->name('reports.quiz-excel');
        Route::get('/reports/quiz/{quiz}/export-csv', [ReportController::class, 'exportQuizResultsCSV'])->name('reports.quiz-csv');
        
        // Import Routes
        Route::get('/quizzes/import', [QuizController::class, 'importForm'])->name('quizzes.import-form');
        Route::post('/quizzes/import', [QuizController::class, 'import'])->name('quizzes.import');
    });
    
});

// Admin Routes (if you want an admin role)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/users', [DashboardController::class, 'manageUsers'])->name('admin.users');
    Route::get('/reports', [ReportController::class, 'allReports'])->name('admin.reports');
    Route::get('/reports/export-all-pdf', [ReportController::class, 'exportAllResultsPDF'])->name('reports.all-pdf');
});

require __DIR__.'/auth.php';