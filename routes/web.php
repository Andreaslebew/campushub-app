<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\KampusController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PostController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/kota', [KotaController::class, 'index']);       // Menangani filter & sorting via Request
Route::get('/kampus', [KampusController::class, 'index']);   // Menangani filter & sorting via Request
Route::get('/search', [SearchController::class, 'index']);   // Pencarian
Route::get('/post/{id}', [PostController::class, 'show']);   // Detail postingan & komentar
Route::get('/tentang', [HomeController::class, 'tentang']);
