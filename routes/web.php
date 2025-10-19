<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GestureController as AdminGestureController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

use App\Http\Controllers\My\GestureController as MyGestureController;

use App\Http\Controllers\GestureController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;

use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('gestures', GestureController::class)
        ->parameters(['gestures' => 'gesture'])
        ->only(['create', 'store', 'edit', 'update', 'destroy'])
        ->names('gestures');
});

Route::middleware('auth')->group(function () {
    Route::post('/gestures/{gesture}/comments', [CommentController::class, 'store'])
        ->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');
});

Route::resource('gestures', GestureController::class)
    ->parameters(['gestures' => 'gesture'])
    ->only(['index', 'show'])
    ->names('gestures');

Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/media', [MediaController::class, 'store'])->name('media.store');
    Route::delete('/media/{mediaId}', [MediaController::class, 'destroy'])->name('media.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::prefix('admin')->as('admin.')
    ->middleware(['auth', 'can:admin'])
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', AdminUserController::class)
            ->parameters(['users' => 'user'])
            ->names('users');
        Route::resource('gestures', AdminGestureController::class)
            ->parameters(['gestures' => 'gesture'])
            ->names('gestures');
    });

Route::middleware('auth')->prefix('my')->as('my.')->group(function () {
    Route::get('/gestures', [MyGestureController::class, 'index'])->name('gestures.index');
});

Route::middleware('auth')->prefix('subscription')->as('subscription.')->group(function () {
    Route::get('/', [SubscriptionController::class, 'index'])->name('index');
    Route::post('/switch', [SubscriptionController::class, 'switch'])->name('switch');
    Route::post('/cancel', [SubscriptionController::class, 'cancel'])->name('cancel');
    Route::get('/history', [SubscriptionController::class, 'history'])->name('history');
});

require __DIR__.'/auth.php';
