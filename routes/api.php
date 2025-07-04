// Logout route (API)
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;


// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'apiLogout']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/token', [AuthController::class, 'getToken']);
    Route::post('/books', [BookController::class, 'store']);
    Route::get('/dashboard', function () {
        return response()->json(['message' => 'Welcome!']);
    });
});

// ...existing code...