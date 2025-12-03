<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        // 書籍データを取得（著者情報付き、作成日時の新しい順）
        $books = Book::with('author')->orderBy('created_at', 'desc')->get();
        return view('books.index', compact('books'));
    }
}
