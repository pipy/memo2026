<?php

namespace Database\Seeders;

use App\Models\Note;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Note::firstOrCreate(
            ['title' => 'Memo 2026へようこそ'],
            ['body' => 'このメモは php artisan db:seed で作成されました。自由に編集・削除できます。'],
        );
    }
}
