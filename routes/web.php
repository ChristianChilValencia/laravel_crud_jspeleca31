<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ReviewController;

Route::get('/', fn() => redirect('/books'));

Route::resources([
    'authors' => AuthorController::class,
    'books' => BookController::class,
    'genres' => GenreController::class,
    'reviews' => ReviewController::class,
]);

