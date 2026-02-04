@extends('layouts.app')

@section('title', $item->name)

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('content')
<div class="item-container">
    <div class="item-main">
        <!-- 商品画像 -->
        <div class="item-image">
            @if($item->images->first())
                <img src="{{ $item->images->first()->path }}" alt="{{ $item->name }}">
            @else
                <img src="{{ asset('images/no-image.png') }}" alt="No Image">
            @endif
        </div>

        <!-- 商品情報 -->
        <div class="item-info">
            <h1 class="item-name">{{ $item->name }}</h1>
            
            @if($item->brand)
                <p class="item-brand">{{ $item->brand }}</p>
            @endif
            
            <p class="item-price">¥{{ number_format($item->price) }}（税込）</p>
            
            <!-- いいね・コメント -->
            <div class="item-actions">
                @auth
                    <form action="{{ route('like.toggle', $item->id) }}" method="POST" class="like-form">
                        @csrf
                        <button type="submit" class="like-btn {{ $item->isLikedBy(Auth::id()) ? 'liked' : '' }}">
                            <span class="like-icon">{{ $item->isLikedBy(Auth::id()) ? '★' : '☆' }}</span>
                            <span class="like-count">{{ $item->likesCount() }}</span>
                        </button>
                    </form>
                @else
                    <span class="like-btn disabled">
                        <span class="like-icon">☆</span>
                        <span class="like-count">{{ $item->likesCount() }}</span>
                    </span>
                @endauth
                
                <span class="comment-count">
                    <span class="comment-icon">💬</span>
                    {{ $item->comments->count() }}
                </span>
            </div>
            
            <!-- 購入ボタン -->
            @if($item->isSold())
                <p class="sold-message">売り切れ</p>
            @else
                @auth
                    <a href="{{ route('purchase.show', $item->id) }}" class="purchase-btn">購入手続きへ</a>
                @else
                    <a href="/login" class="purchase-btn">購入手続きへ</a>
                @endauth
            @endif
        </div>
    </div>

    <!-- 商品説明 -->
    <div class="item-description">
        <h2>商品説明</h2>
        <p>{{ $item->description }}</p>
    </div>

    <!-- 商品情報 -->
    <div class="item-details">
        <h2>商品の情報</h2>
        <table>
            <tr>
                <th>カテゴリー</th>
                <td>
                    @forelse($item->categories as $category)
                        <span class="category-tag">{{ $category->name }}</span>
                    @empty
                        未設定
                    @endforelse
                </td>
            </tr>
            <tr>
                <th>商品の状態</th>
                <td>{{ $item->condition }}</td>
            </tr>
        </table>
    </div>

    <!-- コメント -->
    <div class="item-comments">
        <h2>コメント（{{ $item->comments->count() }}）</h2>
        
        @foreach($item->comments as $comment)
            <div class="comment">
                <div class="comment-user">
                    <strong>{{ $comment->user->name }}</strong>
                    <span class="comment-date">{{ $comment->created_at->format('Y-m-d H:i') }}</span>
                </div>
                <p class="comment-content">{{ $comment->content }}</p>
            </div>
        @endforeach

        <!-- コメント投稿フォーム -->
        @auth
            <form action="{{ route('comment.store', $item->id) }}" method="POST" class="comment-form">
                @csrf
                <textarea name="content" placeholder="コメントを入力" required maxlength="255">{{ old('content') }}</textarea>
                @error('content')
                    <p class="error">{{ $message }}</p>
                @enderror
                <button type="submit">コメントを送信する</button>
            </form>
        @else
            <p class="login-message">コメントするには<a href="/login">ログイン</a>してください</p>
        @endauth
    </div>
</div>
@endsection