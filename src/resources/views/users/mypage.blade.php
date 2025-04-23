@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="mypage-container">
    <div class="mypage-header">
        @if ($user->profile->profile_image)
            <img src="{{ asset($user->profile->profile_image) }}" alt="プロフィール画像" class="user-icon">
        @endif
        <div class="user-info">
            <div class="user-name">{{ $user->profile->nickname ?? 'ユーザー名未登録' }}</div>
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
    @foreach ($items as $item)
        <div class="item-card">
            <img src="{{ asset('storage/images/' . $item->image) }}" class="item-image" alt="商品画像">
            <div class="item-name">{{ $item->name }}</div>
        </div>
    @endforeach
    </div>
</div>
@endsection
