<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookshelfController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReadingSessionController;
use App\Http\Controllers\ReadingGoalController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Books
    Route::resource('books', BookController::class);
    
    // Bookshelves
    Route::resource('bookshelves', BookshelfController::class);
    
    // Reading Sessions
    Route::post('/books/{book}/sessions', [ReadingSessionController::class, 'store'])->name('sessions.store');
    Route::delete('/sessions/{session}', [ReadingSessionController::class, 'destroy'])->name('sessions.destroy');
    
    // Reading Goals
    Route::prefix('goals')->group(function () {
        Route::get('/', [ReadingGoalController::class, 'index'])->name('goals.index');
        Route::get('/create', [ReadingGoalController::class, 'create'])->name('goals.create');
        Route::post('/', [ReadingGoalController::class, 'store'])->name('goals.store');
        Route::get('/{goal}/edit', [ReadingGoalController::class, 'edit'])->name('goals.edit');
        Route::put('/{goal}', [ReadingGoalController::class, 'update'])->name('goals.update');
    });
    
    // Tags
    Route::resource('tags', TagController::class)->except(['show']);
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';