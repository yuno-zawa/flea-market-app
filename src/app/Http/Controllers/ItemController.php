<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/register');
        }
        // 商品データの取得（後に実装）
        $products = [];

        return view('index', compact('products'));
    }
}
