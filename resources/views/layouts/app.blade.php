<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Laravelで作成したシンプルなメモアプリ">
    <title>@yield('title', 'Memo 2026')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="{{ route('notes.index') }}" aria-label="メモ一覧へ">
                <span class="brand-mark">M</span>
                <span>Memo 2026</span>
            </a>
            <a class="button button-primary button-small" href="{{ route('notes.create') }}">新しいメモ</a>
        </div>
    </header>

    <main class="container main-content">
        @if (session('success'))
            <div class="flash" role="status">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">Built with PHP / Laravel / MySQL</div>
    </footer>
</body>
</html>
