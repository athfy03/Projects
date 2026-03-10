<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\ChildController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('guardians', GuardianController::class);
Route::resource('children', ChildController::class);

