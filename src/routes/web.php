<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\MypageController;

// 認証不要のルート
Route::get('/', [ItemController::class, 'index'])->name('products.index');
Route::get('/item/{id}', [ItemController::class, 'show'])->name('item.show');
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/login', [LoginController::class, 'store']);

// 認証必須のルート
Route::middleware('auth')->group(function () {
    // プロフィール
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // マイページ
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage.index');
    
    // いいね
    Route::post('/item/{id}/like', [LikeController::class, 'toggle'])->name('like.toggle');
    
    // コメント
    Route::post('/item/{item_id}/comment', [CommentController::class, 'store'])->name('comment.store');
    
    // 購入関連（配送先変更を先に定義）
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'editAddress'])->name('purchase.address.edit');
    Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress'])->name('purchase.address.update');
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'show'])->name('purchase.show');
});