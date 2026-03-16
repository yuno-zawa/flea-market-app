@extends('layouts.app')

@section('title', '商品購入')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<form method="POST" action="{{ route('purchase.store', $item->id) }}">
    @csrf
    <div class="purchase-container">
        <div class="purchase-layout">
            <div class="purchase-left">
                <div class="purchase-item">
                    <div class="item-image">
                        @if($item->images->first())
                            @if(Str::startsWith($item->images->first()->path, 'http'))
                                <img src="{{ $item->images->first()->path }}" alt="{{ $item->name }}">
                            @else
                                <img src="{{ asset($item->images->first()->path) }}" alt="{{ $item->name }}">
                            @endif
                        @else
                            <img src="{{ asset('images/no-image.png') }}" alt="No Image">
                        @endif
                    </div>
                    <div class="item-info">
                        <h2 class="item-name">{{ $item->name }}</h2>
                        <p class="item-price">¥{{ number_format($item->price) }}</p>
                    </div>
                </div>

                <div class="purchase-section">
                    <h3 class="section-title">支払い方法</h3>
                    <select name="payment_method" id="payment_method" class="payment-select">
                        <option value="">選択してください</option>
                        <option value="convenience" {{ old('payment_method')=='convenience' ? 'selected' : '' }}>コンビニ払い</option>
                        <option value="card" {{ old('payment_method')=='card' ? 'selected' : '' }}>カード払い</option>
                    </select>
                    @error('payment_method')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="purchase-section">
                    <div class="section-header">
                        <h3 class="section-title">配送先</h3>
                        <a href="{{ route('purchase.address.edit', $item->id) }}" class="change-address-btn">変更する</a>
                    </div>
                    <div class="address-info">
                        @if($shipping['postal_code'] && $user->address)
                            <p>〒{{ $shipping['postal_code'] }}</p>
                            <p>{{ $shipping['address'] }}</p>
                            @if($shipping['building'])
                                <p>{{ $shipping['building'] }}</p>
                            @endif
                        @else
                            <p class="no-address">配送先が登録されていません</p>
                        @endif
                    </div>
                    <input type="hidden" name="shipping_id" value="{{ $shipping['id'] ?? '' }}">
                    @error('shipping_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="purchase-right">
                <div class="purchase-summary">
                    <table class="summary-table">
                        <tr>
                            <th>商品代金</th>
                            <td>¥{{ number_format($item->price) }}</td>
                        </tr>
                        <tr>
                            <th>支払い方法</th>
                            <td id="selected-payment">未選択</td>
                        </tr>
                    </table>
                    <button type="submit" class="purchase-submit-btn">購入する</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentSelect = document.getElementById('payment_method');
    const selectedPayment = document.getElementById('selected-payment');

    paymentSelect.addEventListener('change', function() {
        const value = this.value;
        const text = this.options[this.selectedIndex].text;
        selectedPayment.textContent = value ? text : '未選択';
    });
});
</script>
@endsection