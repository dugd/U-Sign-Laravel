<?php

use App\Http\Controllers\GestureController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

use App\Http\Middleware\MegaAuth;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('gestures', GestureController::class)->only(['index', 'show']);
// Secure
Route::get('/profile', [ProfileController::class, 'show'])->name('profile')->middleware(MegaAuth::class);
