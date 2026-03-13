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
        $like = Like::where('user_id', $userId)
                    ->where('item_id', $itemId)
                    ->first();

        if ($like) {
            $like->delete();
        }
        else {
            Like::create([
                'user_id' => $userId,
                'item_id' => $itemId,
            ]);
        }

        return redirect()->back();
    }
}
