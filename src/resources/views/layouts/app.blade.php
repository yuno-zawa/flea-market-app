<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'COACHTECH')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header>
        <div class="header-inner">
            <a href="{{ route('products.index') }}" class="logo">
                <img src="{{ asset('images/header-logo.png') }}" alt="COACHTECHロゴ">
            </a>

            @unless(request()->routeIs('login') || request()->routeIs('register'))
            <div class="search-box">
                <form action="/" method="GET">
                    <input type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
                </form>
            </div>
            @endunless

            <nav class="header-nav">
                @auth
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">ログアウト</button>
                    </form>
                    <form action="/mypage" method="GET">
                        <button type="submit" class="mypage-btn">マイページ</button>
                    </form>
                    <form action="/sell" method="GET">
                        <button type="submit" class="sell-btn">出品</button>
                    </form>
                @else
                <!-- 未ログイン -->
                    <a href="/login" class="login-btn">ログイン</a>
                    <a href="/login" class="mypage-btn">マイページ</a>
                    <a href="/login" class="sell-btn">出品</a>
            </nav>
            @endauth
        </div>
    </header>
    @yield('content')


@yield('scripts')
</body>
</html>