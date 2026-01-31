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
                <div class="product-image">
                    @if($product->images->first())
                        <img src="{{ $product->images->first()->path }}" alt="{{ $product->name }}">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" alt="No Image">
                    @endif
                </div>
                <div class="product-info">
                    <h2 class="product-name">{{ $product->name }}</h2>
                </div>
            </div>
        @empty
            <p>商品がありません</p>
        @endforelse
    </div>
</div>
@endsection