<?php

namespace App\Http\Controllers;

use App\Models\Book; // Bookモデルを使用
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * 書籍一覧・検索画面
     */
    public function index(Request $request)
    {
        // 検索キーワードを取得
        $keyword = $request->input('keyword');

        // クエリビルダを使ってデータベースから検索
        $query = Book::with('author')->where('status', 2); // 公開中の本のみ

        // キーワードがある場合、タイトルまたは著者名で絞り込み
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhereHas('author', function ($q) use ($keyword) {
                      $q->where('name', 'like', "%{$keyword}%");
                  });
            });
        }

        // ページネーション付きで取得（1ページ10件）
        $books = $query->paginate(10);

        return view('book.index', compact('books', 'keyword'));
    }

    /**
     * 書籍詳細ページ（閲覧ページ）
     */
    public function read($id)
    {
        // IDに合致する本を取得（なければ404エラー）
        $book = Book::where('status', 2)->findOrFail($id);

        // ビューに本データを渡す
        // 'book.read' ビューを作成する必要があります
        return view('book.read', compact('book'));
    }

    // --- 以下、将来的に必要になるメソッド（現状は空でもOK） ---

    public function show(Book $book)
    {
        // 詳細画面が必要ならここに記述
    }
}
