@extends('layouts.app')

@section('title', 'メモ一覧 | Memo 2026')

@section('content')
    <section class="hero">
        <div>
            <p class="eyebrow">MY NOTES</p>
            <h1>メモ一覧</h1>
            <p class="hero-copy">思いついたことを、すぐに保存できます。</p>
        </div>
        <a class="button button-primary" href="{{ route('notes.create') }}">＋ メモを追加</a>
    </section>

    <form class="search-form" method="GET" action="{{ route('notes.index') }}">
        <label class="sr-only" for="q">メモを検索</label>
        <input
            id="q"
            name="q"
            type="search"
            value="{{ $keyword }}"
            placeholder="タイトル・本文から検索"
            maxlength="100"
        >
        <button class="button button-secondary" type="submit">検索</button>
        @if ($keyword !== '')
            <a class="button button-ghost" href="{{ route('notes.index') }}">解除</a>
        @endif
    </form>

    @if ($keyword !== '')
        <p class="search-result">「{{ $keyword }}」の検索結果</p>
    @endif

    <div class="note-grid">
        @forelse ($notes as $note)
            <article class="note-card">
                <div class="note-card-body">
                    <h2>{{ $note->title }}</h2>
                    <p class="note-text">
                        {{ $note->body ? \Illuminate\Support\Str::limit($note->body, 180) : '本文はありません。' }}
                    </p>
                </div>
                <div class="note-card-footer">
                    <time datetime="{{ $note->updated_at->toAtomString() }}">
                        更新 {{ $note->updated_at->format('Y/m/d H:i') }}
                    </time>
                    <div class="note-actions">
                        <a class="text-link" href="{{ route('notes.edit', $note) }}">編集</a>
                        <form method="POST" action="{{ route('notes.destroy', $note) }}" onsubmit="return confirm('このメモを削除しますか？');">
                            @csrf
                            @method('DELETE')
                            <button class="text-link text-danger" type="submit">削除</button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <div class="empty-state">
                <div class="empty-icon">✎</div>
                <h2>{{ $keyword !== '' ? '該当するメモがありません' : 'まだメモがありません' }}</h2>
                <p>{{ $keyword !== '' ? '別のキーワードで検索してください。' : '最初のメモを登録してみましょう。' }}</p>
                @if ($keyword === '')
                    <a class="button button-primary" href="{{ route('notes.create') }}">メモを作成</a>
                @endif
            </div>
        @endforelse
    </div>

    @if ($notes->hasPages())
        <nav class="pagination" aria-label="ページ移動">
            @if ($notes->onFirstPage())
                <span class="button button-ghost is-disabled">← 前へ</span>
            @else
                <a class="button button-ghost" href="{{ $notes->previousPageUrl() }}" rel="prev">← 前へ</a>
            @endif

            <span class="page-number">{{ $notes->currentPage() }}ページ</span>

            @if ($notes->hasMorePages())
                <a class="button button-ghost" href="{{ $notes->nextPageUrl() }}" rel="next">次へ →</a>
            @else
                <span class="button button-ghost is-disabled">次へ →</span>
            @endif
        </nav>
    @endif
@endsection
