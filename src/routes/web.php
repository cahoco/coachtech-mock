<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Requests\RegisterRequest;

    Route::get('/', [AuthController::class, 'index'])->name('items.index');

Route::get('/mypage', [ProfileController::class, 'mypage'])->name('mypage');

Route::middleware('auth')->group(function () {
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/sell', [ItemController::class, 'create'])->name('create');

Route::get('/register', function () {return view('auth.register');})->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', function () {return view('auth.login');})->name('login');
Route::post('/login', [AuthController::class, 'login']);