@extends('layouts.app')

@section('title', '配送先の変更')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="login-container">
    <h1>住所の変更</h1>
    <form method="POST" action="{{ route('purchase.address.update', $item->id) }}" novalidate>
        @csrf
        <div class="form-group">
            <label for="postal_code">郵便番号</label>
            <input
                id="postal_code"
                type="text"
                name="postal_code"
                value="{{ old('postal_code', session('shipping_postal_code', $user->postal_code)) }}"
                placeholder="123-4567"
            >
            @error('postal_code')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input
                id="address"
                type="text"
                name="address"
                value="{{ old('address', session('shipping_address', $user->address)) }}"
                placeholder="東京都渋谷区千駄ヶ谷1-2-3"
            >
            @error('address')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input
                id="building"
                type="text"
                name="building"
                value="{{ old('building', session('shipping_building', $user->building)) }}">
            @error('building')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">更新する</button>
    </form>
</div>
@endsection