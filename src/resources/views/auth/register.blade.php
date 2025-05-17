@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="page-container">
    <h2 class="page-title">会員登録</h2>
    <form class="form" action="/register" method="post">
    @csrf
        <div class="form-group">
            <label class="form-label" for="name">ユーザー名</label>
            <input type="text" id="name" name="name" class="form-input">
            @error('name')<div class="error-message">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label" for="email">メールアドレス</label>
            <input type="email" id="email" name="email" class="form-input">
            @error('email')<div class="error-message">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label" for="password">パスワード</label>
            <input type="password" id="password" name="password" class="form-input">
            @error('password')<div class="error-message">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label" for="password_confirmation">確認用パスワード</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input">
            @error('password')<div class="error-message">{{ $message }}</div>@enderror
        </div>
        <div class="form-submit">
            <button type="submit" class="submit-button">登録する</button>
        </div>
    </form>
    <div class="link">
        <a href="/login">ログインはこちら</a>
    </div>
</div>
@endsection
