<?php

use Illuminate\Support\Facades\Route;

//コントローラの読込
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookManageController;

//トップページ
Route::get('/', [HomeController::class, 'index'])->name('home');

//ログインしてないと見れないページ
Route::middleware(['auth'])->group(function (){
    //書籍関連
    Route::controller(BookController::class)->name('books.')->group(function () {
        Route::get('/books', 'index')->name('index'); //検索結果一覧
        Route::get('/books/{book}', 'show')->name('show'); //書籍詳細
        Route::get('/books/{book}/read', 'read')->name('read'); //本文閲覧
    });

    //著者関連
    Route::controller(AuthorController::class)->name('authors.')->group(function () {
        Route::get('/authors', 'index')->name('index');         // 著者一覧
        Route::get('/authors/{author}', 'show')->name('show');  // 著者別作品一覧
    });
});

//認証関連
Route::controller(AuthController::class)->group(function () {
    // ゲスト（未ログイン）ユーザーのみアクセス可能
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');     // ログイン画面
        Route::post('/login', 'login');                           // ログイン処理
        Route::get('/register', 'showRegisterForm')->name('register'); // 登録画面
        Route::post('/register', 'register');                     // 登録処理
    });

    // ログイン中のユーザーのみアクセス可能
    Route::post('/logout', 'logout')->middleware('auth')->name('logout');
});

//管理者専用エリア
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    
    // 管理画面トップ（ダッシュボード）
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // 書籍管理（CRUD一括設定）
    // index, create, store, edit, update, destroy を自動で設定
    // URL例: /admin/books/create など
    Route::resource('books', BookManageController::class)->names('books');
    
    });