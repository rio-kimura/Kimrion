<?php

use Illuminate\Support\Facades\Route;

// コントローラの読込
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookManageController;

// ----------------------------------------------------------------
// 一般公開エリア（ログインなしで見れるページ）
// ----------------------------------------------------------------

// トップページ（ランキング表示など）
Route::get('/', [HomeController::class, 'index'])->name('home');

// 認証関連（ログイン・登録など）
Route::controller(AuthController::class)->group(function () {
    // ゲスト（未ログイン）ユーザーのみアクセス可能
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');          // ログイン画面
        Route::post('/login', 'login');                                // ログイン処理
        Route::get('/register', 'showRegisterForm')->name('register'); // 登録フォーム
        Route::post('/register/confirm', 'confirmRegister')->name('register.confirm');
        Route::post('/register', 'register')->name('register.exec');   // 登録処理
    });

    // ログイン中のユーザーのみアクセス可能
    Route::post('/logout', 'logout')->middleware('auth')->name('logout');
});

// ----------------------------------------------------------------
// 会員専用エリア（ログイン必須）
// ----------------------------------------------------------------
Route::middleware(['auth'])->group(function (){

    // 書籍関連
    // HEAD側の /books/{id}/read もここに統合されます（{book}はモデル結合ルートです）
    Route::controller(BookController::class)->name('books.')->group(function () {
        Route::get('/books', 'index')->name('index');                // 検索結果一覧
        Route::get('/books/{book}', 'show')->name('show');           // 書籍詳細
        Route::get('/books/{book}/read', 'read')->name('read');      // 本文閲覧
    });

    // 著者関連
    Route::controller(AuthorController::class)->name('authors.')->group(function () {
        Route::get('/authors', 'index')->name('index');         // 著者一覧
        Route::get('/authors/{author}', 'show')->name('show');  // 著者別作品一覧
    });
});

// ----------------------------------------------------------------
// 管理者専用エリア
// ----------------------------------------------------------------
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // 管理画面トップ（ダッシュボード）
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // 書籍管理（CRUD一括設定）
    Route::resource('books', BookManageController::class)->names('books');

});
