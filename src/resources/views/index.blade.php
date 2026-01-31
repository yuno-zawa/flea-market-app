@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="products-container">
    <h1>商品一覧</h1>
    <div class="products-grid">
        @forelse($products as $product)
            <div class="product-card">
                <a href="{{ route('products.show', $product->id) }}">
                    <div class="product-image">
                        @if($product->images->first())
                            <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" alt="No Image">
                        @endif
                    </div>
                    <div class="product-info">
                        <h2 class="product-name">{{ $product->name }}</h2>
                        <p class="product-price">¥{{ number_format($product->price) }}</p>
                    </div>
                </a>
            </div>
        @empty
            <p>商品がありません</p>
        @endforelse
    </div>
</div>
@endsection
