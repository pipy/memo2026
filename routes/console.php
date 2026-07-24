<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('memo:count', function (): void {
    $this->info('メモ件数: '.\App\Models\Note::query()->count());
})->purpose('登録されているメモ件数を表示する');
