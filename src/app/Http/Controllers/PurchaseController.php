<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\AddressRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class PurchaseController extends Controller
{
    public function show($itemId)
    {
        $item = Item::with(['images'])->findOrFail($itemId);

        if ($item->isSold()) {
            return redirect()->route('item.show', $itemId)->with('error', 'この商品は売り切れです');
        }

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

    public function purchase(Request $request, $itemId)
    {
        $item = Item::findOrFail($itemId);
        $user = Auth::user();

        if (!$request->payment_method) {
            return back()->with('error', '支払い方法を選択してください');
        }

        $shipping = [
            'postal_code' => session('shipping_postal_code', $user->postal_code),
            'address' => session('shipping_address', $user->address),
            'building' => session('shipping_building', $user->building),
        ];

        // セッションに購入情報を保存（Stripe決済完了後に使用）
        session([
            'purchase_item_id' => $item->id,
            'purchase_payment_method' => $request->payment_method,
            'purchase_shipping' => $shipping,
        ]);

        Stripe::setApiKey(config('stripe.secret'));

        $session = StripeSession::create([
            'payment_method_types' => $request->payment_method === 'card' ? ['card'] : ['konbini'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('purchase.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('purchase.show', $item->id),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(config('stripe.secret'));

        $session = StripeSession::retrieve($request->session_id);

        if ($session->payment_status === 'paid' || $session->status === 'complete') {
            $user = Auth::user();
            $shipping = session('purchase_shipping');

            Purchase::create([
                'user_id' => $user->id,
                'item_id' => session('purchase_item_id'),
                'payment_method' => session('purchase_payment_method'),
                'postal_code' => $shipping['postal_code'],
                'address' => $shipping['address'],
                'building' => $shipping['building'],
            ]);

            session()->forget(['purchase_item_id', 'purchase_payment_method', 'purchase_shipping']);
        }

        return redirect()->route('products.index')->with('success', '購入が完了しました');
    }

    public function editAddress($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        return view('purchase.address', compact('item', 'user'));
    }

    public function updateAddress(AddressRequest $request, $item_id)
    {
        session([
            'shipping_postal_code' => $request->postal_code,
            'shipping_address' => $request->address,
            'shipping_building' => $request->building,
        ]);

        return redirect()->route('purchase.show', $item_id)->with('success', '配送先を変更しました');
    }
}