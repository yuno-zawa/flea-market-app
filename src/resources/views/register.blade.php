@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register-container">
    <h1>新規登録</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="name">名前</label>
            <input id="name" type="text" name="name" required autofocus>
        </div>
        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="password-confirm">確認用パスワード</label>
            <input id="password-confirm" type="password" name="password_confirmation" required>
        </div>
        <button type="submit">登録する</button>
        <p><a href="/login">ログインはこちら</a></p>
    </form>
</div>
@endsection