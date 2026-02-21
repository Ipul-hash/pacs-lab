<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PageController::class, 'index'])->name('dashboard');
Route::get('/worklist', [PageController::class, 'worklist'])->name('worklist');