<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->query('tab') == 'mylist') {
            // マイリスト（後で実装）
            $products = [];
        } else {
            // おすすめタブ：全商品を取得
            $products = Item::with(['images', 'purchase'])
                ->when(Auth::check(), function ($query) {
                    // ログイン中は自分が出品した商品を除外（要件4）
                    return $query->where('user_id', '!=', Auth::id());
                })
                ->get();
        }

        return view('index', compact('products'));
    }

    public function show($id)
{
    $item = Item::with(['images', 'user', 'purchase'])->findOrFail($id);

    return view('item.show', compact('item'));
}
}