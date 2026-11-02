<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KampusController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kota', [KotaController::class, 'index'])->name('kota');
Route::get('/kampus', [KampusController::class, 'index'])->name('kampus');
Route::get('/event', [EventController::class, 'index'])->name('event');
Route::view('/tentang', 'tentang')->name('tentang');
Route::get('/cari', [SearchController::class, 'index'])->name('cari');

Route::get('/event/{id}', [EventController::class, 'show'])->whereNumber('id')->name('event.show');
Route::post('/event/{id}/komentar', [EventController::class, 'komentar'])->whereNumber('id')->name('event.komentar');

Route::get('/post/{id}', [PostController::class, 'show'])->whereNumber('id')->name('post.show');
Route::post('/post/{id}/komentar', [PostController::class, 'komentar'])->whereNumber('id')->name('post.komentar');

Route::middleware('auth')->group(function () {
    Route::get('/buat', [PostController::class, 'create'])->name('post.create');
    Route::post('/buat', [PostController::class, 'store'])->name('post.store');
    Route::post('/post/{id}/suka', [PostController::class, 'suka'])->whereNumber('id')->name('post.suka');
    Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::post('/event/{id}/suka', [EventController::class, 'suka'])->whereNumber('id')->name('event.suka');
    Route::get('/post/{id}/edit', [PostController::class, 'edit'])->whereNumber('id')->name('post.edit');
    Route::put('/post/{id}', [PostController::class, 'update'])->whereNumber('id')->name('post.update');
    Route::get('/event/{id}/edit', [EventController::class, 'edit'])->whereNumber('id')->name('event.edit');
    Route::put('/event/{id}', [EventController::class, 'update'])->whereNumber('id')->name('event.update');
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
    Route::get('/notifikasi/{id}/baca', [NotifikasiController::class, 'baca'])->whereNumber('id')->name('notifikasi.baca');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
