@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="tabs">
    <a href="/{{ request('keyword') ? '?keyword=' . request('keyword') : '' }}" class="tab {{ request('tab') != 'mylist' ? 'active' : '' }}">おすすめ</a>
    <a href="/{{ request('keyword') ? '?tab=mylist&keyword=' . request('keyword') : '?tab=mylist' }}" class="tab {{ request('tab') == 'mylist' ? 'active' : '' }}">マイリスト</a>
</div>
<div class="products-container">
    <div class="products-grid">
        @forelse($products as $product)
            <div class="product-card">
                <a href="{{ route('item.show', $product->id) }}">
                    <div class="product-image">
                        @if($product->images->first())
                            @if(Str::startsWith($product->images->first()->path, 'http'))
                                <img src="{{ $product->images->first()->path }}" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset($product->images->first()->path) }}" alt="{{ $product->name }}">
                        @endif
                        @else
                            <img src="{{ asset('images/no-image.png') }}" alt="No Image">
                        @endif

                        @if($product->isSold())
                            <span class="sold-label">Sold</span>
                        @endif
                    </div>
                    <div class="product-info">
                        <h2 class="product-name">{{ $product->name }}</h2>
                    </div>
                </a>
            </div>
        @empty
            <p>商品がありません</p>
        @endforelse
    </div>
</div>
@endsection