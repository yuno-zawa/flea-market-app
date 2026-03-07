@extends('layouts.app')

@section('content')
<div class="verify-email-container">
    <h2 class="verify-email-title">メール認証</h2>
    <p class="verify-email-text">
        登録していただいたメールアドレスに認証メールを送信しました。<br>
        メール内のリンクをクリックして、認証を完了してください。
    </p>

    @if (session('message'))
        <p class="verify-email-success">{{ session('message') }}</p>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="verify-email-button">認証メールを再送する</button>
    </form>
</div>
@endsection