<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login'); // Always go to Breeze login
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Self profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin editing other users
    Route::get('/profile/{id}', [ProfileController::class, 'edit'])->name('profile.edit.user');
    Route::patch('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update.user');
});

require __DIR__.'/auth.php'; // Breeze auth routes
