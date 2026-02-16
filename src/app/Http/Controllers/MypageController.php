<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // 出品した商品
        $listedItems = Item::with(['images', 'purchase'])
            ->where('user_id', $user->id)
            ->get();

        // 購入した商品
        $purchasedItems = Item::with(['images', 'purchase'])
            ->whereHas('purchase', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();

        return view('mypage.index', compact('user', 'listedItems', 'purchasedItems'));
    }
}
