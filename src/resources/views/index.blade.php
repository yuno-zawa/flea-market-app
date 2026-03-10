@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="products-container">
    <div class="tabs">
        <a href="/" class="tab {{ request('tab') != 'mylist' ? 'active' : '' }}">おすすめ</a>
        <a href="/?tab=mylist" class="tab {{ request('tab') == 'mylist' ? 'active' : '' }}">マイリスト</a>
    </div>

    <div class="products-grid">
        @forelse($products as $product)
            <div class="product-card">
                <a href="{{ route('item.show', $product->id) }}">
                    <div class="product-image">
                        @if($item->images->first())
                            @if(Str::startsWith($item->images->first()->path, 'http'))
                                <img src="{{ $item->images->first()->path }}" alt="{{ $item->name }}">
                            @else
                                <img src="{{ asset($item->images->first()->path) }}" alt="{{ $item->name }}">
                            @endif
                        @else
                            <img src="{{ asset('images/no-image.png') }}" alt="No Image">
                        @endif

                        {{-- 購入済みならSoldラベル表示（要件3） --}}
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