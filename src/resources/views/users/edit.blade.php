@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="page-container">
    <h1 class="page-title">プロフィール設定</h1>

    <div class="profile-image-block">
        {{-- 画像を表示（プロフィール画像がある場合のみ） --}}
        @if (!empty($user->profile->profile_image))
        <img src="{{ asset($user->profile->profile_image) }}" alt="プロフィール画像" class="image-preview">
    @else
        <div class="image-preview"></div>
    @endif
        <label for="profile_image" class="image-button">画像を選択する</label>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="form">
        @csrf

        <div class="form-group" style="display: none;">
            <label for="profile_image" class="form-label">プロフィール画像</label>
            <input type="file" id="profile_image" name="profile_image" class="form-input">
            @error('profile_image')<div class="error-message">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="nickname" class="form-label">ユーザー名</label>
            <input type="text" id="nickname" name="nickname" class="form-input" value="{{ old('nickname', $user->profile->nickname ?? '') }}">
            @error('nickname')<div class="error-message">{{ $message }}</div>@enderror
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
