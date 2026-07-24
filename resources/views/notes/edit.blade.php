@extends('layouts.app')

@section('title', 'メモを編集 | Memo 2026')

@section('content')
    <div class="form-page">
        <div class="page-heading">
            <p class="eyebrow">EDIT NOTE</p>
            <h1>メモを編集</h1>
        </div>

        <form class="note-form" method="POST" action="{{ route('notes.update', $note) }}">
            @include('notes._form', ['submitLabel' => '更新する'])
        </form>
    </div>
@endsection
