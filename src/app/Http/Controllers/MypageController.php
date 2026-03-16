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

        $listedItems = Item::with(['images', 'purchase'])
            ->where('user_id', $user->id)
            ->get();

        $purchasedItems = Item::with(['images', 'purchase'])
            ->whereHas('purchase', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();

        return view('mypage.index', compact('user', 'listedItems', 'purchasedItems'));
    }
}
