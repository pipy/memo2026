<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Models\Note;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NoteController extends Controller
{
    public function index(Request $request): View
    {
        $keyword = trim((string) $request->query('q', ''));

        $notes = Note::query()
            ->when($keyword !== '', function (Builder $query) use ($keyword): void {
                $query->where(function (Builder $query) use ($keyword): void {
                    $query
                        ->where('title', 'like', "%{$keyword}%")
                        ->orWhere('body', 'like', "%{$keyword}%");
                });
            })
            ->latest('updated_at')
            ->simplePaginate(10)
            ->withQueryString();

        return view('notes.index', compact('notes', 'keyword'));
    }

    public function create(): View
    {
        return view('notes.create');
    }

    public function store(NoteRequest $request): RedirectResponse
    {
        Note::create($request->validated());

        return redirect()
            ->route('notes.index')
            ->with('success', 'メモを登録しました。');
    }

    public function edit(Note $note): View
    {
        return view('notes.edit', compact('note'));
    }

    public function update(NoteRequest $request, Note $note): RedirectResponse
    {
        $note->update($request->validated());

        return redirect()
            ->route('notes.index')
            ->with('success', 'メモを更新しました。');
    }

    public function destroy(Note $note): RedirectResponse
    {
        $note->delete();

        return redirect()
            ->route('notes.index')
            ->with('success', 'メモを削除しました。');
    }
}
