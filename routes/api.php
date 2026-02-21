<?php

use App\Http\Controllers\Api\WorklistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Worklist API Routes
|--------------------------------------------------------------------------
| Base URL : http://127.0.0.1:8000/api
|
| GET    /api/order/health       → Health check
| GET    /api/order              → List semua order
| POST   /api/order              → Buat order baru
| DELETE /api/order/{acc}        → Hapus order
|
*/

Route::prefix('order')->controller(WorklistController::class)->group(function () {
    Route::get('/health', 'health');
    Route::get('/',       'index');
    Route::post('/',      'store');
    Route::delete('/{accessionNumber}', 'destroy');
});