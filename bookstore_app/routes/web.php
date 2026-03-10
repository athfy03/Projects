<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::resource('books', BookController::class)->except(['show']);
    Route::resource('authors', AuthorController::class)->except(['show']);
    Route::resource('categories', CategoryController::class)->except(['show']);

    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
});

require __DIR__.'/auth.php';
