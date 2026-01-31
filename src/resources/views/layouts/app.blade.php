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

            <div class="search-box">
                <form action="/" method="GET">
                    <input type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
                </form>
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

<script>
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview');

    if (file && preview) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // divの場合はimgに置き換える
            if (preview.tagName === 'DIV') {
                const img = document.createElement('img');
                img.id = 'preview';
                img.alt = 'プロフィール画像';
                img.src = e.target.result;
                preview.parentNode.replaceChild(img, preview);
            } else {
                // すでにimgの場合は画像を更新
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
        }
        reader.readAsDataURL(file);
    }
}
</script>
</body>
</html>