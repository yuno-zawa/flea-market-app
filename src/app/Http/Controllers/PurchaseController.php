<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\user;

class PurchaseController extends Controller
{
    // 商品購入画面表示
    public function show($itemId)
    {
        $item = Item::with(['images'])->findOrFail($itemId);
        
        // 購入済みの商品は購入できない
        if ($item->isSold()) {
            return redirect()->route('item.show', $itemId)->with('error', 'この商品は売り切れです');
        }
        
        // 自分が出品した商品は購入できない
        if ($item->user_id == Auth::id()) {
            return redirect()->route('item.show', $itemId)->with('error', '自分の商品は購入できません');
        }
        
        $user = Auth::user();
        
        return view('purchase.show', compact('item', 'user'));
    }
}
