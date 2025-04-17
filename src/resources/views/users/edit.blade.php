@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="profile-edit-container">
    <h1 class="profile-edit-title">プロフィール設定</h1>

    <div class="profile-image-block">
        <div class="image-preview"></div>
        <button class="image-button">画像を選択する</button>
    </div>

    <form action="#" method="POST" class="profile-form">
        @csrf

        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" id="name" name="name" placeholder="既存の値が入力されている">
        </div>

        <div class="form-group">
            <label for="zipcode">郵便番号</label>
            <input type="text" id="zipcode" name="zipcode" placeholder="既存の値が入力されている">
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" placeholder="既存の値が入力されている">
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" id="building" name="building" placeholder="既存の値が入力されている">
        </div>

        <div class="form-submit">
            <button type="submit" class="submit-button">更新する</button>
        </div>
    </form>
</div>
@endsection
