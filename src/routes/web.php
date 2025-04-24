<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
use App\Http\Requests\RegisterRequest;

// 🔓 認証不要のルート
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

// 🔐 認証が必要なルート
Route::middleware('auth')->group(function () {
    // 商品関連
    Route::get('/', [ItemController::class, 'index'])->name('items.index');
    Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('items.show');
    Route::get('/sell', [ItemController::class, 'create'])->name('create');
    Route::post('/sell', [ItemController::class, 'store'])->name('store');
    Route::post('/items/{item}/like', [ItemController::class, 'toggleLike'])->name('items.toggleLike');

    // コメント
    Route::post('/comment/store', [CommentController::class, 'store'])->name('comment.store');

    // マイページ／プロフィール
    Route::get('/mypage', [ProfileController::class, 'mypage'])->name('mypage');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');

    // 購入
    Route::get('/purchase/{item_id}', [OrderController::class, 'confirm'])->name('orders.confirm');
    Route::post('/purchase/{item_id}', [OrderController::class, 'store'])->name('orders.store');

    // 配送先住所（購入時）
    Route::get('/purchase/address/{item_id}', [ItemController::class, 'edit'])->name('purchase.address.edit');
    Route::post('/purchase/address/{item_id}', [ItemController::class, 'update'])->name('purchase.address.update');
});

Route::get('/products/search', [ItemController::class, 'index'])->name('items.search');
