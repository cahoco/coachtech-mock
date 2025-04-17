<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>coachtech-mock</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}?v={{ time() }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                <img src="{{ asset('images/logo.svg') }}" alt="Coachtech" />
            </a>
            <form action="{{ url('/') }}" method="GET" class="header__search-form">
                <input type="text" name="keyword" class="header__search-input" placeholder="なにをお探しですか？">
            </form>
            <nav class="header__nav">
                <a href="/logout" class="header__link">ログアウト</a>
                <a href="{{ route('mypage') }}" class="header__link">マイページ</a>
                <a href="{{ route('create') }}" class="header__button">出品</a>
            </nav>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>