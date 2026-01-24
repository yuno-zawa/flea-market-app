<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @yield('css')
</head>
<body>
    <header>
        <div class="header-inner">
            <div class="logo">
                <img src="{{ asset('images/header-logo.png') }}" alt="COACHTECHロゴ">
            </div>
        </div>
    </header>
    @yield('content')
</body>
</html>