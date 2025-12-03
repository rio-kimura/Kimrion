#!/bin/bash
set -e

echo "🎨 書籍管理システム 画面(UI)構築を開始します..."

# 1. コントローラの作成
echo "🕹️ コントローラを作成中..."
php artisan make:controller BookController > /dev/null 2>&1 || true

cat <<EOF > app/Http/Controllers/BookController.php
<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        // 書籍データを取得（著者情報付き、作成日時の新しい順）
        \$books = Book::with('author')->orderBy('created_at', 'desc')->get();
        return view('books.index', compact('books'));
    }
}
EOF

# 2. ビュー（画面）の作成
echo "🖼️ ビューファイルを作成中..."
mkdir -p resources/views/books

cat <<EOF > resources/views/books/index.blade.php
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>書籍一覧 - Kimrion</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">📚 書籍一覧リスト</h1>
        
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">書籍名</th>
                        <th class="py-3 px-6 text-left">著者名</th>
                        <th class="py-3 px-6 text-center">公開日</th>
                        <th class="py-3 px-6 text-right">閲覧数</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach (\$books as \$book)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap font-bold">{{ \$book->id }}</td>
                        <td class="py-3 px-6 text-left">{{ \$book->title }}</td>
                        <td class="py-3 px-6 text-left">
                            <span class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs">
                                {{ \$book->author->name }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            {{ \$book->published_at ? \$book->published_at->format('Y/m/d') : '-' }}
                        </td>
                        <td class="py-3 px-6 text-right">
                            {{ number_format(\$book->view_count) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
EOF

# 3. ルーティングの設定
echo "🛣️ ルーティングを追加中..."
# 既に定義されているか確認して、なければ追記
if ! grep -q "BookController" routes/web.php; then
cat <<EOF >> routes/web.php

use App\Http\Controllers\BookController;
Route::get('/books', [BookController::class, 'index'])->name('books.index');
EOF
fi

echo "✅ [UI] 画面構築が完了しました！"
