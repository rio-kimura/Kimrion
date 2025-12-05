<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KimRion</title>

    <link rel="stylesheet" href="{{ asset('CSS/style.css') }}">

</head>
<body>

    <header>
        <a href="{{ route('home') }}"><h1>KimRion</h1></a>
        <nav>
            <a href="{{ route('home') }}">ホーム</a>
            <a href="{{ route('book.index') }}">検索</a>
            <a href="#">ログイン</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2024 文庫サイトプロジェクト</p>
    </footer>

</body>
</html>
