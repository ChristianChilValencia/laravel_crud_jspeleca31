<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Public route to get or refresh token
Route::middleware('auth:sanctum')->get('/token', [AuthController::class, 'getToken']);

// Example protected route
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/dashboard', function () {
        return response()->json(['message' => 'Welcome!']);
    });
});