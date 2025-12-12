<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book; // Bookモデルを読み込み

class HomeController extends Controller
{
    /**
     * トップページ（メインページ）を表示するメソッド
     */
    public function index()
    {
        // ランキング用データの取得
        $rankingBooks = Book::with('author') // 著者情報も一緒に取得（N+1問題対策）
            ->where('status', 2)             // 「2:公開」のものだけを対象にする
            ->orderBy('view_count', 'desc')  // 閲覧数(view_count)の多い順（降順）
            ->take(5)                        // 上位5件を取得
            ->get();

        // viewへデータを渡す ('home.index' は resources/views/home/index.blade.php を指します)
        return view('home.index', compact('rankingBooks'));
    }
}
