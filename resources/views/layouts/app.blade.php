<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'KimRion')</title>
  <link rel="stylesheet" href="{{ asset('CSS/style.css') }}">
</head>
    <body>

        @include('components.header')

        <main>
            @yield('content')
        </main>

        @include('components.footer')
        
    </body>
</html>