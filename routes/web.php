<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DiscussionPublicController;
use App\Http\Controllers\FeedbackController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/diskusi', [DiscussionPublicController::class, 'store'])->name('diskusi.store');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
