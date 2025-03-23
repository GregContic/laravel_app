<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Auth;

// Authentication Routes
Auth::routes();

// Protect the notes routes with authentication
Route::middleware(['auth'])->group(function () {
    Route::resource('notes', NoteController::class);
});

// Redirect root to notes if authenticated, otherwise to login
Route::get('/', function () {
    return auth()->check() ? redirect('/notes') : redirect('/login');
});
