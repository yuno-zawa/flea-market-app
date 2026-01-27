<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'COACHTECH')</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>
<body>
    <header>
        <div class="header-inner">
            <div class="logo">
                <img src="{{ asset('images/header-logo.png') }}" alt="COACHTECHロゴ">
            </div>
            @auth
            <nav class="header-nav">
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">ログアウト</button>
                </form>
                <form action="/mypage" method="GET">
                    @csrf
                    <button type="submit" class="mypage-btn">マイページ</button>
                </form>
                <form action="/sell" method="GET">
                    @csrf
                    <button type="submit" class="sell-btn">出品</button>
            </nav>
            @endauth
        </div>
    </header>
    @yield('content')
</body>
</html>