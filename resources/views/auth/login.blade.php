@extends('layouts.app')

@section('title', 'ログイン | Memo 2026')

@section('content')
    <section class="auth-page">
        <div class="auth-card">
            <p class="eyebrow">MEMBER ONLY</p>
            <h1>ログイン</h1>
            <p class="hero-copy">登録済みのメールアドレスとパスワードを入力してください。</p>

            <form class="auth-form" method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required
                        autofocus
                        @error('email') aria-invalid="true" @enderror
                    >
                    @error('email')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        autocomplete="current-password"
                        required
                        @error('password') aria-invalid="true" @enderror
                    >
                    @error('password')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <label class="remember-row">
                    <input type="checkbox" name="remember" value="1">
                    <span>ログイン状態を保持する</span>
                </label>

                <button class="button button-primary auth-submit" type="submit">ログイン</button>
            </form>
        </div>
    </section>
@endsection
