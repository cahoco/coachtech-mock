@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="mypage-container">
    <div class="mypage-header">
        <img src="{{ asset($user->profile->profile_image ?? 'storage/images/default.png') }}" class="user-icon">
        <div class="user-info">
            <div class="user-name">{{ $user->profile->nickname ?? 'ユーザー名未登録' }}</div>
        </div>
        <div class="edit-button">
            <a href="{{ route('profile.edit') }}" class="btn-edit">プロフィールを編集</a>
        </div>
    </div>

    <div class="tab-menu">
        <a href="{{ route('mypage', ['tab' => 'sell']) }}" class="tab {{ $tab === 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="{{ route('mypage', ['tab' => 'buy']) }}" class="tab {{ $tab === 'buy' ? 'active' : '' }}">購入した商品</a>
    </div>

    @if ($tab === 'buy')
    <div class="item-list">
        @foreach ($purchasedItems as $item)
            <div class="item-card">
                <img src="{{ asset($item->image) }}" class="item-image" alt="商品画像">
                <div class="item-name">{{ $item->name }}</div>
            </div>
        @endforeach
    </div>
@else
    <div class="item-list">
        @foreach ($soldItems as $item)
            <div class="item-card">
                <img src="{{ asset($item->image) }}" class="item-image" alt="商品画像">
                <div class="item-name">{{ $item->name }}</div>
            </div>
        @endforeach
    </div>
@endif

</div>
@endsection
