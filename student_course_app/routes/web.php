<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('students.index');
});

Auth::routes();

Route::middleware('auth')->group(function () {

    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::resource('students', StudentController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('lecturers', LecturerController::class);

    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
});
