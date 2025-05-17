<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');

Route::middleware('auth')->group(function () {

    Route::get('/sell', [ItemController::class, 'create'])->name('items.create');
    Route::post('/sell', [ItemController::class, 'store']);

    Route::post('/items/register', [ItemController::class, 'store'])->name('items.store');

    Route::post('/like/{item}', [ItemController::class, 'toggleLike'])->name('items.toggleLike');

    Route::post('/comment/{item_id}', [CommentController::class, 'store'])->name('comment.store');

    Route::get('/mypage', [ProfileController::class, 'mypage'])->name('mypage');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/purchase/{item_id}', [OrderController::class, 'confirm'])->name('orders.confirm');
    Route::post('/purchase/{item_id}', [OrderController::class, 'store'])->name('orders.store');

    Route::get('/purchase/address/{item_id}', [ProfileController::class, 'editAddress'])->name('purchase.address.edit');
    Route::post('/purchase/address/{item_id}', [ProfileController::class, 'updateAddress'])->name('purchase.address.update');

    Route::get('/orders/success/{item_id}', [OrderController::class, 'success'])->name('orders.success');
});
