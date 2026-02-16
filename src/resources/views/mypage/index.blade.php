@extends('layouts.app')

@section('title', 'マイページ')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage-container">
    <!-- プロフィール情報 -->
    <div class="profile-section">
        <div class="profile-info">
            <div class="profile-image">
                @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}">
                @else
                    <div class="avatar-placeholder">{{ mb_substr($user->name, 0, 1) }}</div>
                @endif
            </div>
            <h2 class="profile-name">{{ $user->name }}</h2>
        </div>
        <a href="{{ route('profile.edit') }}" class="profile-edit-btn">プロフィールを編集</a>
    </div>

    <!-- タブ -->
    <div class="mypage-tabs">
        <a href="{{ route('mypage.index', ['tab' => 'listed']) }}" 
           class="tab {{ request('tab') != 'purchased' ? 'active' : '' }}">出品した商品</a>
        <a href="{{ route('mypage.index', ['tab' => 'purchased']) }}" 
           class="tab {{ request('tab') == 'purchased' ? 'active' : '' }}">購入した商品</a>
    </div>

    <!-- 商品一覧 -->
    <div class="mypage-items">
        @if(request('tab') == 'purchased')
            <!-- 購入した商品 -->
            @forelse($purchasedItems as $item)
                <a href="{{ route('item.show', $item->id) }}" class="item-card">
                    <div class="item-image">
                        @if($item->images->first())
                            <img src="{{ $item->images->first()->path }}" alt="{{ $item->name }}">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" alt="No Image">
                        @endif
                        @if($item->isSold())
                            <span class="sold-badge">Sold</span>
                        @endif
                    </div>
                    <p class="item-name">{{ $item->name }}</p>
                </a>
            @empty
                <p class="no-items">購入した商品はありません</p>
            @endforelse
        @else
            <!-- 出品した商品 -->
            @forelse($listedItems as $item)
                <a href="{{ route('item.show', $item->id) }}" class="item-card">
                    <div class="item-image">
                        @if($item->images->first())
                            <img src="{{ $item->images->first()->path }}" alt="{{ $item->name }}">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" alt="No Image">
                        @endif
                        @if($item->isSold())
                            <span class="sold-badge">Sold</span>
                        @endif
                    </div>
                    <p class="item-name">{{ $item->name }}</p>
                </a>
            @empty
                <p class="no-items">出品した商品はありません</p>
            @endforelse
        @endif
    </div>
</div>
@endsection