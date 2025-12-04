<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; // ★忘れずに追記
use App\Http\Controllers\BookController;

// トップページにアクセスしたら、HomeControllerのindexメソッドを呼ぶ
Route::get('/', [HomeController::class, 'index'])->name('home');

// 書籍検索ページ
Route::get('/books', [BookController::class, 'index'])->name('book.index');

// 書籍閲覧ページ（仮）
Route::get('/books/{id}/read', [BookController::class, 'read'])->name('book.read');
