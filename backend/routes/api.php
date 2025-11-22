<?php

// API Controllers
use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

Route::get('/test', function () {
    return response()->json(
        ['message' => 'API動作確認OK'],
        Response::HTTP_OK,
        [],
        JSON_UNESCAPED_UNICODE
    );
});

Route::post('/Auth/register', [AuthController::class, 'register']);
Route::post('/Auth/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
