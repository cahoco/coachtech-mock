@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/order.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="order-container">
    <div class="order-left">
        <div class="order-box">
            <div class="item-summary">
                <img src="{{ asset($item->image) }}" class="item-image" alt="商品画像">
                <div class="item-info">
                    <div class="item-name">{{ $item->name }}</div>
                    <div class="item-price">¥{{ number_format($item->price) }}</div>
                </div>
            </div>
        </div>
        <div class="order-box">
            <form method="GET" action="{{ route('orders.confirm', ['item_id' => $item->id]) }}">
                <label for="payment_method" class="order-label">支払い方法</label>
                    <select name="payment_method" id="payment_method" class="form-select" onchange="this.form.submit()">
                        <option value="">選択してください</option>
                        <option value="convenience" {{ request('payment_method') === 'convenience' ? 'selected' : '' }}>コンビニ払い</option>
                        <option value="credit" {{ request('payment_method') === 'credit' ? 'selected' : '' }}>カード払い</option>
                    </select>
            </form>
            @error('payment_method')<div class="error-message">{{ $message }}</div>@enderror
        </div>
        <div class="order-box">
            <div class="order-box-header">
                <div class="order-label">配送先</div>
                    <a href="{{ route('purchase.address.edit', ['item_id' => $item->id]) }}?payment_method={{ request('payment_method') }}" class="address-edit-link">変更する</a>
            </div>
            <div class="address-detail">
                <p>〒{{ $address->zipcode }}</p>
                <p>{{ $address->address }} {{ $address->building }}</p>
            </div>
        </div>
    </div>
    <div class="order-right">
        <form action="{{ route('orders.store', ['item_id' => $item->id]) }}" method="POST">
            @csrf
            <input type="hidden" name="address_id" value="{{ $address->id }}">
            <input type="hidden" name="payment_method" value="{{ old('payment_method', $payment_method ?? request('payment_method')) }}">
            <div class="order-summary">
                <div class="summary-row border-bottom">
                    <span>商品代金</span>
                    <span>¥{{ number_format($item->price) }}</span>
                </div>
                <div class="summary-row">
                    <span>支払い方法</span>
                    <span>
                    @if (($payment_method ?? request('payment_method')) === 'convenience')
                        コンビニ払い
                    @elseif (($payment_method ?? request('payment_method')) === 'credit')
                        カード払い
                    @else
                        未選択
                    @endif
                    </span>
                </div>
            </div>
            <button type="submit" class="purchase-button">購入する</button>
        </form>
    </div>
</div>
@endsection
