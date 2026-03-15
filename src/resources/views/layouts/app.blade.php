<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Mogitate Market')</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>
    <body>
        <header class="header">
            <a class="header__logo" href="{{ route('products.index') }}">mogitate</a>
        </header>
        <main class="main">
            @yield('content')
        </main>
    </body>
</html>
