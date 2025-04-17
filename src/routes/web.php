<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;

Route::get('/', [ItemController::class, 'index'])->name('index');

Route::get('/mypage', [ProfileController::class, 'mypage'])->name('mypage');

Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');

Route::get('/sell', [ItemController::class, 'create'])->name('create');

Route::get('/register', function () {return view('auth.register');})->name('register');

Route::get('/login', function () {return view('auth.login');})->name('login');
