<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn($request) => $request->user());
    Route::apiResource('notes', NoteController::class)->only(['index', 'store', 'update', 'destroy']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
