<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Requests\RegisterRequest;

// 認証不要のルート
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

// 🔐 認証が必要なルートはまとめてここに
Route::middleware('auth')->group(function () {
    Route::get('/', [ItemController::class, 'index'])->name('items.index');
    Route::get('/mypage', [ProfileController::class, 'mypage'])->name('mypage');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/sell', [ItemController::class, 'create'])->name('create');
    Route::post('/sell', [ItemController::class, 'store'])->name('store');
});

Route::post('/items/store', [ItemController::class, 'store'])->name('items.store');

Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');

Route::post('/comment/store', [CommentController::class, 'store'])->name('comment.store');