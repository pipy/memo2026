@csrf
@if (isset($note))
    @method('PUT')
@endif

<div class="form-group">
    <label for="title">タイトル <span class="required">必須</span></label>
    <input
        id="title"
        name="title"
        type="text"
        value="{{ old('title', $note->title ?? '') }}"
        maxlength="100"
        required
        autofocus
        @error('title') aria-invalid="true" aria-describedby="title-error" @enderror
    >
    @error('title')
        <p class="field-error" id="title-error">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label for="body">本文</label>
    <textarea
        id="body"
        name="body"
        rows="12"
        maxlength="10000"
        placeholder="メモの内容を入力してください"
        @error('body') aria-invalid="true" aria-describedby="body-error" @enderror
    >{{ old('body', $note->body ?? '') }}</textarea>
    @error('body')
        <p class="field-error" id="body-error">{{ $message }}</p>
    @enderror
</div>

<div class="form-actions">
    <a class="button button-ghost" href="{{ route('notes.index') }}">キャンセル</a>
    <button class="button button-primary" type="submit">{{ $submitLabel }}</button>
</div>
