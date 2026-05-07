<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncomingLetterController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OutgoingLetterController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'dashboard' : 'login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('incoming-letters', IncomingLetterController::class);
    Route::get('incoming-letters/{incoming_letter}/download', [IncomingLetterController::class, 'download'])
        ->name('incoming-letters.download');

    Route::resource('outgoing-letters', OutgoingLetterController::class);
    Route::get('outgoing-letters/{outgoing_letter}/download', [OutgoingLetterController::class, 'download'])
        ->name('outgoing-letters.download');

    Route::resource('inventories', InventoryController::class)->except(['show']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
