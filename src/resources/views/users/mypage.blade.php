@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="mypage-container">
    <div class="mypage-header">
        <div class="user-icon"></div>
        <div class="user-info">
            <div class="user-name">ユーザー名</div>
        </div>
        <div class="edit-button">
            <a href="{{ route('profile.edit') }}" class="btn-edit">プロフィールを編集</a>
        </div>
    </div>

    <div class="tab-menu">
        <a href="#" class="tab active">出品した商品</a>
        <a href="#" class="tab">購入した商品</a>
    </div>

    <div class="item-list">
        <div class="item-card">
            <div class="item-image no-image">商品画像</div>
            <div class="item-name">商品名</div>
        </div>
    </div>
</div>
@endsection
