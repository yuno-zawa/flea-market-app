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
            if (!Auth::check()) {
                // 未ログイン時はマイリストタブにアクセスできないようリダイレクト
                return redirect('/login');
            }
            // マイリスト
            $products = Item::with(['images', 'purchase'])
                ->whereHas('likes', function ($query) {
                    $query->where('user_id', Auth::id());
                })
                ->get();
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
    $item = Item::with(['images', 'user', 'purchase', 'comments.user'])->findOrFail($id);

    return view('item.show', compact('item'));
}
}