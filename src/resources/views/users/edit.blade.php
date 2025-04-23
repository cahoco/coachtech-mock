@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="page-container">
    <h1 class="page-title">プロフィール設定</h1>

    <div class="profile-image-block">
        <div class="image-preview"></div>
        <button class="image-button">画像を選択する</button>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" class="form">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">ユーザー名</label>
            <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $user->profile->nickname ?? '') }}">
            @error('name')<div class="error-message">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="zipcode" class="form-label">郵便番号</label>
            <input type="text" id="zipcode" name="zipcode" class="form-input" value="{{ old('zipcode', $user->profile->zipcode ?? '') }}">
            @error('zipcode')<div class="error-message">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="address" class="form-label">住所</label>
            <input type="text" id="address" name="address" class="form-input" value="{{ old('address', $user->profile->address ?? '') }}">
            @error('address')<div class="error-message">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="building" class="form-label">建物名</label>
            <input type="text" id="building" name="building" class="form-input" value="{{ old('building', $user->profile->building ?? '') }}">
            @error('building')<div class="error-message">{{ $message }}</div>@enderror
        </div>

        <div class="form-submit">
            <button type="submit" class="submit-button">更新する</button>
        </div>
    </form>
</div>
@endsection
