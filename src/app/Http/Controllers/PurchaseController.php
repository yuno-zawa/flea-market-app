<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Http\Requests\AddressRequest; // ← 追加

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
        $shipping = [
        'postal_code' => session('shipping_postal_code', $user->postal_code),
        'address' => session('shipping_address', $user->address),
        'building' => session('shipping_building', $user->building),
        ];
        
        return view('purchase.show', compact('item', 'user', 'shipping'));
    }
    
    // ↓↓↓ ここから追加 ↓↓↓
    
    // 配送先変更画面を表示
    public function editAddress($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        
        return view('purchase.address', compact('item', 'user'));
    }
    
    // 配送先を更新して購入画面に戻る
public function updateAddress(AddressRequest $request, $item_id)
{
    // セッションに配送先情報を保存
    session([
        'shipping_postal_code' => $request->postal_code,
        'shipping_address' => $request->address,
        'shipping_building' => $request->building,
    ]);
    
    return redirect()->route('purchase.show', $item_id)->with('success', '配送先を変更しました');
}
}