<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SignController;
use App\Http\Controllers\ProfileController;

use App\Http\Middleware\MegaAuth;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('signes', SignController::class)->name('index', 'signes');

// Secure
Route::get('/profile', [ProfileController::class, 'show'])->name('profile')->middleware(MegaAuth::class);

Route::get('/{welcome}', [HomeController::class, 'custom']);
