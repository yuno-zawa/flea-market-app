<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
{
    if (!Auth::check() && $request->query('tab') != 'mylist') {
        // 未認証でおすすめタブの場合のみ表示可能
    }

    if ($request->query('tab') == 'mylist') {
        // マイリストの商品取得（後で実装）
        $products = [];
    } else {
        // 全商品取得
        $products = Item::with('images')->get();
    }

    return view('index', compact('products'));
}
}
