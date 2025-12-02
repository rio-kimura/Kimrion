<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    // 検索画面（一覧画面）
    public function index(Request $request)
    {
        // 1. ダミーデータ（本来はデータベースから取るもの）
        // 五十音順（あ→ん）を意識して作成
        $books = [
            ['id' => 1, 'title' => '愛と幻想のファシズム', 'author' => '村上 龍'],
            ['id' => 2, 'title' => '伊豆の踊子', 'author' => '川端 康成'],
            ['id' => 3, 'title' => '海辺のカフカ', 'author' => '村上 春樹'],
            ['id' => 4, 'title' => '江戸川乱歩傑作選', 'author' => '江戸川 乱歩'],
            ['id' => 5, 'title' => 'おくのほそ道', 'author' => '松尾 芭蕉'],
            ['id' => 6, 'title' => '風の又三郎', 'author' => '宮沢 賢治'],
            ['id' => 7, 'title' => '銀河鉄道の夜', 'author' => '宮沢 賢治'],
            ['id' => 8, 'title' => '蜘蛛の糸', 'author' => '芥川 龍之介'],
            ['id' => 9, 'title' => 'こころ', 'author' => '夏目 漱石'],
            ['id' => 10, 'title' => '人間失格', 'author' => '太宰 治'],
        ];

        // 2. 検索機能（ダミーデータに対する簡易検索）
        $keyword = $request->input('keyword'); // 検索フォームからの入力値

        if (!empty($keyword)) {
            // タイトルか著者名にキーワードが含まれるものだけを残す
            $books = array_filter($books, function($book) use ($keyword) {
                return str_contains($book['title'], $keyword) || str_contains($book['author'], $keyword);
            });
        }

        return view('book.index', compact('books', 'keyword'));
    }

    // 閲覧ページ（仮）
    public function read($id)
    {
        // とりあえずIDだけ渡して表示
        return view('book.read', ['id' => $id]);
    }
}
