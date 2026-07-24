@extends('layouts.app')

@section('title', 'メモを追加 | Memo 2026')

@section('content')
    <div class="form-page">
        <div class="page-heading">
            <p class="eyebrow">NEW NOTE</p>
            <h1>メモを追加</h1>
        </div>

        <form class="note-form" method="POST" action="{{ route('notes.store') }}">
            @include('notes._form', ['submitLabel' => '登録する'])
        </form>
    </div>
@endsection
