<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::redirect('/', '/notes');
    Route::resource('notes', NoteController::class)->except(['show']);
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
});
