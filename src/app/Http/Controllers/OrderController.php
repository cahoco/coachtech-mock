<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use App\Models\Order;
use App\Models\Item;
use App\Models\Profile;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class OrderController extends Controller
{
    public function confirm(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        $address = $user->profile;
        $payment_method = $request->query('payment_method');
        return view('orders.confirm', compact('item', 'address', 'payment_method'));
    }

    public function store(PurchaseRequest $request, $item_id)
    {
        \Log::debug('Current ENV: ' . App::environment());
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        $profile = $user->profile;
        if ($item->order) {
            return back()->withErrors(['message' => 'すでに購入されています']);
        }
        // テスト環境ではStripe決済をスキップして保存
        if (App::environment('testing')) {
            \Log::debug('Creating order with:', [
                'user_id' => $user->id,
                'item_id' => $item->id,
                'payment_method' => $request->payment_method,
                'zipcode' => $request->zipcode ?? $profile->zipcode,
                'address' => $request->address ?? $profile->address,
                'building' => $request->building ?? $profile->building,
            ]);
            Order::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
                'payment_method' => $request->payment_method,
                'zipcode' => $request->zipcode ?? $profile->zipcode,
                'address' => $request->address ?? $profile->address,
                'building' => $request->building ?? $profile->building,
            ]);
            return redirect()->route('orders.success', ['item_id' => $item_id]);
        }
        if ($request->payment_method === 'credit') {
            Stripe::setApiKey(config('services.stripe.secret'));
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'unit_amount' => $item->price,
                        'product_data' => [
                            'name' => $item->name,
                        ],
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('orders.success', ['item_id' => $item_id]),
                'cancel_url' => url()->previous(),
            ]);
            return redirect($session->url);
        }
        if ($request->payment_method === 'convenience') {
            Order::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
                'payment_method' => 'convenience',
                'zipcode' => $profile->zipcode,
                'address' => $profile->address,
                'building' => $profile->building,
            ]);
            return redirect()->route('orders.success', ['item_id' => $item_id]);
        }
        return back()->withErrors(['payment_method' => '支払い方法を選択してください']);
    }

    public function success($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        $profile = $user->profile;

        if (!$item->order) {
            Order::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
                'payment_method' => 'credit',
                'zipcode' => $profile->zipcode,
                'address' => $profile->address,
                'building' => $profile->building,
            ]);
        }

        return view('orders.success', compact('item'));
    }

}
