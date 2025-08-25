<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\EnsureAccessWindow;
use App\Http\Controllers\Student\HomeController as StudentHome;
use App\Http\Controllers\Student\QuizPlayController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;
use App\Http\Controllers\Admin\QuestionController as AdminQuestionController;
use App\Http\Controllers\Admin\ImportStudentsController;

Route::get('/', function () {
    return redirect()->route('student.home');
});

Route::middleware(['auth', EnsureAccessWindow::class])->group(function() {
    Route::get('/dashboard', fn () => redirect()->route('student.home'))->name('dashboard');
    Route::get('/home', [StudentHome::class, 'index'])->name('student.home');
    Route::get('/quiz/{quiz}', [QuizPlayController::class, 'show'])->name('quiz.show');
    Route::post('/quiz/{quiz}/start', [QuizPlayController::class, 'start'])->name('quiz.start');
    Route::post('/quiz/{quiz}/submit', [QuizPlayController::class, 'submit'])->name('quiz.submit');
    Route::get('/result/{attempt}', [QuizPlayController::class, 'result'])->name('quiz.result');
});

Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminHomeController::class, 'index'])->name('home');
    Route::get('/quizzes', [AdminQuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/create', [AdminQuizController::class, 'create'])->name('quizzes.create');
    Route::post('/quizzes', [AdminQuizController::class, 'store'])->name('quizzes.store');
    Route::get('/quizzes/{quiz}/edit', [AdminQuizController::class, 'edit'])->name('quizzes.edit');
    Route::post('/quizzes/{quiz}', [AdminQuizController::class, 'update'])->name('quizzes.update');
    Route::post('/quizzes/{quiz}/toggle', [AdminQuizController::class, 'togglePublish'])->name('quizzes.toggle');

    Route::get('/quizzes/{quiz}/questions', [AdminQuestionController::class, 'index'])->name('questions.index');
    Route::post('/quizzes/{quiz}/questions', [AdminQuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/{question}/edit', [AdminQuestionController::class, 'edit'])->name('questions.edit');
    Route::post('/questions/{question}', [AdminQuestionController::class, 'update'])->name('questions.update');
    Route::post('/questions/{question}/delete', [AdminQuestionController::class, 'destroy'])->name('questions.delete');

    Route::get('/import-students', [ImportStudentsController::class, 'show'])->name('import.show');
    Route::post('/import-students', [ImportStudentsController::class, 'import'])->name('import.do');
});

require __DIR__.'/auth.php';
