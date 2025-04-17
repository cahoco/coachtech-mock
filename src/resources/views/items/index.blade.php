@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="tab-container">
    <div class="tab-menu">
        <a href="#" class="tab active">おすすめ</a>
        <a href="#" class="tab">マイリスト</a>
    </div>
</div>

<div class="item-list">
    <div class="item-card">
        <div class="item-image no-image">商品画像</div>
        <div class="item-name">商品名</div>
    </div>
</div>
@endsection
