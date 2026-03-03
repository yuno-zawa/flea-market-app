<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->query('tab') == 'mylist') {
            if (!Auth::check()) {
                session()->put('url.intended', $request->fullUrl());
                return redirect()->route('login');
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

    public function create()
    {
        $categories = Category::all();
        return view('item.create', compact('categories'));
    }

    // 商品を出品
    public function store(ExhibitionRequest $request)
    {
        // 商品情報を保存
        $item = new Item();
        $item->user_id = Auth::id();
        $item->name = $request->name;
        $item->brand = $request->brand;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->condition = $request->condition;
        $item->save();

        // 商品画像を保存
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('item_images', 'public');
            $item->images()->create(['path' => 'storage/' . $path]);
        }

        // カテゴリーを紐付け
        $item->categories()->attach($request->categories);

        return redirect()->route('products.index')->with('success', '商品を出品しました');
    }
}