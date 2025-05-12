<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}?v={{ time() }}">
    @yield('css')
</head>
<body>
<header class="header">
    <div class="header__inner">
        {{-- ロゴは常に表示 --}}
        <a class="header__logo" href="{{ route('items.index') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="Coachtech" />
        </a>

        {{-- ログイン・登録・メール認証画面ではロゴのみ、それ以外はナビゲーション表示 --}}
        @if (!Request::is('login') && !Request::is('register') && !Request::is('email/verify'))
            {{-- 🔍 検索フォーム --}}
            <form action="{{ route('items.index') }}" method="GET" class="header__search-form">
                <input 
                    type="text" 
                    name="keyword" 
                    class="header__search-input" 
                    placeholder="なにをお探しですか？" 
                    value="{{ request('keyword') }}"
                >
                <input 
                    type="hidden" 
                    name="tab" 
                    value="{{ request('tab', 'recommend') }}"
                >
            </form>

            <nav class="header__nav">
                @auth
                    <form class="form" action="/logout" method="post">
                        @csrf
                        <button class="header__link-button">ログアウト</button>
                    </form>
                    <a href="{{ route('mypage') }}" class="header__link">マイページ</a>
                    <a href="{{ route('items.create') }}" class="header__button">出品</a>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="header__link">ログイン</a>
                    <a href="{{ route('login') }}" class="header__link">マイページ</a>
                    <a href="{{ route('login') }}" class="header__button">出品</a>
                @endguest
            </nav>
        @endif
    </div>
</header>

<main>
    @yield('content')
</main>
</body>
</html>
