<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;

Route::get('/', [ItemController::class, 'index'])->name('index');

Route::get('/mypage', [ProfileController::class, 'mypage'])->name('mypage');

Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');