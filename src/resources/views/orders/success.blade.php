@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/order.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="order-container">
    <div class="order-box">
        <h2 class="order-complete-title">ご購入ありがとうございました！</h2>
        <p>商品「<strong>{{ $item->name }}</strong>」の購入が完了しました。</p>
        <p>お支払いの手続きが完了次第、発送準備に入ります。</p>
        <a href="{{ route('mypage') }}" class="back-to-mypage-button">マイページへ戻る</a>
    </div>
</div>
@endsection
