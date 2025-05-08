<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Models\Order;
use App\Models\Item;
use App\Models\Profile;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class OrderController extends Controller
{
    public function confirm($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        $address = $user->profile; // 住所情報は profile に保存されている想定

        return view('orders.confirm', compact('item', 'address'));
    }

    public function store(PurchaseRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        $profile = $user->profile;

        if ($item->order) {
            return back()->withErrors(['message' => 'すでに購入されています']);
        }

        if ($request->payment_method === 'credit') {
            // ✅ Stripe 決済（カード）
            Stripe::setApiKey(config('services.stripe.secret'));

            $session = Session::create([
                'payment_method_types' => ['card'],
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
                'success_url' => route('orders.success', ['item_id' => $item->id]),
                'cancel_url' => route('orders.confirm', ['item_id' => $item->id, 'payment_method' => 'credit']),
            ]);

            return redirect($session->url);
        }

        if ($request->payment_method === 'convenience') {
            // ✅ コンビニ払い（Stripeは使わず注文登録 → 完了）
            Order::create([
                'user_id' => Auth::id(),
                'item_id' => $item->id,
                'payment_method' => $request->payment_method,
                'zipcode' => $profile->zipcode,
                'address' => $profile->address,
                'building' => $profile->building,
            ]);

            return redirect()->route('orders.success', ['item_id' => $item->id]);
        }

        return back()->withErrors(['payment_method' => '支払い方法を選択してください']);
    }

    public function success($item_id)
    {
        $item = Item::findOrFail($item_id);

        return view('orders.success', compact('item'));
    }

}
