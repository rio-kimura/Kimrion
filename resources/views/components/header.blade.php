<header>
    <a href="{{ route('home') }}"><h1>KimRion</h1></a>
    <nav>
	    @guest
        <a href="{{ route('home') }}">ホーム</a>
        <a href="{{ route('login') }}">ログイン</a>
		@endguest
		@auth
		<a href="{{ route('books.index') }}">検索</a>
		<a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            ログアウト
        </a>
        <form id="logout-form" method="POST" action="{{ route('logout') }}">
            @csrf
        </form>
        @endauth
    </nav>
</header>