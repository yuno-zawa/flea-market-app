<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LikeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/', [ItemController::class, 'index']);
Route::get('/mypage/profile', [ProfileController::class, 'edit'])->middleware('auth');
Route::patch('/mypage/profile', [ProfileController::class, 'update'])->middleware('auth')->name('profile.update');
Route::post('/login', [LoginController::class, 'store']);
Route::get('/', [ItemController::class, 'index'])->name('products.index');
Route::get('/item/{id}', [ItemController::class, 'show'])->name('item.show');
// いいね機能（認証必須）
Route::post('/item/{id}/like', [LikeController::class, 'toggle'])->middleware('auth')->name('like.toggle');
