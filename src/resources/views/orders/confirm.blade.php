@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/order.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="order-container">
    {{-- 左カラム（商品情報、支払い方法、配送先） --}}
    <div class="order-left">
        <form action="{{ route('orders.store', ['item_id' => $item->id]) }}" method="POST">
            @csrf

            {{-- 商品情報 --}}
            <div class="item-summary">
                <img src="{{ asset($item->image) }}" class="item-image" alt="商品画像">
                <div class="item-info">
                    <div class="item-name">{{ $item->name }}</div>
                    <div class="item-price">¥{{ number_format($item->price) }}</div>
                </div>
            </div>

            <hr>

            {{-- 支払い方法 --}}
            <div class="payment-section">
                <label for="payment_method">支払い方法</label>
                <select name="payment_method" id="payment_method" required>
                    <option value="">選択してください</option>
                    <option value="convenience" {{ old('payment_method') == 'convenience' ? 'selected' : '' }}>コンビニ払い</option>
                    <option value="credit" {{ old('payment_method') == 'credit' ? 'selected' : '' }}>カード払い</option>
                </select>
                @error('payment_method')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <hr>

            {{-- 配送先 --}}
            <div class="address-section">
                <div class="address-label">配送先</div>
                <div class="address-detail">
                    <p>〒{{ $address->zipcode }}</p>
                    <p>{{ $address->address }} {{ $address->building }}</p>
                </div>
                <a href="{{ route('purchase.address.edit', ['item_id' => $item->id]) }}">変更する</a>
            </div>

            <input type="hidden" name="address_id" value="{{ $address->id }}">

            {{-- 右カラム（注文概要・購入ボタン） --}}
            <div class="order-right">
                <div class="order-summary">
                    <div class="summary-row">
                        <span>商品代金</span>
                        <span>¥{{ number_format($item->price) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>支払い方法</span>
                        <span>
                            @if (old('payment_method') === 'convenience')
                                コンビニ払い
                            @elseif (old('payment_method') === 'credit')
                                カード払い
                            @else
                                未選択
                            @endif
                        </span>
                    </div>
                </div>

                <div class="form-submit">
                    <button type="submit" class="purchase-button">購入する</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
