<?php

namespace Tests\Feature;

use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_note_can_be_created(): void
    {
        $response = $this->post(route('notes.store'), [
            'title' => '買い物メモ',
            'body' => '牛乳と卵を買う',
        ]);

        $response->assertRedirect(route('notes.index'));
        $this->assertDatabaseHas('notes', ['title' => '買い物メモ']);
    }

    public function test_title_is_required(): void
    {
        $response = $this->from(route('notes.create'))->post(route('notes.store'), [
            'title' => '',
            'body' => '本文だけ',
        ]);

        $response->assertRedirect(route('notes.create'));
        $response->assertSessionHasErrors('title');
    }

    public function test_note_can_be_updated(): void
    {
        $note = Note::create(['title' => '変更前', 'body' => '本文']);

        $response = $this->put(route('notes.update', $note), [
            'title' => '変更後',
            'body' => '更新した本文',
        ]);

        $response->assertRedirect(route('notes.index'));
        $this->assertDatabaseHas('notes', ['id' => $note->id, 'title' => '変更後']);
    }

    public function test_note_can_be_deleted(): void
    {
        $note = Note::create(['title' => '削除対象', 'body' => null]);

        $response = $this->delete(route('notes.destroy', $note));

        $response->assertRedirect(route('notes.index'));
        $this->assertDatabaseMissing('notes', ['id' => $note->id]);
    }

    public function test_notes_can_be_searched(): void
    {
        Note::create(['title' => 'Laravelの勉強', 'body' => 'Eloquentを学ぶ']);
        Note::create(['title' => '旅行', 'body' => '沖縄の予定']);

        $this->get(route('notes.index', ['q' => 'Eloquent']))
            ->assertOk()
            ->assertSee('Laravelの勉強')
            ->assertDontSee('旅行');
    }
}
