@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="verify-container">
    <p class="verify-text">
        登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。
    </p>
    <a href="http://localhost:8025" class="verify-button" target="_blank" rel="noopener noreferrer">
        認証はこちらから
    </a>
    <div>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="verify-resend-link">認証メールを再送する</button>
        </form>
    </div>
</div>
@endsection
