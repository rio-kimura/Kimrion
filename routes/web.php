<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\BookController;
Route::get('/books', [BookController::class, 'index'])->name('books.index');
