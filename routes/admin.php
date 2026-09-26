<?php

use App\Http\Controllers\Admin\ContentBlockController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DiscussionController;
use App\Http\Controllers\Admin\MediaEducationController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Semua route di bawah ini hanya bisa diakses user yang sudah login (auth).
// Karena registrasi publik dimatikan (lihat SETUP.md), setiap user terdaftar = admin.
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Profil & Informasi HPV (disimpan sebagai "content block")
    Route::get('/konten/{section}', [ContentBlockController::class, 'index'])->name('content.index');
    Route::get('/konten/{section}/tambah', [ContentBlockController::class, 'create'])->name('content.create');
    Route::post('/konten/{section}', [ContentBlockController::class, 'store'])->name('content.store');
    Route::get('/konten-item/{contentBlock}/edit', [ContentBlockController::class, 'edit'])->name('content.edit');
    Route::put('/konten-item/{contentBlock}', [ContentBlockController::class, 'update'])->name('content.update');
    Route::delete('/konten-item/{contentBlock}', [ContentBlockController::class, 'destroy'])->name('content.destroy');

    // Media Edukasi
    Route::resource('media-edukasi', MediaEducationController::class)
        ->except('show')
        ->parameters(['media-edukasi' => 'mediaEducation']);

    // Diskusi (jawab pertanyaan pengunjung)
    Route::get('/diskusi', [DiscussionController::class, 'index'])->name('discussions.index');
    Route::get('/diskusi/{discussion}/jawab', [DiscussionController::class, 'edit'])->name('discussions.edit');
    Route::put('/diskusi/{discussion}', [DiscussionController::class, 'update'])->name('discussions.update');
    Route::delete('/diskusi/{discussion}', [DiscussionController::class, 'destroy'])->name('discussions.destroy');

    // Kelola akun admin lain
    Route::resource('kelola-admin', UserController::class)
        ->except('show')
        ->parameters(['kelola-admin' => 'admin']);
});
