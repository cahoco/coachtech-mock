@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="page-container">
    <h2 class="page-title">ログイン</h2>

    <form method="POST" action="#" class="form">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password" class="form-label">パスワード</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-submit">
            <button type="submit" class="submit-button">ログインする</button>
        </div>
    </form>

    <div class="link">
        <a href="{{ route('register') }}">会員登録はこちら</a>
    </div>
</div>
@endsection
