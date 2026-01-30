<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController;

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
