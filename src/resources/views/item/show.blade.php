@extends('layouts.app')

@section('title', '商品詳細')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="item-container">
    <div class="item-main">
        <!-- 左側：商品画像 -->
        <div class="item-image">
            @if($item->images->first())
                <img src="{{ $item->images->first()->path }}" alt="{{ $item->name }}">
            @else
                <img src="{{ asset('images/no-image.png') }}" alt="No Image">
            @endif
        </div>

        <!-- 右側：全ての情報 -->
        <div class="item-info-wrapper">
            <!-- 商品情報 -->
            <div class="item-info">
                <h1 class="item-name">{{ $item->name }}</h1>
                
                @if($item->brand)
                    <p class="item-brand">{{ $item->brand }}</p>
                @endif
                
                <p class="item-price">¥{{ number_format($item->price) }} <span class="tax-included">(税込)</span></p>
                
                <!-- いいね・コメント -->
                <div class="item-actions">
                    @auth
                        <form action="{{ route('like.toggle', $item->id) }}" method="POST" class="like-form">
                            @csrf
                            <button type="submit" class="like-btn {{ $item->isLikedBy(Auth::id()) ? 'liked' : '' }}">
                                @if($item->isLikedBy(Auth::id()))
                                    <img src="{{ asset('images/heart-pink.png') }}" alt="いいね済み" class="like-icon">
                                @else
                                    <img src="{{ asset('images/heart-logo.png') }}" alt="いいね" class="like-icon">
                                @endif
                                <span class="like-count">{{ $item->likesCount() }}</span>
                            </button>
                        </form>
                    @else
                        <a href="/login" class="like-btn">
                            <img src="{{ asset('images/heart-logo.png') }}" alt="いいね" class="like-icon">
                            <span class="like-count">{{ $item->likesCount() }}</span>
                        </a>
                    @endauth
                    
                    <span class="comment-count">
                        <img src="{{ asset('images/speech-bubble.png') }}" alt="コメント" class="comment-icon">
                        {{ $item->comments->count() }}
                    </span>
                </div>
                
                <!-- 購入ボタン -->
                @if($item->isSold())
                    <p class="sold-message">売り切れ</p>
                @else
                    @auth
                        <a href="#" class="purchase-btn">購入手続きへ</a>
                    @else
                        <a href="/login" class="purchase-btn">購入手続きへ</a>
                    @endauth
                @endif
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
                
                <!-- 出品者情報 -->
                <div class="seller-info">
                    <div class="seller-avatar">
                        @if($item->user->profile_image)
                            <img src="{{ asset('storage/' . $item->user->profile_image) }}" alt="{{ $item->user->name }}">
                        @else
                            <div class="avatar-placeholder">{{ mb_substr($item->user->name, 0, 1) }}</div>
                        @endif
                    </div>
                    <div class="seller-name">
                        <strong>{{ $item->user->name }}</strong>
                    </div>
                </div>

                <!-- コメント一覧 -->
                <div class="comments-list">
                    @forelse($item->comments as $comment)
                        <div class="comment">
                            <div class="comment-header">
                                <div class="comment-avatar">
                                    @if($comment->user->profile_image)
                                        <img src="{{ asset('storage/' . $comment->user->profile_image) }}" alt="{{ $comment->user->name }}">
                                    @else
                                        <div class="avatar-placeholder">{{ mb_substr($comment->user->name, 0, 1) }}</div>
                                    @endif
                                </div>
                                <div class="comment-user-info">
                                    <strong>{{ $comment->user->name }}</strong>
                                    <span class="comment-date">{{ $comment->created_at->format('Y-m-d H:i') }}</span>
                                </div>
                            </div>
                            <p class="comment-content">{{ $comment->content }}</p>
                        </div>
                    @empty
                        <p class="no-comments">まだコメントがありません</p>
                    @endforelse
                </div>

                <!-- コメント投稿フォーム -->
                @auth
                    <form action="#" method="POST" class="comment-form" onsubmit="alert('コメント機能は準備中です'); return false;">
                        @csrf
                        <label for="content">商品へのコメント</label>
                        <textarea id="content" name="content"  required maxlength="255">{{ old('content') }}</textarea>
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
    </div>
</div>
@endsection