<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle($itemId)
    {
        $userId = Auth::id();
        
        // 既にいいねしているか確認
        $like = Like::where('user_id', $userId)
                    ->where('item_id', $itemId)
                    ->first();
        
        if ($like) {
            // いいね済み → 削除
            $like->delete();
        } else {
            // 未いいね → 追加
            Like::create([
                'user_id' => $userId,
                'item_id' => $itemId,
            ]);
        }
        
        return back();
    }
}
