@extends('layouts.app')

@section('title', '商品購入')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase-container">
    <div class="purchase-layout">
        <!-- 左側：商品情報・支払い方法・配送先 -->
        <div class="purchase-left">
            <!-- 商品情報 -->
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

            <!-- 支払い方法 -->
            <div class="purchase-section">
                <h3 class="section-title">支払い方法</h3>
                <select name="payment_method" id="payment_method" class="payment-select">
                    <option value="">選択してください</option>
                    <option value="convenience">コンビニ支払い</option>
                    <option value="card">カード支払い</option>
                </select>
            </div>

            <!-- 配送先 -->
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
            </div>
        </div>

        <!-- 右側：小計・購入ボタン -->
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

                <form method="POST" action="{{ route('purchase.store', $item->id) }}">
                    @csrf
                    <input type="hidden" name="payment_method" id="hidden_payment_method" value="">
                    <button type="submit" class="purchase-submit-btn">購入する</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentSelect = document.getElementById('payment_method');
    const selectedPayment = document.getElementById('selected-payment');
    const hiddenPayment = document.getElementById('hidden_payment_method');

    paymentSelect.addEventListener('change', function() {
        const value = this.value;
        const text = this.options[this.selectedIndex].text;

        hiddenPayment.value = value;

        if (value) {
            selectedPayment.textContent = text;
        } else {
            selectedPayment.textContent = '未選択';
        }
    });
});
</script>
@endsection