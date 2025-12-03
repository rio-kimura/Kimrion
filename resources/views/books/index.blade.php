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
                    @foreach ($books as $book)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap font-bold">{{ $book->id }}</td>
                        <td class="py-3 px-6 text-left">{{ $book->title }}</td>
                        <td class="py-3 px-6 text-left">
                            <span class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs">
                                {{ $book->author->name }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            {{ $book->published_at ? $book->published_at->format('Y/m/d') : '-' }}
                        </td>
                        <td class="py-3 px-6 text-right">
                            {{ number_format($book->view_count) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
