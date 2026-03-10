<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ConditionController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\LikelihoodController;

Route::get('/', [AssessmentController::class, 'start']);

Route::get('/s/{session}', [AssessmentController::class, 'show'])->name('session.show');
Route::post('/s/{session}/answer', [AssessmentController::class, 'answer'])->name('session.answer');
Route::post('/s/{session}/back', [AssessmentController::class, 'back'])->name('session.back');
Route::get('/s/{session}/result', [AssessmentController::class, 'result'])->name('session.result');
Route::post('/restart', [AssessmentController::class, 'restart'])->name('session.restart');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::view('/', 'admin.dashboard')->name('admin.dashboard');

    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('conditions', ConditionController::class)->except(['show']);
    Route::resource('questions', QuestionController::class)->except(['show']);

    Route::get('likelihoods', [LikelihoodController::class, 'index'])->name('admin.likelihoods.index');
    Route::post('likelihoods/save', [LikelihoodController::class, 'save'])->name('admin.likelihoods.save');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';